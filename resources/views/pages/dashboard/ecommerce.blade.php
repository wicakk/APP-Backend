@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <!-- Metrics -->
    <div class="col-span-12">
      <x-ecommerce.ecommerce-metrics />
    </div>

  
    <!-- Layanan Kami (kiri) + Visitor Demographic (kanan) -->
    @if(isset($services) && $services->count())
    <div class="col-span-12 xl:col-span-7">
      <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
        <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white/90">Layanan Kami</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          @foreach($services as $service)
          <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
            @if($service->foto && $service->foto !== 'noimage.png')
              <img src="{{ asset('storage/' . $service->foto) }}" alt="{{ $service->nama }}" class="mb-3 h-40 w-full rounded-lg object-cover" />
            @endif
            <h4 class="font-semibold text-gray-800 dark:text-white/90">{{ $service->nama }}</h4>
            @if($service->subnama)
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ $service->subnama }}</p>
            @endif
            @if($service->price)
              <p class="mt-2 text-lg font-bold text-brand-500">Rp {{ number_format($service->price, 0, ',', '.') }}
                @if($service->billing_period)
                  <span class="text-sm font-normal text-gray-400">/ {{ $service->billing_period }}</span>
                @endif
              </p>
            @endif
            @if($service->description)
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit(is_array($service->description) ? implode(', ', $service->description) : $service->description, 100) }}</p>
            @endif
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    <div class="col-span-12 xl:col-span-5">
      <x-ecommerce.customer-demographic :visitorStats="$visitorStats ?? collect()" :recentVisitors="$recentVisitors ?? collect()" />
    </div>
  </div>
@endsection
