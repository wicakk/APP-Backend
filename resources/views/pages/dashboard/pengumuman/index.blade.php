{{-- resources/views/pengumuman/index.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-4">
  <div class="max-w-8xl mx-auto">
    <div class="flex items-center justify-between mb-10">
      <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Pengumuman</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola pengumuman untuk pegawai</p>
      </div>
      <a href="{{ route('pengumuman.create') }}"
         class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md transition">
        <span>+</span> Tambah Pengumuman
      </a>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($pengumuman as $item)
      <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 dark:border-gray-700">
        {{-- Prioritas Badge --}}
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-medium px-3 py-1 rounded-full
            {{ $item->prioritas === 'tinggi' ? 'bg-red-50 text-red-600 dark:bg-red-900 dark:text-red-300' : '' }}
            {{ $item->prioritas === 'sedang' ? 'bg-yellow-50 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
            {{ $item->prioritas === 'rendah' ? 'bg-green-50 text-green-600 dark:bg-green-900 dark:text-green-300' : '' }}">
            {{ ucfirst($item->prioritas) }}
          </span>
          <span class="text-xs text-gray-400">{{ $item->created_at->format('d M Y') }}</span>
        </div>

        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ $item->judul }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">{{ $item->isi }}</p>

        <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>
        <div class="flex justify-end gap-3">
          <a href="{{ route('pengumuman.edit', $item->id) }}"
             class="text-xs px-4 py-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition">Edit</a>
          <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST"
                onsubmit="return confirm('Hapus pengumuman ini?')">
            @csrf @method('DELETE')
            <button class="text-xs px-4 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">Hapus</button>
          </form>
        </div>
      </div>
      @empty
      <div class="col-span-full text-center py-20 bg-blue-600 rounded-2xl">
        <p class="text-gray-300 mb-4">Belum ada pengumuman</p>
        <a href="{{ route('pengumuman.create') }}"
           class="bg-white text-blue-600 px-6 py-2.5 rounded-xl font-semibold shadow transition">
          Tambah Sekarang
        </a>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection