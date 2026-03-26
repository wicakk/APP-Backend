<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\RequestsCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    // ================= AJUKAN CUTI (API) =================
    // POST /api/ajukann-cuti
    public function ajukanCuti(Request $request)
    {
        $request->validate([
            'jenis_cuti'    => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'        => 'required|string',
            'file'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'jenis_cuti.required'          => 'Jenis cuti wajib dipilih',
            'tanggal_mulai.required'       => 'Tanggal mulai wajib diisi',
            'tanggal_akhir.required'       => 'Tanggal akhir wajib diisi',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai',
            'alasan.required'              => 'Alasan wajib diisi',
            'file.mimes'                   => 'Format file harus jpg, png, atau pdf',
            'file.max'                     => 'Ukuran file maksimal 2MB',
        ]);

        // Hitung total hari
        $mulai     = Carbon::parse($request->tanggal_mulai);
        $akhir     = Carbon::parse($request->tanggal_akhir);
        $totalHari = $mulai->diffInDays($akhir) + 1;

        // Upload file jika ada
        $pathFile = null;
        if ($request->hasFile('file')) {
            $pathFile = $request->file('file')->store('berkas/cuti', 'public');
        }

        $cuti = RequestsCuti::create([
            'user_id'       => Auth::id(),
            'jenis_cuti'    => $request->jenis_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'total_hari'    => $totalHari,
            'alasan'        => $request->alasan,
            'file'          => $pathFile,
            'status'        => 'pending',
        ]);

        return response()->json([
            'berhasil' => true,
            'pesan'    => 'Pengajuan cuti berhasil dikirim, menunggu persetujuan',
            'data'     => $cuti,
        ], 201);
    }

    // ================= RIWAYAT CUTI (API) =================
    // GET /api/riwayat-cuti
    public function listCuti()
    {
        $data = RequestsCuti::where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id'                => $item->id,
                    'jenis_cuti'        => $item->jenis_cuti,
                    'tanggal_mulai'     => Carbon::parse($item->tanggal_mulai)->format('d M Y'),
                    'tanggal_akhir'     => Carbon::parse($item->tanggal_akhir)->format('d M Y'),
                    'total_hari'        => $item->total_hari,
                    'alasan'            => $item->alasan,
                    'file'              => $item->file ? asset('storage/' . $item->file) : null,
                    'status'            => $item->status,
                    'catatan_penolakan' => $item->catatan_penolakan,
                    'diajukan_pada'     => Carbon::parse($item->created_at)->format('d M Y'),
                ];
            });

        return response()->json([
            'berhasil' => true,
            'data'     => $data,
        ]);
    }

    // ================= DASHBOARD ADMIN (WEB) =================
    // GET /admin/cuti
    public function indexAdmin(Request $request)
    {
        $query = RequestsCuti::with('pegawai')->latest();

        // Jika ingin search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pegawai', function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('nip', 'like', "%$search%");
            });
        }

        $pengajuan = $query->paginate(10)->withQueryString(); // <-- ini Paginator

        // hitung status menggunakan collection dari hasil paginate
        $totalPending   = $pengajuan->where('status', 'pending')->count();
        $totalDisetujui = $pengajuan->where('status', 'disetujui')->count();
        $totalDitolak   = $pengajuan->where('status', 'ditolak')->count();

        return view('pages.dashboard.pengajuan.cuti.index', compact(
            'pengajuan',
            'totalPending',
            'totalDisetujui',
            'totalDitolak'
        ));
    }

    // ================= SETUJUI CUTI (WEB) =================
    // PUT /admin/cuti/setujui/{id}
    public function setujui($id)
    {
        $cuti = RequestsCuti::findOrFail($id);

        // Pastikan masih pending
        if ($cuti->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya');
        }

        $cuti->update([
            'status'         => 'disetujui',
            'disetujui_oleh' => Auth::id(),
            'disetujui_pada' => now(),
        ]);

        return back()->with('success', 'Pengajuan cuti berhasil disetujui');
    }

    // ================= TOLAK CUTI (WEB) =================
    // PUT /admin/cuti/tolak/{id}
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string',
        ], [
            'catatan_penolakan.required' => 'Catatan penolakan wajib diisi',
        ]);

        $cuti = RequestsCuti::findOrFail($id);

        // Pastikan masih pending
        if ($cuti->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya');
        }

        $cuti->update([
            'status'            => 'ditolak',
            'disetujui_oleh'    => Auth::id(),
            'disetujui_pada'    => now(),
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        return back()->with('error', 'Pengajuan cuti berhasil ditolak');
    }
}
