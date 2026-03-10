@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 transition-colors duration-300">
    <div class="max-w-xl mx-auto">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Pengumuman</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui informasi pengumuman</p>
        </div>

        {{-- Form --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" placeholder="cth: Libur Nasional Hari Raya"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Isi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Isi Pengumuman</label>
                    <textarea name="isi" rows="5" placeholder="Tulis isi pengumuman di sini..."
                              class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('isi', $pengumuman->isi) }}</textarea>
                    @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Prioritas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prioritas</label>
                    <select name="prioritas"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Prioritas --</option>
                        @foreach(['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Tinggi'] as $val => $label)
                            <option value="{{ $val }}" {{ old('prioritas', $pengumuman->prioritas) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('prioritas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tanggal Mulai <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('tanggal_mulai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Berakhir --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tanggal Berakhir <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $pengumuman->tanggal_berakhir) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('tanggal_berakhir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="flex items-center gap-3">
                    <input type="hidden" name="aktif" value="0">
                    <input type="checkbox" name="aktif" value="1" id="aktif"
                           {{ old('aktif', $pengumuman->aktif) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="aktif" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Aktifkan pengumuman ini
                    </label>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                        Update
                    </button>
                    <a href="{{ route('pengumuman.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection