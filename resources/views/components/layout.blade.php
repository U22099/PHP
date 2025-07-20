<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Tailwind CSS CDN - for rapid prototyping -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN for mobile menu toggle -->
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
                <x-nav-link href="/" :active="request()->is('/')">Homepage</x-nav-link>
                <x-nav-link href="/jobs" :active="request()->routeIs('jobs.*')">Jobs</x-nav-link>
                <x-nav-link href="/articles" :active="request()->routeIs('articles.*')">Articles</x-nav-link>
                <x-nav-link href="/posts" :active="request()->routeIs('posts.*')">Posts</x-nav-link>
                <x-nav-link href="/contact" :active="request()->is('contact')">Contact Developer</x-nav-link>
                @guest
                    <x-nav-link href="/login" :active="request()->is('login')" @click="open = false">Log in <span
                            aria-hidden="true">&rarr;</span></x-nav-link>
                @endguest

                @auth
                    {{-- <x-nav-link href="/profile" :active="request()->is('profile')" @click="open = false">Profile <span
                            aria-hidden="true">&rarr;</span></x-nav-link> --}}
                    <form method="POST" action="/logout">
                        @csrf
                        <x-button type="submit">Logout</x-button>
                    </form>
                @endauth
            </div>

            <!-- Mobile Menu Button (Hamburger) -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400 hover:text-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon when menu is open (X icon) -->
                    <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
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
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-700 px-6">
                <div class="space-y-2 py-6 flex gap-4 flex-col">
                    <x-nav-link href="/" :active="request()->is('/')" @click="open = false">Homepage</x-nav-link>
                    <x-nav-link href="/jobs" :active="request()->routeIs('jobs.*')" @click="open = false">Jobs</x-nav-link>
                    <x-nav-link href="/articles" :active="request()->routeIs('articles.*')" @click="open = false">Articles</x-nav-link>
                    <x-nav-link href="/posts" :active="request()->routeIs('posts.*')" @click="open = false">Posts</x-nav-link>
                    <x-nav-link href="/contact" :active="request()->is('contact')" @click="open = false">Contact Developer</x-nav-link>
                </div>
                <div class="py-6">
                    @guest
                        <x-nav-link href="/login" :active="request()->is('login')" @click="open = false">Log in <span
                                aria-hidden="true">&rarr;</span></x-nav-link>
                    @endguest

                    @auth
                        <x-nav-link href="/profile" :active="request()->is('profile')" @click="open = false">Profile <span
                                aria-hidden="true">&rarr;</span></x-nav-link>
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
