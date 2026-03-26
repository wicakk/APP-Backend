@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 transition-colors duration-300">
    <div class="max-w-8xl mx-auto">

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Pegawai</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data pegawai</p>
            </div>
            <a href="{{ route('pegawai.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
                + Tambah Pegawai
            </a>
        </div>
        <div class="w-full py-5">
            <form method="GET" action="{{ route('pegawai.index') }}" class="flex w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari pegawai..." 
                        class="w-full md:w-64 px-3 py-2 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition">Telusuri</button>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIP</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jabatan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Dept</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tgl Masuk</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($pegawais as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $pegawais->firstItem() + $index }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $item->name }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $item->nip }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $item->email }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $item->jabatan->nama_jabatan ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $item->departemen->nama_departemen ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $item->status_pegawai  }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $item->tanggal_masuk }}</td>
                            <td class="px-4 py-4 flex items-center gap-2 justify-center">
                                <a href="{{ route('pegawai.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300 transition">Detail</a>
                                <a href="{{ route('pegawai.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-900 dark:text-yellow-300 transition">Edit</a>
                                <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $item->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900 dark:text-red-300 transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 text-sm ">
                                Belum ada pegawai. <a href="{{ route('pegawai.create') }}" class="text-indigo-600 underline">Tambah sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-100 dark:border-gray-600 flex flex-col md:flex-row items-e justify-between">
                <div class="text-sm text-gray-700 dark:text-gray-300 mb-2 md:mb-0">
                    Menampilkan {{ $pegawais->firstItem() ?? 0 }} - {{ $pegawais->lastItem() ?? 0 }} dari {{ $pegawais->total() }} pegawai
                </div>
                <div>
                    {{ $pegawais->withQueryString()->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#pegawaiTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: { previous: "Sebelumnya", next: "Berikutnya" }
        }
    });
});
</script>
@endsection
