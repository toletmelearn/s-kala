@php
    $navigation = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'permission' => 'dashboard.view', 'icon' => 'M3 13.5l9-9 9 9M5.25 11.25V21h13.5v-9.75'],
        ['label' => 'Website CMS', 'route' => 'admin.website.index', 'active' => 'admin.website.*', 'permission' => 'website.manage', 'icon' => 'M4.5 6.75h15M4.5 12h15M4.5 17.25h9'],
        ['label' => 'Training Programs', 'route' => 'admin.training-programs.index', 'active' => 'admin.training-programs.*', 'permission' => 'programs.manage', 'icon' => 'M12 6.75v10.5M6.75 12h10.5M4.5 19.5h15a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5h-15A1.5 1.5 0 003 6v12a1.5 1.5 0 001.5 1.5z'],
        ['label' => 'Trainers', 'route' => 'admin.trainers.index', 'active' => 'admin.trainers.*', 'permission' => 'trainers.manage', 'icon' => 'M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 21a7.5 7.5 0 0115 0'],
        ['label' => 'Trainees', 'route' => 'admin.trainees.index', 'active' => 'admin.trainees.*', 'permission' => 'trainees.manage', 'icon' => 'M8.25 8.25a3 3 0 116 0 3 3 0 01-6 0zM3.75 20.25a8.25 8.25 0 0116.5 0'],
        ['label' => 'Products', 'route' => null, 'permission' => 'products.manage', 'icon' => 'M6 7.5h12l-1.5 12h-9L6 7.5zM8.25 7.5a3.75 3.75 0 017.5 0'],
        ['label' => 'Gallery', 'route' => 'admin.gallery.index', 'active' => 'admin.gallery.*', 'permission' => 'gallery.manage', 'icon' => 'M4.5 5.25h15v13.5h-15V5.25zM7.5 15l3-3 2.25 2.25 1.5-1.5L18 16.5'],
        ['label' => 'Events', 'route' => 'admin.events.index', 'active' => 'admin.events.*', 'permission' => 'events.manage', 'icon' => 'M6.75 3.75v3M17.25 3.75v3M4.5 8.25h15M5.25 6h13.5v13.5H5.25V6z'],
        ['label' => 'Success Stories', 'route' => null, 'permission' => 'success_stories.manage', 'icon' => 'M12 20.25s-7.5-4.5-7.5-10.125A4.125 4.125 0 0112 7.875a4.125 4.125 0 017.5 2.25C19.5 15.75 12 20.25 12 20.25z'],
        ['label' => 'CSR Reports', 'route' => null, 'permission' => 'csr_reports.manage', 'icon' => 'M7.5 3.75h7.5L19.5 8.25v12h-15V3.75h3zM15 3.75v4.5h4.5M8.25 12h7.5M8.25 15h7.5M8.25 18h4.5'],
        ['label' => 'Certificates', 'route' => null, 'permission' => 'certificates.manage', 'icon' => 'M6 4.5h12v15H6v-15zM9 8.25h6M9 11.25h6M9.75 15.75l2.25-1.5 2.25 1.5'],
        ['label' => 'Enquiries', 'route' => null, 'permission' => 'enquiries.manage', 'icon' => 'M4.5 6.75h15v10.5h-15V6.75zM4.5 7.5L12 13.5l7.5-6'],
        ['label' => 'Settings', 'route' => null, 'permission' => 'settings.manage', 'icon' => 'M12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5zM4.5 12h2.25M17.25 12h2.25M6.72 6.72l1.59 1.59M15.69 15.69l1.59 1.59M12 4.5v2.25M12 17.25v2.25M17.28 6.72l-1.59 1.59M8.31 15.69l-1.59 1.59'],
    ];
@endphp

<aside class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-rose-100 bg-white/95 shadow-2xl shadow-rose-100/70 backdrop-blur lg:translate-x-0"
    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': ! sidebarOpen }">
    <div class="flex h-20 items-center gap-3 border-b border-rose-100 px-6">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-900 text-lg font-semibold text-white shadow-lg shadow-rose-900/20">
            Sk
        </div>
        <div>
            <p class="text-base font-semibold text-stone-950">S-kala Admin</p>
            <p class="text-xs font-medium uppercase tracking-[0.18em] text-rose-700">Dhampur</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
        @foreach ($navigation as $item)
            @can($item['permission'])
                @php
                    $activePattern = $item['active'] ?? $item['route'];
                    $isActive = $activePattern ? request()->routeIs($activePattern) : false;
                    $href = $item['route'] ? route($item['route']) : '#';
                @endphp

                <a href="{{ $href }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $isActive ? 'bg-rose-900 text-white shadow-lg shadow-rose-900/15' : 'text-stone-600 hover:bg-rose-50 hover:text-rose-900' }}">
                    <svg class="h-5 w-5 shrink-0 {{ $isActive ? 'text-rose-100' : 'text-rose-700/70 group-hover:text-rose-900' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="{{ $item['icon'] }}" />
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endcan
        @endforeach
    </nav>

    <div class="border-t border-rose-100 p-4">
        <div class="rounded-2xl bg-[#fbf7f0] p-4">
            <p class="text-sm font-semibold text-stone-950">Skill, Strength &amp; Self-Reliance</p>
            <p class="mt-1 text-xs leading-5 text-stone-500">A focused workspace for training, dignity, and livelihood impact.</p>
        </div>
    </div>
</aside>
