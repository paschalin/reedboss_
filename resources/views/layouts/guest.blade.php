<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:image" content="{{ $thread->image }}">


  <title>{{ config('app.name', 'Reedboss') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <div
    class="font-sans bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 antialiased w-full min-h-screen flex items-center justify-center">
    {{ $slot }}
  </div>
</body>

</html>
