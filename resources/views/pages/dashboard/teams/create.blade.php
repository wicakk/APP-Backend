@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

    <div class="flex mt-6">
        <h2 class="font-semibold text-xl">Add Team Member</h2>
    </div>

    <div class="mt-4" x-data="{ imageUrl: '/storage/noimage.png' }">
        <form enctype="multipart/form-data" method="POST" action="{{ route('teams.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @csrf

            {{-- PHOTO PREVIEW --}}
            <div>
                <img :src="imageUrl" class="rounded-xl w-48 h-48 object-cover border mb-4" />

                <x-input-label for="photo" value="Photo" />
                <x-text-input accept="image/*" id="photo" class="block mt-1 w-full border p-2"
                    type="file" name="photo"
                    @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
            </div>

            <div>

                <div class="mt-4">
                    <x-input-label for="first_name" value="First Name" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                        :value="old('first_name')" required />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="last_name" value="Last Name" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                        :value="old('last_name')" />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="phone" value="Phone" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                        :value="old('phone')" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="bio" value="Short Bio" />
                    <x-text-area id="bio" class="block mt-1 w-full" name="bio">{{ old('bio') }}</x-text-area>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="linkedin" value="LinkedIn URL" />
                    <x-text-input id="linkedin" class="block mt-1 w-full" type="url" name="linkedin"
                        :value="old('linkedin')" />
                    <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="instagram" value="Instagram URL" />
                    <x-text-input id="instagram" class="block mt-1 w-full" type="url" name="instagram"
                        :value="old('instagram')" />
                    <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                </div>

                <x-primary-button class="justify-center w-full mt-6">
                    Submit
                </x-primary-button>
            </div>

        </form>
    </div>
</div>
@endsection
