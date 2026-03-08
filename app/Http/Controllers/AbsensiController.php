<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // public function index()
    // {
    //     // Ambil presensi + relasi pegawai
    //     $presensis = Presensi::with('pegawai')
    //                     ->orderBy('tanggal', 'desc')
    //                     ->get();

    //     foreach ($presensis as $item) {

    //         // Format tanggal
    //         $tanggal = Carbon::parse($item->tanggal)->locale('id');
    //         $item->tanggal_format = $tanggal->translatedFormat('l, j F Y');

    //         // Format jam masuk & pulang
    //         $item->masuk_format = $item->masuk 
    //             ? Carbon::parse($item->masuk)->format('H:i') 
    //             : null;

    //         $item->pulang_format = $item->pulang 
    //             ? Carbon::parse($item->pulang)->format('H:i') 
    //             : null;

    //         // Tambahkan nama pegawai biar gampang di blade
    //         $item->nama_pegawai = $item->pegawai->name ?? '-';
    //     }

    //     return view('pages.dashboard.absensi.index', compact('presensis'));
    // }
    public function index()
    {
        $presensi = Presensi::get();
        return view('pages.dashboard.absensi.index', compact('presensi'));
    }
}