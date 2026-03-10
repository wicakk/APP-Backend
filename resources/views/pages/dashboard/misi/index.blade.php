@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Content Misi" />

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
      <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Content Misi</h1>
      <p class="text-sm text-gray-400 mt-0.5">{{ $misis->total() }} item{{ $misis->total() !== 1 ? 's' : '' }} total</p>
    </div>
    <a href="{{ route('misi.create_misi') }}">
      <button class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Misi
      </button>
    </a>
  </div>

  {{-- Empty State --}}
  @if($misis->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
      </svg>
      <p class="text-sm">Belum ada misi. Tambahkan misi pertama.</p>
    </div>

  @else
    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($misis as $misi)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

          {{-- Image --}}
          <div class="overflow-hidden aspect-video bg-gray-100">
            <img
              src="{{ asset('storage/' . $misi->foto) }}"
              alt="{{ $misi->title }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              loading="lazy"
            />
          </div>

          {{-- Accent Bar --}}
          <div class="h-1 w-full bg-gradient-to-r from-violet-500 to-purple-500"></div>

          {{-- Body --}}
          <div class="p-5 flex flex-col gap-4 flex-1">

            {{-- Misi --}}
            <div class="flex flex-col gap-1">
              <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-violet-600 uppercase tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Misi
              </span>
              <p class="text-base font-semibold text-gray-900 leading-snug">{{ $misi->title }}</p>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100"></div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-1 flex-1">
              <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Deskripsi Misi</span>
              <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">{{ $misi->deskripsi }}</p>
            </div>

          </div>

          {{-- Footer --}}
          <div class="px-5 pb-5">
            <a href="{{ route('misi.edit_misi', $misi) }}">
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
    {{ $misis->links() }}
  </div>

</div>
@endsection