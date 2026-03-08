@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-10 px-6">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl text-slate-800 font-semibold">
                        Pengajuan Perubahan Data Pegawai
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola dan proses pengajuan perubahan data pegawai
                    </p>
                </div>
                <div class="bg-blue-500 text-white text-md py-1 px-3 rounded-xl">
                    {{ now()->format('d M Y') }}
                </div>
            </div>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-5 py-3 rounded-xl">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-5 py-3 rounded-xl">
                    ❌ {{ session('error') }}
                </div>
            @endif

            {{-- STAT CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border border-slate-200 rounded-xl p-6">
                    <p class="text-xs text-slate-400 uppercase tracking-wide">Menunggu</p>
                    <p class="text-3xl text-slate-800 mt-2">{{ $totalPending }}</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-6">
                    <p class="text-xs text-slate-400 uppercase tracking-wide">Disetujui</p>
                    <p class="text-3xl text-slate-800 mt-2">{{ $totalDisetujui }}</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-6">
                    <p class="text-xs text-slate-400 uppercase tracking-wide">Ditolak</p>
                    <p class="text-3xl text-slate-800 mt-2">{{ $totalDitolak }}</p>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                    <h2 class="text-sm text-slate-700 font-medium">Daftar Pengajuan</h2>
                    <span class="text-xs text-slate-400">{{ $pengajuan->count() }} data</span>
                </div>

                <div class="overflow-x-auto">
                    <table id="tablePerubahan" class="w-full text-sm text-slate-700" style="width:100%">
                        <thead class="bg-slate-50 text-xs text-slate-500 uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">Pegawai</th>
                                <th class="px-4 py-3 text-left">Nama Baru</th>
                                <th class="px-4 py-3 text-left">No HP</th>
                                <th class="px-4 py-3 text-left">Alamat</th>
                                <th class="px-4 py-3 text-left">JK</th>
                                <th class="px-4 py-3 text-left">Tgl Lahir</th>
                                <th class="px-4 py-3 text-left">Foto</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($pengajuan as $item)
                                <tr class="hover:bg-slate-50 transition">

                                    {{-- Pegawai --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 bg-blue-500 rounded-lg flex items-center justify-center text-xs text-white font-bold">
                                                {{ strtoupper(substr($item->pegawai->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-slate-800 font-medium">{{ $item->pegawai->name ?? '-' }}</p>
                                                <p class="text-xs text-slate-400">{{ $item->pegawai->nip ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Nama Baru --}}
                                    <td class="px-4 py-3">
                                        @if($item->name)
                                            <p class="font-medium text-slate-800">{{ $item->name }}</p>
                                            <p class="text-xs text-slate-400 line-through">{{ $item->pegawai->name ?? '-' }}</p>
                                        @else
                                            <span class="text-xs text-slate-300 italic">Tidak diubah</span>
                                        @endif
                                    </td>

                                    {{-- No HP --}}
                                    <td class="px-4 py-3">
                                        @if($item->no_hp)
                                            <p class="font-medium text-slate-800">{{ $item->no_hp }}</p>
                                            <p class="text-xs text-slate-400 line-through">{{ $item->pegawai->no_hp ?? '-' }}</p>
                                        @else
                                            <span class="text-xs text-slate-300 italic">Tidak diubah</span>
                                        @endif
                                    </td>

                                    {{-- Alamat --}}
                                    <td class="px-4 py-3 max-w-xs">
                                        @if($item->alamat)
                                            <p class="font-medium text-slate-800 truncate max-w-[140px]">{{ $item->alamat }}</p>
                                            <p class="text-xs text-slate-400 line-through truncate max-w-[140px]">{{ $item->pegawai->alamat ?? '-' }}</p>
                                        @else
                                            <span class="text-xs text-slate-300 italic">Tidak diubah</span>
                                        @endif
                                    </td>

                                    {{-- Jenis Kelamin --}}
                                    <td class="px-4 py-3">
                                        @if($item->jenis_kelamin)
                                            <span class="text-xs px-2 py-1 bg-slate-100 rounded-md text-slate-600">
                                                {{ $item->jenis_kelamin }}
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-300 italic">-</span>
                                        @endif
                                    </td>

                                    {{-- Tgl Lahir --}}
                                    <td class="px-4 py-3 text-slate-600">
                                        @if($item->tanggal_lahir)
                                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
                                        @else
                                            <span class="text-xs text-slate-300 italic">-</span>
                                        @endif
                                    </td>

                                    {{-- Foto --}}
                                    <td class="px-4 py-3">
                                        @if($item->foto)
                                            <a href="{{ asset('storage/' . $item->foto) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $item->foto) }}"
                                                    class="w-10 h-10 rounded-lg object-cover border border-slate-200 hover:scale-110 transition">
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-300 italic">-</span>
                                        @endif
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-4 py-3 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-3">
                                        @if($item->status == 'pending')
                                            <span class="text-xs px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">
                                                Menunggu
                                            </span>
                                        @elseif($item->status == 'disetujui')
                                            <span class="text-xs px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-medium">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="text-xs px-3 py-1 rounded-full bg-red-100 text-red-700 font-medium">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-3">
                                        @if($item->status == 'pending')
                                            <div class="flex items-center gap-2">
                                                {{-- Tombol Setujui --}}
                                                <form action="{{ route('perubahan.setujui', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        onclick="return confirm('Setujui perubahan data ini? Data pegawai akan langsung diperbarui.')"
                                                        class="text-xs px-3 py-1.5 bg-slate-800 text-white rounded-md hover:bg-blue-600 transition cursor-pointer border-0">
                                                        ✓ Setujui
                                                    </button>
                                                </form>

                                                {{-- Tombol Tolak --}}
                                                <button type="button"
                                                    onclick="bukaTolak({{ $item->id }})"
                                                    class="text-xs px-3 py-1.5 bg-slate-100 text-slate-700 rounded-md hover:bg-red-500 hover:text-white transition cursor-pointer border-0">
                                                    ✕ Tolak
                                                </button>
                                            </div>
                                        @else
                                            @if($item->catatan_penolakan)
                                                <button type="button"
                                                    onclick="lihatCatatan('{{ addslashes($item->catatan_penolakan) }}')"
                                                    class="text-xs text-slate-400 hover:text-blue-500 transition border-0 bg-transparent cursor-pointer">
                                                    💬 Lihat catatan
                                                </button>
                                            @else
                                                <span class="text-slate-300 text-xs">—</span>
                                            @endif
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-2xl">📭</div>
                                            <p class="text-slate-400 text-sm">Belum ada pengajuan perubahan data</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== MODAL TOLAK ===== --}}
    <div class="modal fade" id="modalTolak" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
            <div class="modal-content border-0 rounded-2xl overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.12);">
                <div class="px-6 py-5 flex items-center justify-between"
                    style="background: linear-gradient(135deg, #2962FF, #0039CB);">
                    <h5 class="text-white font-bold text-base m-0">✕ Tolak Pengajuan</h5>
                    <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal"></button>
                </div>
                <form id="formTolak" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-5">
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">
                            Tuliskan alasan penolakan agar pegawai mengetahui mengapa perubahan datanya ditolak.
                        </p>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">
                            Catatan Penolakan <span class="text-red-500 normal-case font-normal tracking-normal">(wajib)</span>
                        </label>
                        <textarea name="catatan_penolakan" rows="4" required
                            placeholder="Contoh: Data yang diajukan tidak sesuai dengan dokumen resmi..."
                            class="w-full border-2 border-slate-100 focus:border-blue-400 focus:ring-4 focus:ring-blue-50 rounded-xl px-4 py-3 text-sm text-slate-700 outline-none resize-none transition-all placeholder:text-slate-300"></textarea>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" data-bs-dismiss="modal"
                            class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl text-white text-sm font-semibold hover:opacity-90 transition border-0 cursor-pointer"
                            style="background: linear-gradient(135deg, #2962FF, #0039CB);">
                            Tolak Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== MODAL CATATAN ===== --}}
    <div class="modal fade" id="modalCatatan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content border-0 rounded-2xl overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.1);">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h6 class="font-bold text-slate-800 text-sm m-0">💬 Catatan Penolakan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="px-6 py-5">
                    <p id="isiCatatan" class="text-slate-600 text-sm leading-relaxed"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#tablePerubahan').DataTable({
                responsive: true,
                language: {
                    search:       "Cari:",
                    lengthMenu:   "Tampilkan _MENU_ data",
                    info:         "Menampilkan _START_–_END_ dari _TOTAL_ data",
                    infoEmpty:    "Tidak ada data",
                    zeroRecords:  "Data tidak ditemukan",
                    paginate: { previous: "‹", next: "›" }
                },
                columnDefs: [{ orderable: false, targets: [6, 9] }]
            });
        });

        function bukaTolak(id) {
            document.getElementById('formTolak').action = `/perubahan-pegawai/tolak/${id}`;
            new bootstrap.Modal(document.getElementById('modalTolak')).show();
        }

        function lihatCatatan(catatan) {
            document.getElementById('isiCatatan').textContent = catatan;
            new bootstrap.Modal(document.getElementById('modalCatatan')).show();
        }
    </script>

@endsection