@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Content Home" />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

        @if (session()->has('success'))
            <x-alert message="{{ session('success') }}" />
        @endif

        <div class="mt-6 justify-start">
            {{-- <h2 class="font-semibold text-xl">Content Home</h2> --}}
            <a href="{{ route('home.create') }}">
                <button class="bg-blue-500 text-white px-10 py-2 rounded-md font-semibold">Add</button>
            </a>

        </div>

        <div class="grid md:grid-cols-3 grid-cols-1 mt-4 gap-6">
            @foreach ($homes as $home)
                <div>
                    <img src="{{ asset('storage/public/' . $home->foto) }}" class="h-auto w-full object-cover" />
                    <div class="my-2">
                        <p class="text-xl font-light">{{ $home->title }}</p>
                        <p class="font-semibold text-gray-400">{{ $home->deskripsi }}</p>
                    </div>
                    <a href="{{ route('home.edit', $home) }}">
                        <button class="bg-gray-100 px-10 py-2 w-full rounded-md font-semibold">Edit</button>
                    </a>
                </div>
            @endforeach
        </div>


        <div class="mt-4">
            {{ $homes->links() }}
        </div>

    </div>

@endsection
