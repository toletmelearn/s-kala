<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ ($pageTitle ?? 'Admin') . ' | ' . config('app.name', 'S-kala') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-stone-900">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-[#fbf7f0]">
            <div x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-40 bg-stone-950/40 lg:hidden"
                @click="sidebarOpen = false"
                aria-hidden="true"></div>

            @include('admin.partials.sidebar')

            <div class="min-h-screen lg:pl-72">
                @include('admin.partials.topbar')

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-7xl">
                        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-sm font-medium text-rose-700">{{ $breadcrumb ?? 'Admin' }}</p>
                                <h1 class="mt-1 text-2xl font-semibold tracking-normal text-stone-950 sm:text-3xl">
                                    {{ $pageTitle ?? 'Admin Dashboard' }}
                                </h1>
                            </div>
                            <div class="rounded-full border border-rose-100 bg-white px-4 py-2 text-sm font-medium text-stone-600 shadow-sm">
                                S-kala Digital Workspace
                            </div>
                        </div>

                        {{ $slot }}
                    </div>
                </main>

                <footer class="px-4 pb-6 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-7xl border-t border-rose-100 pt-5 text-sm text-stone-500">
                        S-kala – Shakuntala Shishu Lok | Skill, Strength &amp; Self-Reliance
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
