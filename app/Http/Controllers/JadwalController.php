<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();
        return view('pages.dashboard.jadwal-kerja.index', compact('jadwals'));
    }

    public function create()
    {
        return view('pages.dashboard.jadwal-kerja.create-jadwal');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari'       => 'required|string',
            'jam_masuk'  => 'required',
            'jam_pulang' => 'required',
            'durasi'     => 'required|string',
        ]);

        Jadwal::create($request->only(['hari', 'jam_masuk', 'jam_pulang', 'durasi']));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('pages.dashboard.jadwal-kerja.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari'       => 'required|string',
            'jam_masuk'  => 'required',
            'jam_pulang' => 'required',
            'durasi'     => 'required|string',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->only(['hari', 'jam_masuk', 'jam_pulang', 'durasi']));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }


    public function apiIndex()
    {
        $jadwals = Jadwal::all();
        return response()->json([
            'success' => true,
            'data' => $jadwals
        ]);
    }
}