<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Departemen;
use App\Models\Presensi;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
       $query = Pegawai::with(['jabatan', 'departemen']); // relasi

    // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('nip', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        // Pagination
        $pegawais = $query->latest()->paginate(10)->withQueryString();

        return view('pages.dashboard.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        $departemens = Departemen::all();
        return view('pages.dashboard.pegawai.create-pegawai', compact('jabatans', 'departemens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'            => 'required|string|max:20|unique:pegawais,nip',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:pegawais,email',
            'password'       => 'required|min:6|confirmed',
            'no_hp'          => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'tanggal_lahir'  => 'nullable|date',
            'jabatan_id'     => 'nullable|exists:jabatans,id',
            'departemen_id'  => 'nullable|exists:departemens,id',
            'tanggal_masuk'  => 'nullable|date',
            'status_pegawai' => 'required|in:aktif,nonaktif',
        ]);

        Pegawai::create($request->all()); // password otomatis di-hash di model

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function show(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $query = Presensi::where('user_id', $id);

        if ($request->from && $request->to) {
            $query->whereBetween('tanggal', [$request->from, $request->to]);
        }

        $total = (clone $query)->count();
        $hadir = (clone $query)->whereNotNull('masuk')->count();
        $tidak_hadir = $total - $hadir;
        $persentase = $total > 0 ? round(($hadir / $total) * 100) : 0;

        $chart = (clone $query)
            ->selectRaw('tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('pages.dashboard.pegawai.show', [
            'pegawai'      => $pegawai,
            'total'        => $total,
            'hadir'        => $hadir,
            'tidak_hadir'  => $tidak_hadir,
            'persentase'   => $persentase,
            'chartLabels'  => $chart->pluck('tanggal'),
            'chartData'    => $chart->pluck('total'),
        ]);
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatans = Jabatan::all();
        $departemens = Departemen::all();
        return view('pages.dashboard.pegawai.edit', compact('pegawai', 'jabatans', 'departemens'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nip'            => 'required|string|max:20|unique:pegawais,nip,' . $id,
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:pegawais,email,' . $id,
            'no_hp'          => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'tanggal_lahir'  => 'nullable|date',
            'jabatan_id'     => 'nullable|exists:jabatans,id',
            'departemen_id'  => 'nullable|exists:departemens,id',
            'tanggal_masuk'  => 'nullable|date',
            'status_pegawai' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $data['password'] = $request->password; // di-hash otomatis di model
        } else {
            unset($data['password']);
        }

        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pegawai::findOrFail($id)->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus!');
    }




    // API Endpoint untuk mendapatkan semua pegawai
     public function apiIndex()
    {
        $pegawais = Pegawai::all();
        return response()->json([
            'success' => true,
            'data' => $pegawais
        ]);
    }


    // Tambahkan setelah apiIndex

    public function apiProfile(Request $request)
    {
        try {
            $pegawai = $request->user()->load('jabatan', 'departemen');

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'             => $pegawai->id,
                    'nip'            => $pegawai->nip,
                    'name'           => $pegawai->name,
                    'email'          => $pegawai->email,
                    'no_hp'          => $pegawai->no_hp,
                    'alamat'         => $pegawai->alamat,
                    'jenis_kelamin'  => $pegawai->jenis_kelamin,
                    'tanggal_lahir'  => $pegawai->tanggal_lahir,
                    'tanggal_masuk'  => $pegawai->tanggal_masuk,
                    'status_pegawai' => $pegawai->status_pegawai,
                    'foto'           => $pegawai->foto ? asset('storage/' . $pegawai->foto) : null,
                    'jabatan'        => $pegawai->jabatan ? [
                        'id'           => $pegawai->jabatan->id,
                        'nama_jabatan' => $pegawai->jabatan->nama_jabatan,
                    ] : null,
                    'departemen'     => $pegawai->departemen ? [
                        'id'              => $pegawai->departemen->id,
                        'nama_departemen' => $pegawai->departemen->nama_departemen,
                    ] : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(), // ← ini akan tampil error detailnya
            ], 500);
        }
    }
}