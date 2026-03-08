@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-4 transition-colors duration-300">
    <div class="max-w-3xl mx-auto">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Edit Jabatan
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                Perbarui data jabatan
            </p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" class="grid grid-cols-1 gap-4">
                @csrf
                @method('PUT')

                {{-- Nama Jabatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" 
                           value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}" 
                           placeholder="Masukkan nama jabatan"
                           class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                    @error('nama_jabatan') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea name="deskripsi" 
                              placeholder="Masukkan deskripsi jabatan"
                              class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">{{ old('deskripsi', $jabatan->deskripsi) }}</textarea>
                    @error('deskripsi') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 mt-2">
                    <a href="{{ route('jabatan.index') }}"
                       class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm font-medium transition">
                        Update
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection