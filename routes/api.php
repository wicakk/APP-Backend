<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PresensiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\API\CutiController;
use App\Http\Controllers\API\PerubahanPegawaiController;
use App\Http\Controllers\API\LemburController;
use App\Http\Controllers\API\PengajuanAbsensiController;
use App\Http\Controllers\PengumumanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| API untuk Mobile (Flutter)
| Menggunakan Sanctum Authentication
*/

// ================= PUBLIC =================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ================= PROTECTED =================
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-presensi', [PresensiController::class, 'getPresensis']);
    Route::post('/save-presensi', [PresensiController::class, 'savePresensi']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/jadwal', [JadwalController::class, 'apiIndex']); 

    // settings
    Route::post('/ubah-password', [AuthController::class, 'ubahPassword']);
    Route::get('/pegawai/profile', [PegawaiController::class, 'apiProfile']);


    // cuti
    Route::post('/ajukan-cuti', [CutiController::class, 'ajukanCuti']);
    Route::get('/riwayat-cuti', [CutiController::class, 'listCuti']);

    // perubahan data pegawai
    Route::post('/perubahan-data/ajukan',  [PerubahanPegawaiController::class, 'ajukan']);
    Route::get('/perubahan-data/riwayat',  [PerubahanPegawaiController::class, 'riwayat']);

    // lembur
    Route::post('/ajukan-lembur', [LemburController::class, 'store']);
    Route::get('/riwayat-lembur', [LemburController::class, 'index']);

    // pengajuan absensi
    Route::post('/ajukan-absensi', [PengajuanAbsensiController::class, 'store']); 
    Route::get('/riwayat-absensi', [PengajuanAbsensiController::class, 'index']); 


    // pengumuman
     Route::get('/pengumuman', [PengumumanController::class, 'apiIndex']);
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'apiShow']);
});

