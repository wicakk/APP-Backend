@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengajuan Absensi</h2>
            <p class="text-sm text-gray-500">Kelola pengajuan koreksi absensi pegawai</p>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Pending --}}
        <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Menunggu</p>
                <h3 class="text-3xl font-bold text-yellow-500">{{ $totalPending }}</h3>
            </div>
            <div class="bg-yellow-100 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                </svg>
            </div>
        </div>

        {{-- Disetujui --}}
        <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Disetujui</p>
                <h3 class="text-3xl font-bold text-green-500">{{ $totalDisetujui }}</h3>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        {{-- Ditolak --}}
        <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Ditolak</p>
                <h3 class="text-3xl font-bold text-red-500">{{ $totalDitolak }}</h3>
            </div>
            <div class="bg-red-100 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow-sm rounded-xl overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-700">Daftar Pengajuan Absensi</h3>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200" id="example">

                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-600">
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Tanggal Absensi</th>
                        <th class="px-6 py-3">Jam Masuk</th>
                        <th class="px-6 py-3">Jam Keluar</th>
                        <th class="px-6 py-3">Alasan</th>
                        <th class="px-6 py-3">File</th>
                        <th class="px-6 py-3">Diajukan</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 text-sm">

                    @forelse($pengajuan as $item)

                    <tr class="hover:bg-gray-50">

                        {{-- NAMA --}}
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->pegawai->name ?? '-' }}
                        </td>

                        {{-- TANGGAL ABSENSI --}}
                        <td class="px-6 py-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($item->tanggal_absensi)->format('d M Y') }}
                        </td>

                        {{-- JAM MASUK --}}
                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->jam_masuk ?? '-' }}
                        </td>

                        {{-- JAM KELUAR --}}
                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->jam_keluar ?? '-' }}
                        </td>

                        {{-- ALASAN --}}
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                            {{ $item->alasan }}
                        </td>

                        {{-- FILE --}}
                        <td class="px-6 py-4">
                            @if($item->file)
                            <a href="{{ asset('storage/'.$item->file) }}"
                               class="text-blue-500 hover:underline"
                               target="_blank">
                                Lihat
                            </a>
                            @else
                            -
                            @endif
                        </td>

                        {{-- DIAJUKAN PADA --}}
                        <td class="px-6 py-4 text-gray-500 text-xs">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">
                            @if($item->status == 'pending')
                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                                Menunggu
                            </span>
                            @elseif($item->status == 'disetujui')
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                Disetujui
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                                Ditolak
                            </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">
                            @if($item->status == 'pending')
                            <div class="flex gap-2">

                                <form action="{{ route('pengajuan-absensi.setujui', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-2 rounded-lg">
                                        Setujui
                                    </button>
                                </form>

                                <button onclick="konfirmasiTolak({{ $item->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-2 rounded-lg">
                                    Tolak
                                </button>

                            </div>
                            @else
                            <div class="text-xs text-gray-400">
                                @if($item->catatan_penolakan)
                                <button onclick="lihatCatatan('{{ addslashes($item->catatan_penolakan) }}')"
                                    class="text-red-400 hover:underline">
                                    Lihat Catatan
                                </button>
                                @else
                                -
                                @endif
                            </div>
                            @endif
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-gray-400">
                            Belum ada pengajuan absensi
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($pengajuan->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $pengajuan->links() }}
        </div>
        @endif

    </div>

</div>


{{-- MODAL TOLAK --}}
<div id="modalTolak" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-96 p-6">

        <h3 class="text-lg font-semibold mb-4">Alasan Penolakan</h3>

        <form id="formTolak" method="POST">
            @csrf
            @method('PUT')

            <textarea name="catatan_penolakan"
                class="w-full border rounded-lg p-3 mb-4"
                rows="3"
                placeholder="Masukkan alasan penolakan..."
                required></textarea>

            <div class="flex justify-end gap-2">
                <button type="button"
                    onclick="tutupModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg">
                    Tolak
                </button>
            </div>

        </form>
    </div>
</div>

{{-- MODAL CATATAN PENOLAKAN --}}
<div id="modalCatatan" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-96 p-6">

        <h3 class="text-lg font-semibold mb-4">Catatan Penolakan</h3>

        <p id="isiCatatan" class="text-gray-600 text-sm mb-4"></p>

        <div class="flex justify-end">
            <button type="button"
                onclick="tutupModalCatatan()"
                class="px-4 py-2 bg-gray-200 rounded-lg">
                Tutup
            </button>
        </div>

    </div>
</div>


<script>
    function konfirmasiTolak(id) {
        let url = "{{ url('pengajuan-absensi/tolak') }}/" + id;
        document.getElementById("formTolak").action = url;
        document.getElementById("modalTolak").classList.remove("hidden");
    }

    function tutupModal() {
        document.getElementById("modalTolak").classList.add("hidden");
    }

    function lihatCatatan(catatan) {
        document.getElementById("isiCatatan").innerText = catatan;
        document.getElementById("modalCatatan").classList.remove("hidden");
    }

    function tutupModalCatatan() {
        document.getElementById("modalCatatan").classList.add("hidden");
    }

    // Tutup modal jika klik di luar
    document.getElementById("modalTolak").addEventListener("click", function(e) {
        if (e.target === this) tutupModal();
    });

    document.getElementById("modalCatatan").addEventListener("click", function(e) {
        if (e.target === this) tutupModalCatatan();
    });
</script>

@endsection