<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @isset($title)
        <title>{{ $title }} | {{ config('app.name') }}</title>
    @endisset
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'A platform for developers to connect, collaborate, and find amazing job opportunities.')">
    <meta property="og:image" content="{{ asset('images/default-social-share.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@bidmax">
    <meta name="twitter:creator" content="@u22099">
    <meta name="twitter:title" content="@yield('og_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('og_description', 'A platform for developers to connect, collaborate, and find amazing job opportunities.')">
    <meta name="twitter:image" content="{{ asset('images/default-social-share.jpg') }}">
    <meta name="twitter:image:width" content="1200">
    <meta name="twitter:image:height" content="630">

    @yield('social_meta_tags')

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- @vite(['resources/js/app.js']) --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-text {
            background: linear-gradient(to right, #6366f1, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col" x-data="{ open: false }">
    <!-- Navbar -->
    <div class="bg-black text-white shadow-md sticky top-0 z-30 w-full">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 px-6 md:px-8" aria-label="Global">
            <a href="/" class="font-bold text-xl flex-shrink-0">{{ config('app.name') }}</a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex md:gap-8 lg:gap-12 md:text-lg flex-grow justify-end items-center">
                <x-nav-link href="/" :active="request()->is('/') || (Auth::check() ? request()->routeIs('posts.*') : false)">
                    <x-slot:icon><x-heroicon-o-home class="h-5 w-5" /></x-slot:icon> {{-- Added Home icon --}}
                    Home
                </x-nav-link>
                <x-nav-link href="/jobs" :active="request()->routeIs('jobs.*') || request()->routeIs('bids.*')">
                    <x-slot:icon><x-heroicon-o-briefcase class="h-5 w-5" /></x-slot:icon>
                    {{-- Added Briefcase icon --}}
                    Jobs
                </x-nav-link>
                <x-nav-link href="/articles" :active="request()->routeIs('articles.*')">
                    <x-slot:icon><x-heroicon-o-book-open class="h-5 w-5" /></x-slot:icon>
                    {{-- Added Book Open icon --}}
                    Articles
                </x-nav-link>
                @guest
                    <x-nav-link href="/posts" :active="request()->routeIs('posts.*')">
                        <x-slot:icon><x-heroicon-o-document-text class="h-5 w-5" /></x-slot:icon>
                        {{-- Added Document Text icon --}}
                        Posts
                    </x-nav-link>
                @endguest
                <x-nav-link href="/contact" :active="request()->routeIs('contact.*')">
                    <x-slot:icon><x-heroicon-o-envelope class="h-5 w-5" /></x-slot:icon>
                    {{-- Added Envelope icon --}}
                    Contact Developer
                </x-nav-link>
                @guest
                    <x-nav-link href="/login" :active="request()->is('login')" @click="open = false">
                        <x-slot:icon><x-heroicon-o-arrow-right-on-rectangle class="h-5 w-5" /></x-slot:icon>
                        {{-- Added Login icon --}}
                        Log in <span aria-hidden="true">&rarr;</span>
                    </x-nav-link>
                @endguest
                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center text-lg">
                            <img class="w-12 h-12 rounded-full object-cover mr-2"
                                src="{{ Auth::user()->image ? Auth::user()->image : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->firstname . ' ' . Auth::user()->lastname) . '&color=FFFFFF&background=312e81' }}"
                                alt="{{ Auth::user()->username }}">
                            <span>{{ Auth::user()->username }}</span>
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 text-black">
                            <a href="{{ route('profile.show') }}"
                                class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
                            <a href="{{ route('subscription.show') }}"
                                class="block px-4 py-2 text-sm hover:bg-gray-100">Subscription</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Log Out</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu Button (Hamburger) -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400 hover:text-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <x-heroicon-o-bars-3 x-show="!open" class="h-6 w-6" /> {{-- Replaced Bars 3 SVG --}}
                    <!-- Icon when menu is open (X icon) -->
                    <x-heroicon-o-x-mark x-show="open" class="h-6 w-6" /> {{-- Replaced X Mark SVG --}}
                </button>
            </div>
        </nav>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="open" x-transition:enter="duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-100 ease-in"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="md:hidden fixed inset-0 z-50 bg-black bg-opacity-95 overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4">
            <a href="/" class="font-bold text-xl text-white flex-shrink-0">{{ config('app.name') }}</a>
            <button @click="open = false" type="button"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400 hover:text-white">
                <span class="sr-only">Close menu</span>
                <x-heroicon-o-x-mark class="h-6 w-6" /> {{-- Replaced X Mark SVG --}}
            </button>
        </div>
        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-700 px-6">
                <div class="space-y-2 py-6 flex gap-4 flex-col">
                    <x-nav-link href="/" :active="request()->is('/') || (Auth::check() ? request()->routeIs('posts.*') : false)" @click="open = false">
                        <x-slot:icon><x-heroicon-o-home class="h-6 w-6" /></x-slot:icon>
                        {{-- Added Home icon --}}
                        Home
                    </x-nav-link>
                    <x-nav-link href="/jobs" :active="request()->routeIs('jobs.*')" @click="open = false">
                        <x-slot:icon><x-heroicon-o-briefcase class="h-6 w-6" /></x-slot:icon>
                        {{-- Added Briefcase icon --}}
                        Jobs
                    </x-nav-link>
                    <x-nav-link href="/articles" :active="request()->routeIs('articles.*')" @click="open = false">
                        <x-slot:icon><x-heroicon-o-book-open class="h-6 w-6" /></x-slot:icon>
                        {{-- Added Book Open icon --}}
                        Articles
                    </x-nav-link>
                    @guest
                        <x-nav-link href="/posts" :active="request()->routeIs('posts.*')" @click="open = false">
                            <x-slot:icon><x-heroicon-o-document-text class="h-6 w-6" /></x-slot:icon>
                            {{-- Added Document Text icon --}}
                            Posts
                        </x-nav-link>
                    @endguest
                    @auth
                        <x-nav-link href="/subscription" :active="request()->routeIs('subscription.*')">
                            <x-slot:icon>
                                <x-fluentui-premium-person-24-o class="h-5 w-5" />
                            </x-slot:icon>
                            Subscription
                        </x-nav-link>
                    @endauth
                    <x-nav-link href="/contact" :active="request()->is('contact')" @click="open = false">
                        <x-slot:icon><x-heroicon-o-envelope class="h-6 w-6" /></x-slot:icon>
                        {{-- Added Envelope icon --}}
                        Contact Developer
                    </x-nav-link>
                </div>
                <div class="py-6">
                    @guest
                        <x-nav-link href="/login" :active="request()->is('login')" @click="open = false">
                            <x-slot:icon><x-heroicon-o-arrow-right-on-rectangle class="h-6 w-6" /></x-slot:icon> {{-- Added Login icon --}}
                            Log in <span aria-hidden="true">&rarr;</span>
                        </x-nav-link>
                    @endguest

                    @auth
                        <x-nav-link href="/profile" :active="request()->is('profile')" @click="open = false">
                            <x-slot:icon><x-heroicon-o-user class="h-6 w-6" /></x-slot:icon>
                            {{-- Added User icon --}}
                            Profile <span aria-hidden="true">&rarr;</span>
                        </x-nav-link>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Header for Heading -->
    @isset($heading)
        <header class="bg-white shadow w-full">
            <div class="flex justify-between items-center mx-auto max-w-7xl px-6 md:px-8 w-full">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 py-2 sm:py-4">{{ $heading }}</h1>
                @isset($headerbutton)
                    {{ $headerbutton }}
                @endisset
            </div>
        </header>
    @endisset


    <!-- Main Content -->
    <main class="flex-grow">
        <div class="mx-auto max-w-7xl p-2 lg:py-6 lg:px-6">
            {{ $slot }}
        </div>
    </main>
</body>

</html>
