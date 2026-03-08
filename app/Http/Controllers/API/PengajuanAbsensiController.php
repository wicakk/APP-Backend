<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PengajuanAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengajuanAbsensiController extends Controller
{
    // =========================================================
    // API - PEGAWAI (Mobile)
    // =========================================================

    public function index()
    {
        $data = PengajuanAbsensi::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(fn($item) => $this->formatItem($item));

        return $this->success($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_absensi' => 'required|date',
            'jam_masuk'       => 'nullable|date_format:H:i',
            'jam_keluar'      => 'nullable|date_format:H:i',
            'alasan'          => 'required|string|min:5',
            'file'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], $this->messages());

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422, $validator->errors());
        }

        if (!$request->jam_masuk && !$request->jam_keluar) {
            return $this->error('Minimal isi jam masuk atau jam keluar', 422);
        }

        $pengajuan = PengajuanAbsensi::create([
            'user_id'         => auth()->id(),
            'tanggal_absensi' => $request->tanggal_absensi,
            'jam_masuk'       => $request->jam_masuk,
            'jam_keluar'      => $request->jam_keluar,
            'alasan'          => $request->alasan,
            'file'            => $request->hasFile('file')
                                    ? $request->file('file')->store('pengajuan-absensi', 'public')
                                    : null,
            'status'          => 'pending',
        ]);

        return $this->success($pengajuan, 'Pengajuan absensi berhasil dikirim', 201);
    }

    // =========================================================
    // WEB ADMIN
    // =========================================================

    public function adminIndex()
    {
        return view('pages.dashboard.pengajuan.absensi.index', [
            'pengajuan'      => PengajuanAbsensi::with('pegawai')->latest()->paginate(15),
            'totalPending'   => PengajuanAbsensi::where('status', 'pending')->count(),
            'totalDisetujui' => PengajuanAbsensi::where('status', 'disetujui')->count(),
            'totalDitolak'   => PengajuanAbsensi::where('status', 'ditolak')->count(),
        ]);
    }

    public function setujui($id)
    {
        $pengajuan = PengajuanAbsensi::findOrFail($id);

        $pengajuan->update([
            'status'         => 'disetujui',
            'disetujui_oleh' => auth()->id(),
            'disetujui_pada' => now(),
        ]);

        $this->syncPresensi($pengajuan);

        return $this->respond('Pengajuan absensi berhasil disetujui');
    }

    public function tolak(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'catatan_penolakan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $request->expectsJson()
                ? $this->error('Catatan penolakan wajib diisi', 422)
                : back()->withErrors($validator);
        }

        PengajuanAbsensi::findOrFail($id)->update([
            'status'            => 'ditolak',
            'catatan_penolakan' => $request->catatan_penolakan,
            'disetujui_oleh'    => auth()->id(),
            'disetujui_pada'    => now(),
        ]);

        return $this->respond('Pengajuan absensi berhasil ditolak');
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    private function syncPresensi(PengajuanAbsensi $pengajuan): void
    {
        $jamMasuk  = $pengajuan->jam_masuk  ?: null;
        $jamKeluar = $pengajuan->jam_keluar ?: null;

        $existing = DB::table('presensis')
            ->where('user_id', $pengajuan->user_id)
            ->where('tanggal', $pengajuan->tanggal_absensi)
            ->first();

        if ($existing) {
            $update = array_filter([
                'masuk'  => $jamMasuk,
                'pulang' => $jamKeluar,
            ]);

            if ($update) {
                DB::table('presensis')
                    ->where('user_id', $pengajuan->user_id)
                    ->where('tanggal', $pengajuan->tanggal_absensi)
                    ->update($update);
            }
        } else {
            DB::table('presensis')->insert([
                'user_id'    => $pengajuan->user_id,
                'tanggal'    => $pengajuan->tanggal_absensi,
                'masuk'      => $jamMasuk,
                'pulang'     => $jamKeluar,
                'latitude'   => 0,
                'longitude'  => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function formatItem(PengajuanAbsensi $item): array
    {
        return [
            'id'                => $item->id,
            'tanggal_absensi'   => $item->tanggal_absensi->format('d M Y'),
            'jam_masuk'         => $item->jam_masuk ?? '-',
            'jam_keluar'        => $item->jam_keluar ?? '-',
            'alasan'            => $item->alasan,
            'file'              => $item->file ? Storage::url($item->file) : null,
            'status'            => $item->status,
            'catatan_penolakan' => $item->catatan_penolakan,
            'diajukan_pada'     => $item->created_at->format('d M Y'),
        ];
    }

    private function messages(): array
    {
        return [
            'tanggal_absensi.required' => 'Tanggal absensi wajib diisi',
            'alasan.required'          => 'Alasan wajib diisi',
            'alasan.min'               => 'Alasan minimal 5 karakter',
            'jam_masuk.date_format'    => 'Format jam masuk harus HH:MM',
            'jam_keluar.date_format'   => 'Format jam keluar harus HH:MM',
            'file.mimes'               => 'File harus berformat PDF, JPG, atau PNG',
            'file.max'                 => 'Ukuran file maksimal 2MB',
        ];
    }

    private function success($data = null, string $pesan = 'Berhasil', int $code = 200)
    {
        return response()->json(array_filter([
            'berhasil' => true,
            'pesan'    => $pesan,
            'data'     => $data,
        ]), $code);
    }

    private function error(string $pesan, int $code = 400, $errors = null)
    {
        return response()->json(array_filter([
            'berhasil' => false,
            'pesan'    => $pesan,
            'errors'   => $errors,
        ]), $code);
    }

    private function respond(string $pesanWeb)
    {
        return request()->expectsJson()
            ? $this->success(null, $pesanWeb)
            : back()->with('success', $pesanWeb);
    }
}
