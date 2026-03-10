<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->paginate(10);
        return view('pages.dashboard.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pages.dashboard.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'isi'              => 'required|string',
            'prioritas'        => 'nullable|in:rendah,sedang,tinggi',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif'            => 'boolean',
        ]);

        Pengumuman::create([
            'judul'            => $request->judul,
            'isi'              => $request->isi,
            'prioritas'        => $request->prioritas,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'aktif'            => $request->aktif ?? 0,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman ditambahkan!');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.dashboard.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'isi'              => 'required|string',
            'prioritas'        => 'nullable|in:rendah,sedang,tinggi',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif'            => 'boolean',
        ]);

        $pengumuman                   = Pengumuman::findOrFail($id);
        $pengumuman->judul            = $request->judul;
        $pengumuman->isi              = $request->isi;
        $pengumuman->prioritas        = $request->prioritas;
        $pengumuman->tanggal_mulai    = $request->tanggal_mulai;
        $pengumuman->tanggal_berakhir = $request->tanggal_berakhir;
        $pengumuman->aktif            = $request->aktif ?? 0;
        $pengumuman->save();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman diperbarui!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman dihapus!');
    }

    // API untuk Flutter
    public function apiIndex()
    {
        $pengumuman = Pengumuman::aktif()->latest()->get();
        return response()->json([
            'status' => 'success',
            'data'   => $pengumuman,
        ]);
    }

    public function apiShow($id)
    {
        $item = Pengumuman::findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $item]);
    }
}