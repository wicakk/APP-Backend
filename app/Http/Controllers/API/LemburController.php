<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PengajuanLembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LemburController extends Controller
{
    // =========================================================
    // API - PEGAWAI (Mobile)
    // =========================================================

    public function index()
    {
        $data = PengajuanLembur::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(fn($item) => $this->formatItem($item));

        return response()->json(['berhasil' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_lembur' => 'required|date',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i',
            'alasan'         => 'required|string|min:5',
            'file'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'berhasil' => false,
                'pesan'    => $validator->errors()->first(),
                'errors'   => $validator->errors(),
            ], 422);
        }

        $lembur = PengajuanLembur::create([
            'user_id'        => auth()->id(),
            'tanggal_lembur' => $request->tanggal_lembur,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'total_jam'      => PengajuanLembur::hitungTotalJam($request->jam_mulai, $request->jam_selesai),
            'alasan'         => $request->alasan,
            'file'           => $request->hasFile('file')
                                    ? $request->file('file')->store('lembur', 'public')
                                    : null,
            'status'         => 'pending',
        ]);

        return response()->json([
            'berhasil' => true,
            'pesan'    => 'Pengajuan lembur berhasil dikirim',
            'data'     => $lembur,
        ], 201);
    }

    // =========================================================
    // WEB ADMIN
    // =========================================================

    public function adminIndex()
    {
        return view('pages.dashboard.pengajuan.lembur.index', [
            'pengajuan'      => PengajuanLembur::with('pegawai')->latest()->paginate(15),
            'totalPending'   => PengajuanLembur::where('status', 'pending')->count(),
            'totalDisetujui' => PengajuanLembur::where('status', 'disetujui')->count(),
            'totalDitolak'   => PengajuanLembur::where('status', 'ditolak')->count(),
        ]);
    }

    public function setujui(Request $request, $id)
    {
        PengajuanLembur::findOrFail($id)->update([
            'status'         => 'disetujui',
            'disetujui_oleh' => auth()->id(),
            'disetujui_pada' => now(),
        ]);

        return $this->respond('Lembur berhasil disetujui');
    }

    public function tolak(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'catatan_penolakan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $request->expectsJson()
                ? response()->json(['berhasil' => false, 'pesan' => 'Catatan penolakan wajib diisi'], 422)
                : back()->withErrors($validator);
        }

        PengajuanLembur::findOrFail($id)->update([
            'status'            => 'ditolak',
            'catatan_penolakan' => $request->catatan_penolakan,
            'disetujui_oleh'    => auth()->id(),
            'disetujui_pada'    => now(),
        ]);

        return $this->respond('Lembur berhasil ditolak');
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    private function formatItem(PengajuanLembur $item): array
    {
        return [
            'id'                => $item->id,
            'tanggal_lembur'    => $item->tanggal_lembur->format('d M Y'),
            'jam_mulai'         => $item->jam_mulai,
            'jam_selesai'       => $item->jam_selesai,
            'total_jam'         => $item->total_jam,
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
            'tanggal_lembur.required' => 'Tanggal lembur wajib diisi',
            'jam_mulai.required'      => 'Jam mulai wajib diisi',
            'jam_selesai.required'    => 'Jam selesai wajib diisi',
            'alasan.required'         => 'Alasan wajib diisi',
            'alasan.min'              => 'Alasan minimal 5 karakter',
            'file.mimes'              => 'File harus berformat PDF, JPG, atau PNG',
            'file.max'                => 'Ukuran file maksimal 2MB',
        ];
    }

    private function respond(string $pesan)
    {
        return request()->expectsJson()
            ? response()->json(['berhasil' => true, 'pesan' => $pesan])
            : back()->with('success', $pesan);
    }
}
