@extends('layouts.frontend', [
    'title' => 'Thank You',
    'settings' => $settings,
])

@section('content')
    <section class="bg-white py-24">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <div class="mx-auto w-fit rounded-full border border-emerald-100 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-800">
                Application Submitted
            </div>
            <h1 class="mt-6 text-4xl font-bold text-stone-950 sm:text-5xl">Thank you for showing interest in S-kala.</h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-stone-600">
                Our team will contact you soon with the next steps for training and enrollment support.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-full bg-rose-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-rose-900/20 hover:bg-rose-800">
                    Back to Homepage
                </a>
                <a href="{{ route('training.index') }}" class="inline-flex items-center justify-center rounded-full border border-rose-200 bg-white px-6 py-3 text-sm font-semibold text-rose-900 shadow-sm hover:bg-rose-50">
                    View Training Programs
                </a>
            </div>
        </div>
    </section>
@endsection
