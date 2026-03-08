    <div class="max-w-screen-xl px-4 pb-8 mx-auto lg:pb-16">
            <div class="grid grid-cols-2 gap-8 text-gray-500 sm:gap-12 sm:grid-cols-3 lg:grid-cols-6 dark:text-gray-400">
                @foreach ($clients as $client)
                <a href="#" class="flex items-center lg:justify-center">
                    <img src="{{ asset('storage/public/' . $client->foto) }}" class="h-9 hover:text-gray-900 dark:hover:text-white"  alt="hero image">          
                </a>
                @endforeach
            </div>
        </div>