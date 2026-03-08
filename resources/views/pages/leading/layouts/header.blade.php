
    <header class="fixed w-full">
        <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="./images/logo.svg" class="h-6 mr-3 sm:h-9" alt="{{ $profile->first_name ?? 'Company' }} Logo" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ $profile->first_name ?? 'Company' }}</span>
                </a>
                <div class="flex items-center lg:order-2">
                    <div class="hidden mt-2 mr-4 sm:inline-block">
                        <a class="github-button" href="{{ url('/') }}#service" data-size="large" data-icon="octicon-star" data-show-count="true" aria-label="Star themesberg/company on GitHub">Get Started</a>
                    </div>
                    <!-- <a href="#" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log in</a> -->
                <a href="{{ url('/') }}/contact-us" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Contact</a>
                    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0" x-data="{ activeLink: window.location.hash || (window.location.pathname === '/' || window.location.pathname === '' ? '#home' : window.location.pathname) }" x-init="
                        window.addEventListener('hashchange', () => { activeLink = window.location.hash || '#home' });
                        document.querySelectorAll('a[href*=\'#\']').forEach(a => {
                            a.addEventListener('click', () => { setTimeout(() => { activeLink = new URL(a.href).hash || '#home' }, 100) })
                        });
                    ">
                        <li>
                            <a href="{{ url('/') }}" @click="activeLink = '#home'"
                               :class="activeLink === '#home' ? 'text-blue-700 lg:text-blue-700' : 'text-gray-700 dark:text-gray-400'"
                               class="block py-2 pl-3 pr-4 rounded border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 transition-colors duration-200">Home</a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}#wepper-content2" @click="activeLink = '#wepper-content2'"
                               :class="activeLink === '#wepper-content2' ? 'text-blue-700 lg:text-blue-700' : 'text-gray-700 dark:text-gray-400'"
                               class="block py-2 pl-3 pr-4 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 transition-colors duration-200">Visi & Misi</a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}#client" @click="activeLink = '#client'"
                               :class="activeLink === '#client' ? 'text-blue-700 lg:text-blue-700' : 'text-gray-700 dark:text-gray-400'"
                               class="block py-2 pl-3 pr-4 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 transition-colors duration-200">Clients</a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}#service" @click="activeLink = '#service'"
                               :class="activeLink === '#service' ? 'text-blue-700 lg:text-blue-700' : 'text-gray-700 dark:text-gray-400'"
                               class="block py-2 pl-3 pr-4 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 transition-colors duration-200">Service</a>
                        </li>
                        <li>
                            <a href="{{ url('/team') }}" @click="activeLink = '/team'"
                               :class="activeLink === '/team' ? 'text-blue-700 lg:text-blue-700' : 'text-gray-700 dark:text-gray-400'"
                               class="block py-2 pl-3 pr-4 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 transition-colors duration-200">Team</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>