<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Pegawai;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:pegawais',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $pegawai = Pegawai::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $pegawai->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data'         => $pegawai,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $pegawai = Pegawai::where('email', $request->email)->first();

        if (!$pegawai || !Hash::check($request->password, $pegawai->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $pegawai->createToken('auth_token')->plainTextToken;
        $pegawai->token      = $token;
        $pegawai->token_type = 'Bearer';

        return response()->json([
            'success' => true,
            'message' => 'Hi ' . $pegawai->name . ', selamat datang di sistem presensi',
            'data'    => $pegawai
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function ubahPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password_baru'  => 'required|min:6',
        ], [
            'password_lama.required' => 'Password lama wajib diisi',
            'password_baru.required' => 'Password baru wajib diisi',
            'password_baru.min'      => 'Password baru minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = $request->user();

        // Cek password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai'
            ], 422);
        }

        // Cek konfirmasi password
        if ($request->password_baru !== $request->password_baru_confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'Konfirmasi password tidak cocok'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}
