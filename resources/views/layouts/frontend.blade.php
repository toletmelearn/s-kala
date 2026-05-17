<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ ($title ?? ($settings?->site_name ?? 'S-kala')) . ' | ' . ($settings?->tagline ?? 'Skill, Strength & Self-Reliance') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#fbf7f0] font-sans text-stone-900 antialiased">
        @include('frontend.partials.navbar')

        <main>
            @yield('content')
        </main>

        @include('frontend.partials.footer')
    </body>
</html>
