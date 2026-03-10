@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Content Service" />

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
      <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Content Service</h1>
      <p class="text-sm text-gray-400 mt-0.5">{{ $services->total() }} item{{ $services->total() !== 1 ? 's' : '' }} total</p>
    </div>
    <a href="{{ route('service.create') }}">
      <button class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Service
      </button>
    </a>
  </div>

  {{-- Empty State --}}
  @if($services->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
      </svg>
      <p class="text-sm">No services yet. Add your first service.</p>
    </div>

  @else
    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($services as $service)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

          {{-- Image --}}
          <div class="overflow-hidden aspect-video bg-gray-100">
            <img
              src="{{ asset('storage/public/' . $service->foto) }}"
              alt="{{ $service->nama }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              loading="lazy"
            />
          </div>

          {{-- Body --}}
          <div class="p-4 flex flex-col gap-2 flex-1">
            <p class="text-base font-semibold text-gray-900 leading-snug">{{ $service->nama }}</p>

            {{-- Price Badge --}}
            <span class="inline-flex items-center w-fit gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Rp. {{ number_format($service->price) }}
            </span>

            <p class="text-sm text-gray-400 leading-relaxed line-clamp-2">
              {{ is_array($service->description) ? implode(', ', $service->description) : $service->description }}
            </p>
          </div>

          {{-- Footer --}}
          <div class="px-4 pb-4">
            <a href="{{ route('service.edit', $service) }}">
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
    {{ $clients->links() }}
  </div>

</div>
@endsection