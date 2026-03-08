@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

        <div class="flex mt-6">
            <h2 class="font-semibold text-xl">Add FAQ</h2>
        </div>

        <div class="mt-4">
            <form method="POST" action="{{ route('faq.store') }}" class="max-w-2xl">
                @csrf

                <div class="mt-4">
                    <x-input-label for="question" :value="__('Question')" />
                    <x-text-input id="question" class="block mt-1 w-full" type="text" name="question"
                        :value="old('question')" required />
                    <x-input-error :messages="$errors->get('question')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="answer" :value="__('Answer')" />
                    <x-text-area id="answer" class="block mt-1 w-full" type="text"
                        name="answer">{{ old('answer') }}</x-text-area>
                    <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                </div>

                <x-primary-button class="justify-center w-full mt-4">
                    {{ __('Submit') }}
                </x-primary-button>
            </form>
        </div>

    </div>
@endsection
