@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 ">
    <div class=" mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Pegawai</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui data pegawai</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">

                    {{-- NIP --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
                        <input type="text" name="nip" 
                            value="{{ old('nip', $pegawai->nip ?? '') }}" 
                            placeholder="Nomor Induk Pegawai"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" name="name" 
                            value="{{ old('name', $pegawai->name ?? '') }}" 
                            placeholder="Nama lengkap"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" 
                            value="{{ old('email', $pegawai->email ?? '') }}" 
                            placeholder="email@example.com"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Password (hanya untuk create) --}}
                    @if(!$pegawai)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                    </div>
                    @endif
    
                    {{-- No HP --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">No HP</label>
                        <input type="text" name="no_hp" 
                            value="{{ old('no_hp', $pegawai->no_hp ?? '') }}" 
                            placeholder="08xxxxxxxxxx"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Alamat --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                        <textarea name="alamat" placeholder="Alamat lengkap"
                                class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
                        @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                                class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" 
                            value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ?? '') }}"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Jabatan --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                        <select name="jabatan_id"
                                class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                            <option value="">Pilih Jabatan</option>
                            @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}" {{ old('jabatan_id', $pegawai->jabatan_id ?? '') == $jabatan->id ? 'selected' : '' }}>
                                    {{ $jabatan->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jabatan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Departemen --}}
                    <div class="">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departemen</label>
                        <select name="departemen_id"
                                class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                            <option value="">Pilih Departemen</option>
                            @foreach($departemens as $departemen)
                                <option value="{{ $departemen->id }}" {{ old('departemen_id', $pegawai->departemen_id ?? '') == $departemen->id ? 'selected' : '' }}>
                                    {{ $departemen->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                        @error('departemen_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Tanggal Masuk --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" 
                            value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk ?? '') }}"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        @error('tanggal_masuk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
    
                    {{-- Status Pegawai --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Pegawai</label>
                        <select name="status_pegawai"
                                class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                            <option value="aktif" {{ old('status_pegawai', $pegawai->status_pegawai ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status_pegawai', $pegawai->status_pegawai ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status_pegawai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Password opsional --}}
                <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                    <div class="p-4">
                        <p class="text-xs text-gray-400 mb-3">Kosongkan jika tidak ingin mengubah password</p>
                        <div class="w-full py-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                            <input type="password" name="password" placeholder="Min. 6 karakter"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blie-500">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="w-full py-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blie-500">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                        Update
                    </button>
                    <a href="{{ route('pegawai.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
