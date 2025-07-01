<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Homepage</title>
</head>
<body>
  <div class="bg-black text-white">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-2 px-8" aria-label="Global">
      <a href="#" class="mr-40 text-gray-200 font-bold text-xl">Test</a>
      <div class="flex gap-12 w-full">
        <x-nav-link href="/" :active="request()->is('/')">Homepage</x-nav-link>
        <x-nav-link href="/jobs" :active="request()->is('jobs')">Jobs</x-nav-link>
        <x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link>
      <div class="flex flex-1 justify-end">
        <x-nav-link href="/login" :active="request()->is('login')">Log in <span aria-hidden="true">&rarr;</span></x-nav-link>
      </div>
    </nav>
  </div>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 py-3">{{ $heading }}</h1>
    </div>
  </header>
  <main>
    <div class="mx-auto max-w-7xl py-6 px-8">
      {{ $slot }}
    </div>
  </main>
</body>
</html>