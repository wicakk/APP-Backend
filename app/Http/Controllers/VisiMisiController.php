<?php

namespace App\Http\Controllers;

use App\Models\Misi;
use App\Models\Visi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisiMisiController extends Controller
{
    public function visi()
    {
        $visis = Visi::paginate(12);
        return view('pages.dashboard.visi.index', compact('visis'));
    }

    public function create_visi()
    {
        return view('pages.dashboard.visi.create');
    }

    public function store_visi(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:visis,slug',
            'deskripsi' => 'nullable|string|max:5000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoName = 'noimage.png';

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = $foto->hashName();
            $foto->storeAs('public', $fotoName);
        }

        Visi::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoName,
        ]);

        return redirect()->route('visi.index')->with('success', 'Add Visi Success');
    }



    public function edit_visi(Visi $visi)
    {
        return view('pages.dashboard.visi.edit', compact('visi'));
    }

    public function update_visi(Request $request, Visi $visi)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:5000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $visi->title = $request->title;
        $visi->slug = $request->slug;
        $visi->deskripsi = $request->deskripsi;

        if ($request->file('foto')) {

            if ($visi->foto !== "noimage.png") {
                Storage::disk('public')->delete('public/' . $visi->foto);
            }

            $foto = $request->file('foto');
            $foto->storeAs('public', $foto->hashName());
            $visi->foto = $foto->hashName();
        }

        $visi->update();

        return redirect()->route('visi.index')->with('success', 'Update visi Success');
    }


    public function destroy_visi(Visi $visi)
    {
        if ($visi->foto !== "noimage.png") {
            Storage::disk('public')->delete($visi->foto);
        }

        $visi->delete();

        return redirect()->route('visi.index')->with('success', 'Delete visi Success');
    }





    public function misi()
    {
        $misis = Misi::paginate(12);
        return view('pages.dashboard.misi.index', compact('misis'));
    }

    public function create_misi()
    {
        return view('pages.dashboard.misi.create');
    }

    public function store_misi(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:5000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoName = 'noimage.png';

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = $foto->hashName();
            $foto->storeAs('public', $fotoName);
        }

        Misi::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoName, // 🔥 FIX DI SINI
        ]);

        return redirect()->route('misi.index')->with('success', 'Add misi Success');
    }

    public function edit_misi(Misi $misi)
    {
        return view('pages.dashboard.misi.edit', compact('misi'));
    }

    public function update_misi(Request $request, Misi $misi)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:5000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $misi->title = $request->title;
        $misi->slug = $request->slug;
        $misi->deskripsi = $request->deskripsi;

        if ($request->file('foto')) {

            if ($misi->foto !== "noimage.png") {
                Storage::disk('public')->delete($misi->foto);
            }

            $foto = $request->file('foto');
            $foto->storeAs('public', $foto->hashName());
            $misi->foto = $foto->hashName();
        }

        $misi->update();

        return redirect()->route('misi.index')->with('success', 'Update misi Success');
    }


    public function destroy_misi(Misi $misi)
    {
        if ($misi->foto !== "noimage.png") {
            Storage::disk('public')->delete($misi->foto);
        }

        $misi->delete();

        return redirect()->route('misi.index')->with('success', 'Delete misi Success');
    }
}
