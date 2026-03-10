@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Content Home" />

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
      <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Content Home</h1>
      <p class="text-sm text-gray-400 mt-0.5">{{ $homes->total() }} item{{ $homes->total() !== 1 ? 's' : '' }} total</p>
    </div>
    <a href="{{ route('home.create') }}">
      <button class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Content
      </button>
    </a>
  </div>

  {{-- Empty State --}}
  @if($homes->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
      <p class="text-sm">No content yet. Add your first item.</p>
    </div>

  @else
    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($homes as $home)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

          {{-- Image --}}
          <div class="overflow-hidden aspect-video bg-gray-100">
            <img
              src="{{ asset('storage/public/' . $home->foto) }}"
              alt="{{ $home->title }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              loading="lazy"
            />
          </div>

          {{-- Body --}}
          <div class="p-4 flex flex-col gap-1 flex-1">
            <p class="text-base font-semibold text-gray-900 leading-snug">{{ $home->title }}</p>
            <p class="text-sm text-gray-400 font-normal leading-relaxed line-clamp-2">{{ $home->deskripsi }}</p>
          </div>

          {{-- Footer --}}
          <div class="px-4 pb-4">
            <a href="{{ route('home.edit', $home) }}">
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
    {{ $homes->links() }}
  </div>

</div>
@endsection