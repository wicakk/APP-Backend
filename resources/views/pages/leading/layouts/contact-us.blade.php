<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Support Section</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* hide scrollbar */
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }
    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>
<body class="bg-gray-50">

    <header class="fixed w-full z-50">
    <nav class="bg-white border-gray-200 py-2.5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="./images/logo.svg" class="h-6 mr-3 sm:h-9" alt="Company Logo" />
                <span class="self-center text-xl font-semibold whitespace-nowrap text-gray-900">
                    PT Digital Teknologi Quantum
                </span>
            </a>

            <!-- Right button -->
            <div class="flex items-center lg:order-2">
                <div class="hidden mt-2 mr-4 sm:inline-block">
                    <a href="{{ url('/') }}#service"
                        class="text-blue-700 font-semibold hover:underline">
                        Get Started
                    </a>
                </div>

                <a href="{{ url('/contact-us') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 sm:mr-2 lg:mr-0">
                    Contact
                </a>

                <!-- Mobile Button -->
                <button data-collapse-toggle="mobile-menu-2" type="button"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Menu -->
            <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1"
                id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">

                    <li>
                        <a href="{{ url('/') }}"
                            class="block py-2 pl-3 pr-4 text-blue-700 font-semibold lg:p-0">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/') }}#wepper-content2"
                            class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                            Visi & Misi
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/') }}#client"
                            class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                            Clients
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/') }}#service"
                            class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                            Service
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/team') }}"
                            class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                            Team
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>


<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-6 text-center">

    <!-- Header -->
    <p class="text-sm text-blue-600 font-medium mb-3">
      Contact us
    </p>

    <h2 class="text-4xl font-bold text-gray-900 mb-4">
      Need help? We’re here for you 24/7.
    </h2>

    <p class="text-gray-500 max-w-2xl mx-auto mb-8">
      Our dedicated team of growth experts is ready to help around the clock.
      Access 24/7 support through our award-winning network.
    </p>

    <!-- Buttons -->
    <div class="flex justify-center gap-4 mb-16">
      <button
        class="flex items-center gap-2 px-6 py-3 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100">
        PT Digital Teknologi Quantum Teams
      </button>
      <button
        class="px-6 py-3 rounded-full bg-blue-600 text-white hover:bg-blue-700">
        Contact Teams
      </button>
    </div>

    <!-- Team Slider -->
    <div class="relative">
      <div class="flex gap-6 overflow-x-auto pb-6 scrollbar-hide">

        <!-- Card -->
        <div class="min-w-[220px] bg-white rounded-2xl shadow-lg p-4 text-center">
          <img src="https://i.pravatar.cc/150?img=12"
            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
          <h4 class="font-semibold text-gray-900">Marcus Williams</h4>
          <p class="text-sm text-gray-500">Customer Success Lead</p>
        </div>

        <div class="min-w-[220px] bg-white rounded-2xl shadow-lg p-4 text-center">
          <img src="https://i.pravatar.cc/150?img=32"
            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
          <h4 class="font-semibold text-gray-900">Heidi Anders</h4>
          <p class="text-sm text-gray-500">VP of Customer Success</p>
        </div>

        <div class="min-w-[220px] bg-white rounded-2xl shadow-lg p-4 text-center">
          <img src="https://i.pravatar.cc/150?img=45"
            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
          <h4 class="font-semibold text-gray-900">Frankie Sullivan</h4>
          <p class="text-sm text-gray-500">Payments Support</p>
        </div>

        <div class="min-w-[220px] bg-white rounded-2xl shadow-lg p-4 text-center">
          <img src="https://i.pravatar.cc/150?img=18"
            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
          <h4 class="font-semibold text-gray-900">Richard Mills</h4>
          <p class="text-sm text-gray-500">Payments Support</p>
        </div>

        <div class="min-w-[220px] bg-white rounded-2xl shadow-lg p-4 text-center">
          <img src="https://i.pravatar.cc/150?img=9"
            class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
          <h4 class="font-semibold text-gray-900">Sophie Chamberlain</h4>
          <p class="text-sm text-gray-500">Specialized Support</p>
        </div>

      </div>
    </div>

    <!-- Contact Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-20 text-left">

      <!-- Form -->
      <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <input type="text" name="first_name" placeholder="First name" class="border rounded-lg px-4 py-2 w-full">
                <input type="text" name="last_name" placeholder="Last name" class="border rounded-lg px-4 py-2 w-full">
            </div>

            <input type="email" name="email" placeholder="you@company.com"
                class="border rounded-lg px-4 py-2 w-full mb-4">

            <input type="text" name="phone" placeholder="(+62)"
                class="border rounded-lg px-4 py-2 w-full mb-4">

            <textarea name="message" placeholder="Message Your ..."
                class="border rounded-lg px-4 py-2 w-full mb-4"></textarea>

            <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                Submit
            </button>
        </form>


      <!-- Info -->
      <div>
        <h4 class="font-semibold mb-2">Chat to sales</h4>
        <p class="text-gray-500 mb-4">
          Interested in switching? Speak to our friendly team.
        </p>
        <a href="#" class="text-blue-600 font-medium">
          sales@untitledui.com
        </a>

        <h4 class="font-semibold mt-8 mb-2">Email support</h4>
        <p class="text-gray-500">
          Email us and we’ll get back to you within 24 hours.
        </p>
        <a href="#" class="text-blue-600 font-medium">
          support@untitledui.com
        </a>
      </div>

    </div>
  </div>
</section>


<footer class="bg-white">
    <div class="max-w-screen-xl p-4 py-6 mx-auto lg:py-16 md:p-8 lg:p-10">

        <div class="grid grid-cols-2 gap-8 md:grid-cols-3 lg:grid-cols-5">

            <!-- Company -->
            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-900 uppercase">
                    Company
                </h3>
                <ul class="text-gray-500">
                    <li class="mb-4"><a href="#" class="hover:underline">About</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Careers</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Brand Center</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Blog</a></li>
                </ul>
            </div>

            <!-- Help Center -->
            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-900 uppercase">
                    Help Center
                </h3>
                <ul class="text-gray-500">
                    <li class="mb-4"><a href="#" class="hover:underline">Discord Server</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Twitter</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Facebook</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Contact Us</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-900 uppercase">
                    Legal
                </h3>
                <ul class="text-gray-500">
                    <li class="mb-4"><a href="#" class="hover:underline">Privacy Policy</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Licensing</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Terms</a></li>
                </ul>
            </div>

            <!-- Company Duplicate (kalau mau, bisa diganti) -->
            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-900 uppercase">
                    Company
                </h3>
                <ul class="text-gray-500">
                    <li class="mb-4"><a href="#" class="hover:underline">About</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Careers</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Brand Center</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Blog</a></li>
                </ul>
            </div>

            <!-- Download -->
            <div>
                <h3 class="mb-6 text-sm font-semibold text-gray-900 uppercase">
                    Download
                </h3>
                <ul class="text-gray-500">
                    <li class="mb-4"><a href="#" class="hover:underline">iOS</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Android</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">Windows</a></li>
                    <li class="mb-4"><a href="#" class="hover:underline">MacOS</a></li>
                </ul>
            </div>

        </div>

        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8">

    </div>
</footer>


</body>
</html>
