<header class="sticky top-0 z-30 border-b border-rose-100 bg-[#fbf7f0]/90 backdrop-blur">
    <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button type="button"
                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-rose-100 bg-white text-stone-700 shadow-sm lg:hidden"
                @click="sidebarOpen = true"
                aria-label="Open sidebar">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>

            <div>
                <p class="text-sm font-medium text-stone-500">Women Empowerment Workspace</p>
                <p class="text-base font-semibold text-stone-950">Shakuntala Shishu Lok</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden rounded-full border border-amber-100 bg-white px-4 py-2 text-sm font-medium text-stone-600 shadow-sm sm:block">
                Inaugurated 14 May 2025
            </div>

            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button class="flex items-center gap-3 rounded-2xl border border-rose-100 bg-white px-3 py-2 text-left shadow-sm transition hover:border-rose-200">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 text-sm font-semibold text-rose-900">
                            {{ Str::of(Auth::user()->name)->substr(0, 1)->upper() }}
                        </span>
                        <span class="hidden sm:block">
                            <span class="block text-sm font-semibold text-stone-950">{{ Auth::user()->name }}</span>
                            <span class="block text-xs text-stone-500">{{ Auth::user()->getRoleNames()->first() ?? 'Team Member' }}</span>
                        </span>
                        <svg class="h-4 w-4 text-stone-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-3">
                        <p class="text-sm font-semibold text-stone-900">{{ Auth::user()->name }}</p>
                        <p class="mt-1 text-xs text-stone-500">{{ Auth::user()->email }}</p>
                    </div>

                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
