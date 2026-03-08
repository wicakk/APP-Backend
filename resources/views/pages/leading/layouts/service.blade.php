<div class="max-w-7xl px-4 py-8 mx-auto lg:py-24 lg:px-6">

    <div class="max-w-3xl mx-auto mb-8 text-center lg:mb-12">
        <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Designed for business teams like yours</h2>
        <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
            Here at Landwind we focus on markets where technology, innovation, and capital can unlock long-term value and drive economic growth.
        </p>
    </div>

    @php $totalPages = max(1, ceil(count($services) / 3)); @endphp

    <div x-data="{ current: 0, pages: {{ $totalPages }} }">

        {{-- Service Cards Grid --}}
        <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
            @foreach ($services as $index => $service)
                <div x-show="Math.floor({{ $index }} / 3) === current"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">

                    <h3 class="mb-4 text-2xl font-semibold">{{ $service->nama }}</h3>

                    <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                        {{ $service->subnama }}
                    </p>

                    <div class="flex items-baseline justify-center my-8">
                        <span class="mr-2 text-5xl font-extrabold">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400">
                            / {{ $service->billing_period }}
                        </span>
                    </div>

                    <ul role="list" class="mb-8 space-y-4 text-left grow">
                        @if(is_array($service->description))
                            @foreach($service->description as $item)
                            <li class="flex items-center space-x-3">
                                <svg class="shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $item }}</span>
                            </li>
                            @endforeach
                        @elseif($service->description)
                            <li class="flex items-center space-x-3">
                                <svg class="shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $service->description }}</span>
                            </li>
                        @endif
                    </ul>

                    <a href="#"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-900">
                        Get started
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Navigation: Prev / Dots / Next --}}
        <br>
        @if($totalPages > 1)
        <div class="flex items-center justify-center mt-10 gap-4">
            {{-- Previous --}}
            <button @click="current = Math.max(0, current - 1)" :disabled="current === 0"
                :class="current === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="w-10 h-10 rounded-full bg-white shadow border border-gray-200 flex items-center justify-center dark:bg-gray-800 dark:border-gray-600">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Dot Indicators --}}
            <div class="flex gap-2">
                @for($i = 0; $i < $totalPages; $i++)
                    <button @click="current = {{ $i }}"
                        :class="current === {{ $i }} ? 'bg-blue-600 w-6' : 'bg-gray-300 dark:bg-gray-600 w-3'"
                        class="h-3 rounded-full transition-all duration-300 hover:bg-blue-400">
                    </button>
                @endfor
            </div>

            {{-- Next --}}
            <button @click="current = Math.min({{ $totalPages - 1 }}, current + 1)" :disabled="current >= {{ $totalPages - 1 }}"
                :class="current >= {{ $totalPages - 1 }} ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="w-10 h-10 rounded-full bg-white shadow border border-gray-200 flex items-center justify-center dark:bg-gray-800 dark:border-gray-600">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        @endif

    </div>

</div>
