@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Content misi" />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

        @if (session()->has('success'))
            <x-alert message="{{ session('success') }}" />
        @endif

        <div class="mt-6 justify-start">
            {{-- <h2 class="font-semibold text-xl">Content misi</h2> --}}
            <a href="{{ route('misi.create_misi') }}">
                <button class="bg-blue-500 text-white px-10 py-2 rounded-md font-semibold">Add</button>
            </a>

        </div>

        <div class="grid md:grid-cols-3 grid-cols-1 mt-4 gap-6">
            @foreach ($misis as $misi)
                <div>
                    <img src="{{ asset('storage/' . $misi->foto) }}" class="h-96 w-full object-cover rounded-t-lg" />
                    <div class="flex flex-col max-w-lg p-6 mx-auto text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                        <label class="mt-5 font-bold" for="misi">misi</label>
                        <p class="text-xl font-light">{{ $misi->title }}</p>
                        <label class="mt-5 font-bold" for="deskripsi misi">deskripsi misi</label>
                        <p class="font-semibold text-gray-400">{{ $misi->deskripsi }}</p>
                    </div>
                    <a href="{{ route('misi.edit_misi', $misi) }}">
                        <button class="bg-gray-100 px-10 py-2 w-full rounded-md font-semibold">Edit</button>
                    </a>
                </div>
            @endforeach
        </div>


        <div class="mt-4">
            {{ $misis->links() }}
        </div>

    </div>

@endsection
