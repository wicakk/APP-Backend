<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * GET PRESENSI PEGAWAI LOGIN
     */
    public function getPresensis()
    {
        $pegawai = Auth::user();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $presensis = $pegawai->presensis()
            ->orderBy('tanggal', 'desc')
            ->get();

        $presensis->transform(function ($item) {

            $item->is_hari_ini = Carbon::parse($item->tanggal)->isToday();

            $tanggal = Carbon::parse($item->tanggal)->locale('id');
            $item->tanggal_format = $tanggal->translatedFormat('l, j F Y');

            $item->masuk_format = $item->masuk
                ? Carbon::parse($item->masuk)->format('H:i')
                : null;

            $item->pulang_format = $item->pulang
                ? Carbon::parse($item->pulang)->format('H:i')
                : null;

            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Sukses menampilkan data presensi',
            'data'    => $presensis
        ]);
    }

    /**
     * SAVE PRESENSI (Masuk / Pulang)
     */
    public function savePresensi(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $pegawai = Auth::guard('pegawai')->user();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $today = Carbon::today();

        $presensi = $pegawai->presensis()
            ->whereDate('tanggal', $today)
            ->first();

        // ================= ABSEN MASUK =================
        if (!$presensi) {

            $presensi = $pegawai->presensis()->create([
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'tanggal'   => $today,
                'masuk'     => Carbon::now(),
                'pulang'    => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sukses absen masuk',
                'data'    => $presensi
            ], 201);
        }

        // ================= ABSEN PULANG =================
        if ($presensi->pulang === null) {

            $presensi->update([
                'pulang' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sukses absen pulang',
                'data'    => $presensi
            ]);
        }

        // ================= SUDAH ABSEN =================
        return response()->json([
            'success' => false,
            'message' => 'Anda sudah absen masuk & pulang hari ini'
        ], 409);
    }
}
