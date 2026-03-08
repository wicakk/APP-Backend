@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Team Members" />

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

    @if (session()->has('success'))
        <x-alert message="{{ session('success') }}" />
    @endif

    <div class="mt-6">
        <a href="{{ route('teams.create') }}">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-md font-semibold shadow">
                + Add Team Member
            </button>
        </a>
    </div>

    {{-- GRID TEAM --}}
    <div class="grid md:grid-cols-3 grid-cols-1 mt-6 gap-6">
        @foreach ($teams as $team)
            <div class="bg-white rounded-xl shadow border p-5 flex flex-col">

                <img src="{{ $team->photo 
                        ? asset('storage/' . $team->photo) 
                        : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $team->first_name }}"
                     class="h-48 w-full object-cover rounded-lg mb-4" />

                <h3 class="text-lg font-bold text-gray-800">
                    {{ $team->first_name }} {{ $team->last_name }}
                </h3>

                @if ($team->email)
                    <p class="text-sm text-gray-500">{{ $team->email }}</p>
                @endif

                @if ($team->bio)
                    <p class="text-sm text-gray-600 mt-2 line-clamp-3">{{ $team->bio }}</p>
                @endif

                <div class="flex gap-3 mt-3">
                    @if ($team->linkedin)
                        <a href="{{ $team->linkedin }}" target="_blank" class="text-blue-700 text-sm font-medium">LinkedIn</a>
                    @endif
                    @if ($team->instagram)
                        <a href="{{ $team->instagram }}" target="_blank" class="text-pink-600 text-sm font-medium">Instagram</a>
                    @endif
                </div>

                <div class="flex gap-2 mt-5">
                    <button @click="$dispatch('open-team-info-modal', { id: {{ $team->id }} })"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white w-full py-2 rounded-md text-sm font-semibold">
                        Edit
                    </button>

                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="w-full"
                        onsubmit="return confirm('Yakin mau hapus member ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-600 text-white w-full py-2 rounded-md text-sm font-semibold">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $teams->links() }}
    </div>
</div>


{{-- ✅ MODAL DITARUH DI LUAR FOREACH --}}
<x-ui.modal x-data="{ open: false, teamId: null }"
    @open-team-info-modal.window="open = true; teamId = $event.detail.id"
    :isOpen="false" class="max-w-[700px]">

    <form method="POST" :action="`/teams/${teamId}`" class="flex flex-col">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-4">
            <h4 class="text-xl font-semibold">Edit Team Member</h4>

            <input type="text" name="first_name" placeholder="First Name" class="w-full border rounded p-2">
            <input type="text" name="last_name" placeholder="Last Name" class="w-full border rounded p-2">
            <input type="email" name="email" placeholder="Email" class="w-full border rounded p-2">
            <input type="text" name="phone" placeholder="Phone" class="w-full border rounded p-2">
            <input type="text" name="linkedin" placeholder="LinkedIn URL" class="w-full border rounded p-2">
            <input type="text" name="instagram" placeholder="Instagram URL" class="w-full border rounded p-2">
            <textarea name="bio" placeholder="Bio" class="w-full border rounded p-2"></textarea>
        </div>

        <div class="flex justify-end gap-3 p-6 border-t">
            <button type="button" @click="open=false" class="px-4 py-2 border rounded">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        </div>
    </form>
</x-ui.modal>

@endsection
