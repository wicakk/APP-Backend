@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Content FAQ" />

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
      <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Content FAQ</h1>
      <p class="text-sm text-gray-400 mt-0.5">{{ $faqs->total() }} item{{ $faqs->total() !== 1 ? 's' : '' }} total</p>
    </div>
    <a href="{{ route('faq.create') }}">
      <button class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add FAQ
      </button>
    </a>
  </div>

  {{-- Empty State --}}
  @if($faqs->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <p class="text-sm">Belum ada FAQ. Tambahkan pertanyaan pertama.</p>
    </div>

  @else
    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-gray-50 border-b border-gray-100">
            <th class="py-3.5 px-5 text-xs font-semibold text-gray-400 uppercase tracking-widest w-12">#</th>
            <th class="py-3.5 px-5 text-xs font-semibold text-gray-400 uppercase tracking-widest w-1/3">Question</th>
            <th class="py-3.5 px-5 text-xs font-semibold text-gray-400 uppercase tracking-widest">Answer</th>
            <th class="py-3.5 px-5 text-xs font-semibold text-gray-400 uppercase tracking-widest w-24 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @foreach ($faqs as $index => $faq)
            <tr class="hover:bg-gray-50 transition-colors duration-150 group">

              {{-- Index --}}
              <td class="py-4 px-5">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-xs font-semibold text-gray-500">
                  {{ $faqs->firstItem() + $index }}
                </span>
              </td>

              {{-- Question --}}
              <td class="py-4 px-5">
                <div class="flex items-start gap-2">
                  <span class="mt-0.5 flex-shrink-0 inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-100 text-amber-600 text-xs font-bold">Q</span>
                  <p class="text-sm font-medium text-gray-800 leading-snug">{{ $faq->question }}</p>
                </div>
              </td>

              {{-- Answer --}}
              <td class="py-4 px-5">
                <div class="flex items-start gap-2">
                  <span class="mt-0.5 flex-shrink-0 inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-100 text-green-600 text-xs font-bold">A</span>
                  <p class="text-sm text-gray-400 leading-snug">{{ Str::limit($faq->answer, 80) }}</p>
                </div>
              </td>

              {{-- Action --}}
              <td class="py-4 px-5 text-center">
                <a href="{{ route('faq.edit', $faq) }}">
                  <button class="text-sm font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 px-4 py-1.5 rounded-lg transition-all duration-200">
                    Edit
                  </button>
                </a>
              </td>

            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  {{-- Pagination --}}
  <div class="mt-8 flex justify-center">
    {{ $faqs->links() }}
  </div>

</div>
@endsection