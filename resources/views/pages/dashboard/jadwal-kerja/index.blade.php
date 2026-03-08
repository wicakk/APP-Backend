@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-4 transition-colors duration-300">
    <div class="max-w-8xl mx-auto">

        {{-- Header --}}
        <div class="flex  items-center justify-between mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white ">
                    Jadwal Kerja
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                    Kelola jadwal kerja pegawai dengan mudah
                </p>
            </div>

            <a href="{{ route('jadwal.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                <span>+</span> Tambah Jadwal
            </a>
        </div>

        {{-- Card Grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($jadwals as $item)

            <div class="group bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">

                {{-- Top --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $item->hari }}
                    </h2>

                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900 dark:text-blue-300">
                        {{ $item->durasi }}
                    </span>
                </div>

                {{-- Jam Section --}}
                <div class="space-y-4">

                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700/40 px-4 py-3 rounded-xl">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Jam Masuk</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ $item->jam_masuk }}
                            </p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    </div>

                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700/40 px-4 py-3 rounded-xl">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Jam Pulang</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ $item->jam_pulang }}
                            </p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                    </div>

                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-6"></div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('jadwal.edit', $item->id) }}"
                       class="text-xs font-medium px-4 py-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300 transition">
                        Edit
                    </a>

                    <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus jadwal {{ $item->hari }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-xs font-medium px-4 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900 dark:text-red-300 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            @empty
            <div class="col-span-full  bg-blue-600 rounded-2xl text-center py-20">
                <p class="text-gray-300 dark:text-gray-400 mb-4">
                    Belum ada jadwal kerja
                </p>
                <a href="{{ route('jadwal.create') }}"
                   class="inline-block bg-gray-400 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl shadow-md transition">
                    Tambah Jadwal Sekarang
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection