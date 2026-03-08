<div class="items-center max-w-screen-xl px-4 py-8 mx-auto lg:grid lg:grid-cols-4 lg:gap-16 xl:gap-24 lg:py-24 lg:px-6">
    @foreach ($visis as $visi)
    <div class="col-span-2 mb-8">
        <p class="text-lg font-medium text-blue-600 dark:text-blue-500">Visi & Misi</p>
        <h2 class="mt-3 mb-4 text-3xl font-extrabold tracking-tight text-gray-900 md:text-3xl dark:text-white">
            {{ $visi->title }}
        </h2>
        <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">
            {{ $visi->deskripsi }}
        </p>
        <div class="pt-6 mt-6 space-y-4 border-t border-gray-200 dark:border-gray-700">
            <div>
                <a href="#"
                    class="inline-flex items-center text-base font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">
                    Explore Legality Guide
                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <div>
                <a href="#"
                    class="inline-flex items-center text-base font-medium text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-700">
                    Visit the Trust Center
                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="col-span-2 space-y-8 md:grid md:grid-cols-2 md:gap-12 md:space-y-0">
        @foreach ($misis as $misi)
        <div>
            @if($misi->foto)
            <img src="{{ asset('storage/' . $misi->foto) }}" alt="{{ $misi->title }}" class="w-10 h-10 mb-2 md:w-12 md:h-12 rounded-lg object-cover">
            @else
            <svg class="w-10 h-10 mb-2 text-blue-600 md:w-12 md:h-12 dark:text-blue-500" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            @endif
            <h3 class="mb-2 text-2xl font-bold dark:text-white">{{ $misi->title }}</h3>
            <p class="font-light text-gray-500 dark:text-gray-400">{{ $misi->deskripsi }}</p>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
