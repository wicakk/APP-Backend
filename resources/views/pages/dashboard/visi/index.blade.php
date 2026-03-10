@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Content Visi" />

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 py-8">

  {{-- Alert --}}
  @if (session()->has('success'))
    <div class="mb-6">
      <x-alert message="{{ session('success') }}" />
    </div>
  @endif

  {{-- Header --}}
  <div class="flex items-center justify-between mb-8 pb-5 border-b border-gray-200">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Content Visi</h1>
      <p class="text-sm text-gray-400 mt-0.5">{{ $visis->total() }} item{{ $visis->total() !== 1 ? 's' : '' }} total</p>
    </div>
    <a href="{{ route('visi.create_visi') }}">
      <button class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Visi
      </button>
    </a>
  </div>

  {{-- Empty State --}}
  @if($visis->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
      </svg>
      <p class="text-sm">Belum ada visi. Tambahkan visi pertama.</p>
    </div>

  @else
    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($visis as $visi)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

          {{-- Card Header Accent --}}
          <div class="h-1.5 w-full bg-gradient-to-r from-blue-500 to-indigo-500"></div>

          {{-- Body --}}
          <div class="p-5 flex flex-col gap-4 flex-1">

            {{-- Visi --}}
            <div class="flex flex-col gap-1">
              <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 uppercase tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Visi
              </span>
              <p class="text-base font-semibold text-gray-900 leading-snug">{{ $visi->title }}</p>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100"></div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-1 flex-1">
              <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Deskripsi Visi</span>
              <p class="text-sm text-gray-500 leading-relaxed line-clamp-4">{{ $visi->deskripsi }}</p>
            </div>

          </div>

          {{-- Footer --}}
          <div class="px-5 pb-5">
            <a href="{{ route('visi.edit_visi', $visi) }}">
              <button class="w-full text-sm font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 py-2 rounded-lg transition-all duration-200">
                Edit
              </button>
            </a>
          </div>

        </div>
      @endforeach
    </div>
  @endif

  {{-- Pagination --}}
  <div class="mt-8 flex justify-center">
    {{ $visis->links() }}
  </div>

</div>
@endsection