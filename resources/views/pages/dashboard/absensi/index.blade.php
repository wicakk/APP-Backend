@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-4 transition-colors duration-300">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Rekap Presensi
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Data kehadiran seluruh pegawai
                </p>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-800 
                    rounded-2xl shadow-sm 
                    border border-gray-100 dark:border-gray-700 
                    overflow-hidden">

            <div class="overflow-x-auto">
                <table id="example"
                       class="min-w-full text-sm text-left">

                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200 uppercase">
                                Nama
                            </th>
                            <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200 uppercase">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200 uppercase">
                                Masuk
                            </th>
                            <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200 uppercase">
                                Pulang
                            </th>
                            <th class="px-6 py-4 font-semibold text-gray-600 dark:text-gray-200 uppercase">
                                Lokasi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        {{-- @foreach($presensi as $item) --}}
                        @forelse($presensi as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">
                                {{-- {{ $item->pegawai->name }} --}}
                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ $item->tanggal }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                                    {{ $item->masuk }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">
                                    {{ $item->pulang }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-xs">
                                    {{ $item->latitude }}, {{ $item->longitude }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Belum ada data presensi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

{{-- DataTables --}}
<script>
$(document).ready(function () {
    $('#example').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });
});
</script>

@endsection