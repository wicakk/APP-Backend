@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Content Client" />

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
      <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Content Client</h1>
      <p class="text-sm text-gray-400 mt-0.5">{{ $clients->total() }} item{{ $clients->total() !== 1 ? 's' : '' }} total</p>
    </div>
    <a href="{{ route('client.create') }}">
      <button class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Client
      </button>
    </a>
  </div>

  {{-- Empty State --}}
  @if($clients->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
      </svg>
      <p class="text-sm">No clients yet. Add your first client.</p>
    </div>

  @else
    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($clients as $client)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

          {{-- Image --}}
          <div class="overflow-hidden aspect-video bg-gray-100">
            <img
              src="{{ asset('storage/public/' . $client->foto) }}"
              alt="{{ $client->title }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              loading="lazy"
            />
          </div>

          {{-- Body --}}
          <div class="p-4 flex flex-col gap-1 flex-1">
            <p class="text-base font-semibold text-gray-900 leading-snug">{{ $client->title }}</p>
            <p class="text-sm text-gray-400 font-normal leading-relaxed line-clamp-2">{{ $client->deskripsi }}</p>
          </div>

          {{-- Footer --}}
          <div class="px-4 pb-4">
            <a href="{{ route('client.edit', $client) }}">
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