@extends('pages.layout')

@include('pages.leading.layouts.header')
@section('content')
    <section class="bg-white" style="padding-top: 120px; ">
        <div class="max-w-6xl mx-auto px-6 text-center">

            <!-- Heading -->
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Meet the Team</h2>
            <p class="text-gray-500 max-w-2xl mx-auto mb-14">
                With over 8 years of combined experience, we've got a well-seasoned
                team at the BlockSAFU.
            </p>

            <!-- Team Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" style="margin: 40px">

                @foreach ($teams as $team)
                    <div style="background-color: {{ $loop->index % 2 === 0 ? '#E0E7FF' : '#FEF3C7' }}; border-radius: 50px 0 50px 0; overflow: hidden;">
                        <div style="display: flex; align-items: flex-end; justify-content: center; height: 260px; padding: 2rem 1rem 0;">
                            <img src="{{ $team->photo
                                ? asset('storage/' . $team->photo)
                                : 'https://api.dicebear.com/7.x/initials/svg?seed=' . $team->first_name }}"
                                style="height: 100%; width: auto; object-fit: contain; object-position: bottom;" />
                        </div>
                        <div style="padding: 8px 16px 16px; text-align: center;">
                            <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">
                                {{ $team->first_name }} {{ $team->last_name }}
                            </h3>
                            <p style="font-size: 0.875rem; color: #6B7280; margin: 4px 0 0;">
                                {{ $team->bio }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@include('pages.leading.layouts.footer')

@endsection
