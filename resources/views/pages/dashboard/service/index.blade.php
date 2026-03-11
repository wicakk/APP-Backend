@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Content Service" />

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 py-10">

  {{-- Alert --}}
  @if (session()->has('success'))
    <div class="mb-6">
      <x-alert message="{{ session('success') }}" />
    </div>
  @endif

  {{-- Header --}}
  <div class="flex items-center justify-between mb-10">
    <div>
      <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Management</p>
      <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Services</h1>
    </div>
    <a href="{{ route('service.create') }}">
      <button class="inline-flex items-center gap-2 bg-black hover:bg-gray-800 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-all duration-200 hover:shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Service
      </button>
    </a>
  </div>

  {{-- Stats Bar --}}
  <div class="flex items-center gap-2 mb-8 pb-6 border-b border-gray-100">
    <span class="text-sm text-gray-400">
      Menampilkan
      <span class="font-semibold text-gray-700">{{ $services->firstItem() }}–{{ $services->lastItem() }}</span>
      dari
      <span class="font-semibold text-gray-700">{{ $services->total() }}</span>
      layanan
    </span>
  </div>

  {{-- Empty State --}}
  @if($services->isEmpty())
    <div class="flex flex-col items-center justify-center py-32 text-gray-300">
      <div class="w-16 h-16 mb-5 rounded-2xl bg-gray-50 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>
      <p class="text-sm font-medium text-gray-400">Belum ada layanan</p>
      <p class="text-xs text-gray-300 mt-1">Tambahkan service pertama kamu</p>
    </div>

  @else
    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach ($services as $service)
        <div class="group relative bg-white border border-gray-100 rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:border-gray-200 hover:shadow-lg hover:-translate-y-0.5">

          {{-- Image --}}
          <div class="relative overflow-hidden bg-gray-50" style="aspect-ratio: 16/9">
            <img
              src="{{ asset('storage/public/' . $service->foto) }}"
              alt="{{ $service->nama }}"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
              loading="lazy"
            />
            {{-- Price overlay --}}
            <div class="absolute top-3 right-3">
              <span class="inline-flex items-center gap-1 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-semibold px-2.5 py-1 rounded-lg shadow-sm">
                Rp {{ number_format($service->price) }}
              </span>
            </div>
          </div>

          {{-- Body --}}
          <div class="p-5 flex flex-col gap-3 flex-1">

            {{-- Title --}}
            <div>
              <p class="text-base font-semibold text-gray-900 leading-snug">{{ $service->nama }}</p>
            </div>

            {{-- Description --}}
            <p class="text-sm text-gray-400 leading-relaxed line-clamp-2 flex-1">
              {{ is_array($service->description) ? implode(', ', $service->description) : $service->description }}
            </p>

          </div>

          {{-- Footer --}}
          <div class="px-5 pb-5 pt-0">
            <div class="h-px bg-gray-50 mb-4"></div>
            <a href="{{ route('service.edit', $service) }}">
              <button class="w-full text-sm font-medium text-gray-500 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 py-2.5 rounded-xl transition-all duration-200">
                Edit Service
              </button>
            </a>
          </div>

        </div>
      @endforeach
    </div>
  @endif

  {{-- Pagination --}}
  <div class="mt-10 flex justify-center">
    {{ $services->links() }}
  </div>

</div>
@endsection