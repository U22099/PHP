<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @isset($title)
        <title>{{ $title }}</title>
    @endisset
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
    <div class="bg-black text-white shadow-md">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 px-6 md:px-8" aria-label="Global">
            <a href="/" class="font-bold text-xl flex-shrink-0">Laravel Test</a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex md:gap-8 lg:gap-12 md:text-lg flex-grow justify-end items-center">
                <x-nav-link href="/" :active="request()->is('/')">
                    <x-slot:icon><x-heroicon-o-home class="h-5 w-5" /></x-slot:icon> {{-- Added Home icon --}}
                    Homepage
                </x-nav-link>
                <x-nav-link href="/jobs" :active="request()->routeIs('jobs.*')">
                    <x-slot:icon><x-heroicon-o-briefcase class="h-5 w-5" /></x-slot:icon>
                    {{-- Added Briefcase icon --}}
                    Jobs
                </x-nav-link>
                <x-nav-link href="/articles" :active="request()->routeIs('articles.*')">
                    <x-slot:icon><x-heroicon-o-book-open class="h-5 w-5" /></x-slot:icon>
                    {{-- Added Book Open icon --}}
                    Articles
                </x-nav-link>
                <x-nav-link href="/posts" :active="request()->routeIs('posts.*')">
                    <x-slot:icon><x-heroicon-o-document-text class="h-5 w-5" /></x-slot:icon>
                    {{-- Added Document Text icon --}}
                    Posts
                </x-nav-link>
                <x-nav-link href="/contact" :active="request()->is('contact')">
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
                    <x-nav-link href="/profile" :active="request()->is('profile')" @click="open = false">
                        <x-slot:icon><x-heroicon-o-user class="h-5 w-5" /></x-slot:icon>
                        {{-- Added User icon --}}
                        Profile <span aria-hidden="true">&rarr;</span>
                    </x-nav-link>
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
            <a href="/" class="font-bold text-xl text-white flex-shrink-0">Laravel Test</a>
            <button @click="open = false" type="button"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400 hover:text-white">
                <span class="sr-only">Close menu</span>
                <x-heroicon-o-x-mark class="h-6 w-6" /> {{-- Replaced X Mark SVG --}}
            </button>
        </div>
        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-700 px-6">
                <div class="space-y-2 py-6 flex gap-4 flex-col">
                    <x-nav-link href="/" :active="request()->is('/')" @click="open = false">
                        <x-slot:icon><x-heroicon-o-home class="h-6 w-6" /></x-slot:icon>
                        {{-- Added Home icon --}}
                        Homepage
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
                    <x-nav-link href="/posts" :active="request()->routeIs('posts.*')" @click="open = false">
                        <x-slot:icon><x-heroicon-o-document-text class="h-6 w-6" /></x-slot:icon>
                        {{-- Added Document Text icon --}}
                        Posts
                    </x-nav-link>
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
