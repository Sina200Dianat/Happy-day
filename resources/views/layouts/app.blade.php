<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'A Surprise')</title>
    {{-- Vite will compile Tailwind + JS. Run `npm install && npm run build` to generate production assets. --}}
    @php $viteManifest = public_path('build/manifest.json'); @endphp
    @if (app()->environment('local'))
      {{-- In dev we expect the Vite dev server to serve assets. --}}
      @vite(['resources/css/app.css','resources/js/app.js'])
    @elseif (file_exists($viteManifest))
      {{-- In production, use the built manifest if present. --}}
      @vite(['resources/css/app.css','resources/js/app.js'])
    @else
      {{-- Vite manifest not found: avoid throwing an exception. --}}
      <!-- Vite manifest not found at public/build/manifest.json. Run `npm install && npm run build`. -->
    @endif
    <style>
      /* gentle pastel background fallback */
      body { background: linear-gradient(180deg,#fff0f3 0%, #fff7f0 100%); }
    </style>
    {{-- Alpine (for simple interactivity) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body class="min-h-screen bg-cover bg-center font-sans text-gray-800">
    @yield('content')
  </body>
  </html>
