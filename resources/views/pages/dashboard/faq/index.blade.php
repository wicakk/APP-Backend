@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Content FAQ" />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

        @if (session()->has('success'))
            <x-alert message="{{ session('success') }}" />
        @endif

        <div class="mt-6 justify-start">
            <a href="{{ route('faq.create') }}">
                <button class="bg-blue-500 text-white px-10 py-2 rounded-md font-semibold">Add</button>
            </a>
        </div>

        <div class="mt-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold text-sm">#</th>
                        <th class="py-3 px-4 font-semibold text-sm">Question</th>
                        <th class="py-3 px-4 font-semibold text-sm">Answer</th>
                        <th class="py-3 px-4 font-semibold text-sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faqs as $index => $faq)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $faqs->firstItem() + $index }}</td>
                            <td class="py-3 px-4">{{ $faq->question }}</td>
                            <td class="py-3 px-4">{{ Str::limit($faq->answer, 80) }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('faq.edit', $faq) }}">
                                    <button class="bg-gray-100 px-6 py-2 rounded-md font-semibold">Edit</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $faqs->links() }}
        </div>

    </div>
@endsection
