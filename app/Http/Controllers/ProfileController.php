<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // =================== PROFILE ===================
    public function index()
    {
        // Ambil profile pertama atau buat default jika belum ada
        $profile = Profile::firstOrCreate([], [
            'first_name' => 'Company',
            'last_name'  => 'Admin',
            'email'      => 'test@gmail.com',
            'phone'      => '62 9828 921',
            'bio'        => 'Company Profile Bio Saya',
            'facebook'   => 'tes',
            'x'          => 'test',
            'linkedin'   => 'test',
            'instagram'  => 'test',
            'country'    => 'test',
            'city'       => 'test',
        ]);

        return view('pages.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::firstOrFail();

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:100',
            'phone'      => 'nullable|string|max:20',
            'bio'        => 'nullable|string|max:255',
            'facebook'   => 'nullable|string|max:255',
            'x'          => 'nullable|string|max:255',
            'linkedin'   => 'nullable|string|max:255',
            'instagram'  => 'nullable|string|max:255',
            'country'    => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:255',
            'code'       => 'nullable|string|max:255',
            'tax'        => 'nullable|string|max:255',
        ]);

        // Konversi string kosong menjadi NULL
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);

        $profile->update($validated);

        return redirect()->route('pages.profile')
                         ->with('success', 'Profile berhasil diperbarui!');
    }

    // =================== JABATAN ===================
    public function jabatanIndex()
    {
        $jabatans = Jabatan::latest()->get();
        return view('pages.dashboard.jabatan.index', compact('jabatans'));
    }

    public function jabatanCreate()
    {
        return view('pages.dashboard.jabatan.create');
    }

    public function jabatanStore(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan',
        ]);

        Jabatan::create($request->only('nama_jabatan'));

        return redirect()->route('jabatan.index')
                         ->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function jabatanEdit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('pages.dashboard.jabatan.edit', compact('jabatan'));
    }

    public function jabatanUpdate(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan,' . $id,
        ]);

        $jabatan->update($request->only('nama_jabatan'));

        return redirect()->route('jabatan.index')
                         ->with('success', 'Jabatan berhasil diperbarui!');
    }

    public function jabatanDestroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')
                         ->with('success', 'Jabatan berhasil dihapus!');
    }

    // =================== DEPARTEMEN ===================
    public function departemenIndex()
    {
        $departemens = Departemen::latest()->get();
        return view('pages.dashboard.departemen.index', compact('departemens'));
    }

    public function departemenCreate()
    {
        return view('pages.dashboard.departemen.create');
    }

    public function departemenStore(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255|unique:departemens,nama_departemen',
        ]);

        Departemen::create($request->only('nama_departemen'));

        return redirect()->route('departemen.index')
                         ->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function departemenEdit($id)
    {
        $departemen = Departemen::findOrFail($id);
        return view('pages.dashboard.departemen.edit', compact('departemen'));
    }

    public function departemenUpdate(Request $request, $id)
    {
        $departemen = Departemen::findOrFail($id);

        $request->validate([
            'nama_departemen' => 'required|string|max:255|unique:departemens,nama_departemen,' . $id,
        ]);

        $departemen->update($request->only('nama_departemen'));

        return redirect()->route('departemen.index')
                         ->with('success', 'Departemen berhasil diperbarui!');
    }

    public function departemenDestroy($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();

        return redirect()->route('departemen.index')
                         ->with('success', 'Departemen berhasil dihapus!');
    }
}