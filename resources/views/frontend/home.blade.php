@extends('layouts.frontend', [
    'title' => $settings?->site_name ?? 'S-kala – Shakuntala Shishu Lok',
    'settings' => $settings,
])

@section('content')
    @php
        $heroTitle = $hero?->title ?? 'A livelihood-centered ecosystem for women.';
        $heroSubtitle = $hero?->subtitle ?? 'Training, enterprise readiness, and community confidence.';
        $heroContent = $hero?->content ?? 'S-kala supports women with practical skill-building, mentorship, product visibility, and transparent CSR impact documentation.';
        $heroImageExists = $hero?->image && file_exists(public_path($hero->image));
        $transformationImageExists = $transformation?->image && file_exists(public_path($transformation->image));
        $heroButtonText = $hero?->button_text ?: 'Explore Our Vision';
        $heroButtonUrl = $hero?->button_url ?: '#vision';
        $fallbackTrainingPrograms = [
            ['title' => 'Tailoring', 'text' => 'Practical stitching skills for confidence, utility, and livelihood readiness.'],
            ['title' => 'Embroidery', 'text' => 'Fine handwork that strengthens craft quality and product value.'],
            ['title' => 'Craft', 'text' => 'Creative handmade skills for useful, presentable community products.'],
            ['title' => 'Future Livelihood Skills', 'text' => 'New programs can be added as the centre grows.'],
        ];
        $directorCards = [
            'CSR Impact Documentation',
            'Women Empowerment Journey',
            'Skill-to-Livelihood Tracking',
            'Product Visibility',
            'Future Certificate System',
        ];
    @endphp

    <section id="home" class="relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-40 bg-white"></div>
        <div class="relative mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:py-20">
            <div class="flex flex-col justify-center">
                <div class="inline-flex w-fit items-center gap-2 rounded-full border border-amber-100 bg-white px-4 py-2 text-sm font-semibold text-amber-900 shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    Inaugurated on 14 May 2025
                </div>

                <h1 class="mt-6 max-w-4xl text-4xl font-bold tracking-normal text-stone-950 sm:text-5xl lg:text-6xl">
                    {{ $heroTitle }}
                </h1>
                <p class="mt-5 text-xl font-semibold leading-8 text-rose-900">
                    {{ $heroSubtitle }}
                </p>
                <p class="mt-5 max-w-2xl text-base leading-8 text-stone-600">
                    {{ $heroContent }}
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="#contact" class="inline-flex items-center justify-center rounded-full bg-rose-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 transition hover:bg-rose-800">
                        Join as Trainee
                    </a>
                    <a href="{{ $heroButtonUrl }}" class="inline-flex items-center justify-center rounded-full border border-rose-200 bg-white px-6 py-3 text-sm font-semibold text-rose-900 shadow-sm transition hover:bg-rose-50">
                        {{ $heroButtonText }}
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-5 top-10 h-32 w-32 rounded-full bg-rose-100 blur-3xl"></div>
                <div class="relative overflow-hidden rounded-[2rem] border border-rose-100 bg-white p-3 shadow-2xl shadow-rose-100/70">
                    @if ($heroImageExists)
                        <img src="{{ asset($hero->image) }}" alt="{{ $heroTitle }}" class="h-[34rem] w-full rounded-[1.5rem] object-cover">
                    @else
                        <div class="flex h-[34rem] flex-col justify-between rounded-[1.5rem] bg-gradient-to-br from-rose-50 via-white to-amber-50 p-8">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-3xl bg-white p-5 shadow-lg shadow-rose-100/60">
                                    <p class="text-sm font-semibold text-rose-900">Tailoring</p>
                                    <div class="mt-8 h-2 rounded-full bg-rose-200"></div>
                                    <div class="mt-3 h-2 w-2/3 rounded-full bg-amber-200"></div>
                                </div>
                                <div class="mt-10 rounded-3xl bg-stone-950 p-5 text-white shadow-lg shadow-stone-200/60">
                                    <p class="text-sm font-semibold">Craft</p>
                                    <div class="mt-8 h-2 rounded-full bg-white/30"></div>
                                    <div class="mt-3 h-2 w-2/3 rounded-full bg-amber-200"></div>
                                </div>
                            </div>
                            <div class="rounded-3xl border border-rose-100 bg-white/80 p-6 backdrop-blur">
                                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Women-led workspace</p>
                                <p class="mt-3 text-3xl font-bold text-stone-950">Skill to confidence. Confidence to livelihood.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section id="impact" class="bg-white py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Impact</p>
                    <h2 class="mt-2 text-3xl font-bold text-stone-950">Visible progress, ready for presentation.</h2>
                </div>
                <p class="max-w-xl text-sm leading-6 text-stone-600">These counters are managed from the Website CMS and can grow with verified centre records.</p>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($impactCounters as $counter)
                    <article class="rounded-3xl border border-rose-100 bg-[#fffdf9] p-6 shadow-xl shadow-rose-100/40">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-sm font-bold text-rose-900">{{ $counter->icon ?: 'Sk' }}</div>
                        <p class="mt-6 text-4xl font-bold text-stone-950">{{ $counter->value }}{{ $counter->suffix }}</p>
                        <h3 class="mt-2 text-base font-semibold text-stone-800">{{ $counter->label }}</h3>
                        @if ($counter->description)
                            <p class="mt-3 text-sm leading-6 text-stone-500">{{ $counter->description }}</p>
                        @endif
                    </article>
                @empty
                    @foreach (['Women Trained', 'Women Earning After Training', 'Certificates Issued', 'Women-made Products Created'] as $label)
                        <article class="rounded-3xl border border-rose-100 bg-[#fffdf9] p-6 shadow-xl shadow-rose-100/40">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-sm font-bold text-rose-900">Sk</div>
                            <p class="mt-6 text-4xl font-bold text-stone-950">0+</p>
                            <h3 class="mt-2 text-base font-semibold text-stone-800">{{ $label }}</h3>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section id="about" class="py-16">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <div class="rounded-[2rem] border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/50">
                @if ($transformationImageExists)
                    <img src="{{ asset($transformation->image) }}" alt="{{ $transformation->title ?? 'S-kala transformation' }}" class="h-80 w-full rounded-3xl object-cover">
                @else
                    <div class="grid h-80 gap-4 rounded-3xl bg-[#fbf7f0] p-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-stone-200 bg-stone-100 p-5">
                            <p class="text-sm font-semibold text-stone-500">Earlier</p>
                            <p class="mt-16 text-xl font-bold text-stone-800">Old, unused building condition</p>
                        </div>
                        <div class="rounded-3xl border border-rose-100 bg-white p-5">
                            <p class="text-sm font-semibold text-rose-700">Now</p>
                            <p class="mt-16 text-xl font-bold text-stone-950">Modern skill and learning centre</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex flex-col justify-center">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Transformation</p>
                <h2 class="mt-3 text-3xl font-bold leading-tight text-stone-950">
                    {{ $transformation?->title ?? 'From an old orphanage building to a modern empowerment workspace.' }}
                </h2>
                <p class="mt-5 text-base leading-8 text-stone-600">
                    {{ $transformation?->content ?? 'S-kala has transformed a once old and neglected institutional space into a hopeful centre for skill development, women empowerment, handmade product visibility, CSR impact, and evening tuition support.' }}
                </p>
                <div class="mt-7 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-stone-200 bg-white p-5">
                        <p class="text-sm font-semibold text-stone-500">Earlier</p>
                        <p class="mt-3 text-lg font-bold text-stone-950">Old, dilapidated condition</p>
                    </div>
                    <div class="rounded-3xl border border-rose-100 bg-white p-5">
                        <p class="text-sm font-semibold text-rose-700">Now</p>
                        <p class="mt-3 text-lg font-bold text-stone-950">Renovated skill and learning centre</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="vision" class="bg-white py-16">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-[1fr_1fr] lg:px-8">
            <article class="rounded-[2rem] border border-rose-100 bg-[#fffdf9] p-8 shadow-xl shadow-rose-100/40">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Vision</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-950">{{ $vision?->title ?? 'Transforming skills into dignity, confidence, and livelihood.' }}</h2>
                <p class="mt-5 text-base leading-8 text-stone-600">{{ $vision?->content ?? 'The S-kala vision is to help women move from learning to confidence through tailoring, embroidery, craft, and future livelihood programs.' }}</p>
                <p class="mt-6 text-sm font-semibold text-stone-950">Vision of Mrs. Pranjali Goyal</p>
            </article>

            <article class="rounded-[2rem] border border-amber-100 bg-gradient-to-br from-white to-amber-50 p-8 shadow-xl shadow-amber-100/40">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-800">Leadership</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-950">{{ $leadership?->title ?? 'Vision, direction, and daily guidance.' }}</h2>
                <p class="mt-5 text-base leading-8 text-stone-600">{{ $leadership?->content ?? 'S-kala is guided by the vision of Mrs. Pranjali Goyal, direction of Mrs. Rashmi Rekha, and incharge Ms. Neetu Singh.' }}</p>
                <div class="mt-6 grid gap-3">
                    <div class="rounded-2xl bg-white p-4 text-sm font-semibold text-stone-800">Direction of Mrs. Rashmi Rekha</div>
                    <div class="rounded-2xl bg-white p-4 text-sm font-semibold text-stone-800">Incharge Ms. Neetu Singh</div>
                </div>
            </article>
        </div>
    </section>

    <section id="training" class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Training Programs</p>
                <h2 class="mt-3 text-3xl font-bold text-stone-950">Practical skills for confidence and livelihood readiness.</h2>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($featuredPrograms as $program)
                    <a href="{{ route('training.index') }}" class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40 transition hover:-translate-y-0.5 hover:border-rose-200">
                        <h3 class="text-lg font-bold text-stone-950">{{ $program->name }}</h3>
                        <p class="mt-3 text-sm leading-6 text-stone-600">{{ $program->short_description ?: Str::limit($program->description, 120) }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($program->trainers as $trainer)
                                <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-900">{{ $trainer->name }}</span>
                            @endforeach
                        </div>
                    </a>
                @empty
                    @foreach ($fallbackTrainingPrograms as $program)
                        <article class="rounded-3xl border border-rose-100 bg-white p-6 shadow-xl shadow-rose-100/40">
                            <h3 class="text-lg font-bold text-stone-950">{{ $program['title'] }}</h3>
                            <p class="mt-3 text-sm leading-6 text-stone-600">{{ $program['text'] }}</p>
                        </article>
                    @endforeach
                @endforelse
            </div>
            <a href="{{ route('training.index') }}" class="mt-6 inline-flex rounded-full bg-rose-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 hover:bg-rose-800">
                View Training Programs
            </a>
        </div>
    </section>

    <section id="products" class="bg-white py-16">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <div class="rounded-[2rem] bg-stone-950 p-8 text-white shadow-xl shadow-stone-300/40">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-200">Made at S-kala</p>
                <h2 class="mt-3 text-3xl font-bold">Product visibility for women-made work.</h2>
                <p class="mt-5 text-base leading-8 text-stone-300">Future product showcase will display women-made products and help create visibility for handmade work shaped inside S-kala.</p>
            </div>
            <div id="gallery" class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl border border-rose-100 bg-rose-50 p-6">
                    <p class="text-sm font-semibold text-rose-900">Handmade</p>
                    <p class="mt-16 text-xl font-bold text-stone-950">Craft</p>
                </div>
                <div class="rounded-3xl border border-amber-100 bg-amber-50 p-6">
                    <p class="text-sm font-semibold text-amber-900">Skill</p>
                    <p class="mt-16 text-xl font-bold text-stone-950">Embroidery</p>
                </div>
                <div class="rounded-3xl border border-stone-200 bg-[#fbf7f0] p-6">
                    <p class="text-sm font-semibold text-stone-600">Enterprise</p>
                    <p class="mt-16 text-xl font-bold text-stone-950">Visibility</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] border border-rose-100 bg-white p-8 shadow-xl shadow-rose-100/50 lg:p-10">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Education Support</p>
                <h2 class="mt-3 max-w-4xl text-3xl font-bold text-stone-950">S-kala also supports students through quality evening tuition and learning support.</h2>
                <p class="mt-5 max-w-3xl text-base leading-8 text-stone-600">The centre is designed as a community support space where learning, confidence, and structured guidance can continue beyond daytime skill programs.</p>
            </div>
        </div>
    </section>

    <section class="bg-stone-950 py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-200">Director Presentation</p>
                <h2 class="mt-3 text-4xl font-bold">S-kala Digital Vision</h2>
                <p class="mt-5 text-base leading-8 text-stone-300">A presentation-ready digital foundation for documenting empowerment, progress, visibility, and future certification systems.</p>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                @foreach ($directorCards as $card)
                    <article class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <span class="block h-2 w-10 rounded-full bg-amber-200"></span>
                        <h3 class="mt-5 text-base font-bold text-white">{{ $card }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-rose-700">Join The Journey</p>
            <h2 class="mt-3 text-3xl font-bold leading-tight text-stone-950 sm:text-4xl">
                Be a part of a platform where skills become confidence and confidence becomes livelihood.
            </h2>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="#contact" class="inline-flex items-center justify-center rounded-full bg-rose-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 transition hover:bg-rose-800">
                    Join Training
                </a>
                <a href="#contact" class="inline-flex items-center justify-center rounded-full border border-rose-200 bg-white px-6 py-3 text-sm font-semibold text-rose-900 shadow-sm transition hover:bg-rose-50">
                    Contact S-kala
                </a>
            </div>
        </div>
    </section>
@endsection
