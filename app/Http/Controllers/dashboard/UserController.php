<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signin(){
        return view('pages.auth.signin');
    }

    public function postsignin(Request $request)
    {
    $request->validate([
        'email'    => 'required|email|max:255',
        'password' => 'required|string|max:255',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {

        $adminEmail = config('app.admin_email', 'admin@admin.com');

        if (Auth::user()->email !== $adminEmail) {
            Auth::logout();
            return redirect('/signin')->with('error', 'Akun ini tidak memiliki akses.');
        }

        return redirect('/dashboard');
    }

    return redirect('/signin')->with('error', 'Email atau password salah!');
    }

    public function logout(){
        Auth::logout();
        return redirect ('/');
    }
}
