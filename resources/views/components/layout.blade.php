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
      <a href="#" class="mr-1.5 p-1.5">
        Test
      </a>
      <div class="flex gap-12 w-full">
        <a href="/" class="text-sm/6 font-semibold text-gray-200">Homepage</a>
        <a href="/about" class="text-sm/6 font-semibold text-gray-200">About</a>
        <a href="/contact" class="text-sm/6 font-semibold text-gray-200">Contact</a>
      <div class="flex flex-1 justify-end">
        <a href="/login" class="text-sm/6 font-semibold text-gray-200">Log in <span aria-hidden="true">&rarr;</span></a>
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