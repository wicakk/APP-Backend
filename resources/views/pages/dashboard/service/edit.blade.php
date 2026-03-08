@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

        <div class="flex mt-6 justify-between items-center">
            <h2 class="font-semibold text-xl">Edit Service</h2>
            @include('pages.dashboard.service.delete-content')
        </div>

        <div class="mt-4" x-data="{ imageUrl: '/storage/public/{{ $service->foto }}' }">
            <form enctype="multipart/form-data" method="POST" action="{{ route('service.update', $service) }}"
                class="flex gap-8">
                @csrf
                @method('PUT')
                
                <div class="w-1/2">
                    <img :src="imageUrl" class="rounded-md" />
                </div>
                <div class="w-1/2">
                    <div class="mt-4">
                        <x-input-label for="foto" :value="__('foto')" />
                        <x-text-input accept="image/*" id="foto" class="block mt-1 w-full border p-2"
                            type="file" name="foto" :value="$service->foto"
                            @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    {{-- <div class="mt-4">
                        <x-input-label for="title" :value="__('title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="$service->title" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="subtitle" :value="__('subtitle')" />
                        <x-text-input id="subtitle" class="block mt-1 w-full" type="text" name="subtitle"
                            :value="$service->subtitle" required />
                        <x-input-error :messages="$errors->get('subtitle')" class="mt-2" />
                    </div> --}}

                    <div class="mt-4">
                        <x-input-label for="nama" :value="__('nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama"
                            :value="$service->nama" required />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="subnama" :value="__('subnama')" />
                        <x-text-input id="subnama" class="block mt-1 w-full" type="text" name="subnama"
                            :value="$service->subnama" required />
                        <x-input-error :messages="$errors->get('subnama')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="price" :value="__('price')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="text" name="price"
                            :value="$service->price" x-mask:dynamic="$money($input, ',')" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="billing_period" :value="__('billing_period')" />
                        <x-text-area id="billing_period" class="block mt-1 w-full" type="text"
                            name="billing_period">{{ $service->billing_period }}</x-text-area>
                        <x-input-error :messages="$errors->get('billing_period')" class="mt-2" />
                    </div>

                    <div class="mt-4" x-data="{ items: {{ json_encode(old('description', $service->description ?? [''])) }} }">
                        <x-input-label for="description" :value="__('Description Items')" />
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex items-center gap-2 mt-2">
                                <x-text-input class="block w-full" type="text" name="description[]"
                                    x-model="items[index]" placeholder="Description item" />
                                <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                    class="px-2 py-1 text-red-600 hover:text-red-800 font-bold text-lg">
                                    &times;
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="items.push('')"
                            class="mt-2 px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Add Item
                        </button>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        <x-input-error :messages="$errors->get('description.*')" class="mt-2" />
                    </div>

                    <x-primary-button class="justify-center w-full mt-4">
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>

            </form>
        </div>

    </div>
@endsection
