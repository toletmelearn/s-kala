@php
    $menuItems = [
        ['label' => 'Home', 'href' => url('/#home')],
        ['label' => 'About', 'href' => url('/#about')],
        ['label' => 'Vision', 'href' => url('/#vision')],
        ['label' => 'Training', 'href' => route('training.index')],
        ['label' => 'Trainers', 'href' => route('training.trainers')],
        ['label' => 'Products', 'href' => url('/#products')],
        ['label' => 'Impact', 'href' => url('/#impact')],
        ['label' => 'Gallery', 'href' => url('/#gallery')],
        ['label' => 'Contact', 'href' => url('/#contact')],
    ];
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-rose-100 bg-[#fbf7f0]/90 backdrop-blur">
    <nav class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8" aria-label="Primary navigation">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            @if ($settings?->logo && file_exists(public_path($settings->logo)))
                <img src="{{ asset($settings->logo) }}" alt="{{ $settings->site_name }}" class="h-11 w-auto rounded-xl object-contain">
            @else
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-900 text-sm font-bold text-white shadow-lg shadow-rose-900/20">
                    Sk
                </span>
            @endif
            <span>
                <span class="block text-base font-bold text-stone-950">{{ $settings?->site_name ?? 'S-kala' }}</span>
                <span class="hidden text-xs font-semibold uppercase tracking-[0.18em] text-rose-700 sm:block">{{ $settings?->tagline ?? 'Skill, Strength & Self-Reliance' }}</span>
            </span>
        </a>

        <div class="hidden items-center gap-7 lg:flex">
            @foreach ($menuItems as $item)
                <a href="{{ $item['href'] }}" class="text-sm font-semibold text-stone-600 transition hover:text-rose-900">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-rose-100 bg-white px-4 py-2 text-sm font-semibold text-stone-700 shadow-sm transition hover:bg-rose-50">
                    Admin
                </a>
            @endauth
            <a href="{{ route('join.create') }}" class="rounded-full bg-rose-900 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 transition hover:bg-rose-800">
                Join S-kala
            </a>
        </div>

        <button type="button"
            class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-rose-100 bg-white text-stone-700 shadow-sm lg:hidden"
            @click="open = ! open"
            aria-label="Toggle navigation">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <path x-show="! open" d="M4 7h16M4 12h16M4 17h16" />
                <path x-show="open" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
    </nav>

    <div x-show="open" x-transition class="border-t border-rose-100 bg-white lg:hidden">
        <div class="mx-auto max-w-7xl space-y-1 px-4 py-4 sm:px-6">
            @foreach ($menuItems as $item)
                <a href="{{ $item['href'] }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-stone-700 hover:bg-rose-50" @click="open = false">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a href="{{ route('join.create') }}" class="mt-3 block rounded-xl bg-rose-900 px-4 py-3 text-center text-sm font-semibold text-white" @click="open = false">
                Join S-kala
            </a>
        </div>
    </div>
</header>
