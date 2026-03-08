@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-4 transition-colors duration-300">
    <div class="max-w-8xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Departemen
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                    Kelola departemen di perusahaan dengan mudah
                </p>
            </div>

            <a href="{{ route('departemen.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                <span>+</span> Tambah Departemen
            </a>
        </div>

        {{-- Card Grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($departemens as $item)

            <div class="group bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">

                {{-- Top --}}
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $item->nama_departemen }}
                    </h2>
                </div>

                {{-- Deskripsi --}}
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    {{ $item->deskripsi ?? 'Tidak ada deskripsi' }}
                </p>

                {{-- Actions --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('departemen.edit', $item->id) }}"
                       class="text-xs font-medium px-4 py-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300 transition">
                        Edit
                    </a>

                    <form action="{{ route('departemen.destroy', $item->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus departemen {{ $item->nama_departemen }}?')">
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
            <div class="col-span-full rounded-2xl bg-blue-500 dark:bg-gray-700 text-center py-20">
                <p class="text-gray-200 dark:text-gray-400 mb-4">
                    Belum ada departemen
                </p>
                <a href="{{ route('departemen.create') }}"
                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl shadow-md transition">
                    Tambah Departemen Sekarang
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection