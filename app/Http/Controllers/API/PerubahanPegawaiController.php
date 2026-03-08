<?php
// app/Http/Controllers/PerubahanPegawaiController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PerubahanPegawai;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PerubahanPegawaiController extends Controller
{
    // ===== FORM PENGAJUAN (API) =====
    public function ajukan(Request $request)
    {
        $request->validate([
            'name'          => 'nullable|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            // Sesudah
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',  // ← fix
            'foto'          => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'catatan'       => 'nullable|string',
        ], [
            'no_hp.max'                 => 'No HP maksimal 20 karakter',
            // Sesudah
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir.date_format' => 'Format tanggal lahir harus YYYY-MM-DD, contoh: 1995-06-15',
            'foto.mimes'                => 'Format foto harus jpg atau png',
            'foto.max'                  => 'Ukuran foto maksimal 2MB',
        ]);

        // Upload foto jika ada
        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('foto/pegawai', 'public');
        }

        $pengajuan = PerubahanPegawai::create([
            'pegawai_id'    => Auth::id(),
            'name'          => $request->name,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto'          => $pathFoto,
            'catatan'       => $request->catatan,
            'status'        => 'pending',
        ]);

        return response()->json([
            'berhasil' => true,
            'pesan'    => 'Pengajuan perubahan data berhasil dikirim',
            'data'     => $pengajuan,
        ], 201);
    }

    // ===== RIWAYAT PENGAJUAN (API) =====
    public function riwayat()
    {
        $data = PerubahanPegawai::where('pegawai_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id'                => $item->id,
                    'name'              => $item->name,
                    'no_hp'             => $item->no_hp,
                    'alamat'            => $item->alamat,
                    'jenis_kelamin'     => $item->jenis_kelamin,
                    'tanggal_lahir'     => $item->tanggal_lahir
                        ? Carbon::parse($item->tanggal_lahir)->format('d M Y')
                        : null,
                    'foto'              => $item->foto
                        ? asset('storage/' . $item->foto)
                        : null,
                    'catatan'           => $item->catatan,
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

    // ===== DASHBOARD ADMIN (WEB) =====
    public function indexAdmin()
    {
        $pengajuan      = PerubahanPegawai::with('pegawai')->latest()->get();
        $totalPending   = $pengajuan->where('status', 'pending')->count();
        $totalDisetujui = $pengajuan->where('status', 'disetujui')->count();
        $totalDitolak   = $pengajuan->where('status', 'ditolak')->count();

        return view('pages.dashboard.pengajuan.perubahan-pegawai.index', compact(
            'pengajuan',
            'totalPending',
            'totalDisetujui',
            'totalDitolak'
        ));
    }

    // ===== SETUJUI (WEB) =====
    public function setujui($id)
    {
        $pengajuan = PerubahanPegawai::with('pegawai')->findOrFail($id);

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses');
        }

        // Update data pegawai dengan data baru (hanya field yang diisi)
        $dataUpdate = array_filter([
            'name'          => $pengajuan->name,
            'no_hp'         => $pengajuan->no_hp,
            'alamat'        => $pengajuan->alamat,
            'jenis_kelamin' => $pengajuan->jenis_kelamin,
            'tanggal_lahir' => $pengajuan->tanggal_lahir,
            'foto'          => $pengajuan->foto,
        ], fn($value) => !is_null($value) && $value !== '');

        $pengajuan->pegawai->update($dataUpdate);

        // Update status pengajuan
        $pengajuan->update([
            'status'        => 'disetujui',
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
        ]);

        return back()->with('success', 'Perubahan data pegawai berhasil disetujui dan diterapkan');
    }

    // ===== TOLAK (WEB) =====
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string',
        ], [
            'catatan_penolakan.required' => 'Catatan penolakan wajib diisi',
        ]);

        $pengajuan = PerubahanPegawai::findOrFail($id);

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses');
        }

        $pengajuan->update([
            'status'            => 'ditolak',
            'diproses_oleh'     => Auth::id(),
            'diproses_pada'     => now(),
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        return back()->with('error', 'Pengajuan perubahan data berhasil ditolak');
    }
}
