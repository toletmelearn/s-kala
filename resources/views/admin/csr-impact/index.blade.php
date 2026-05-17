<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @php
        $summary = [
            ['label' => 'Women Trained', 'value' => $stats['trainees_total']],
            ['label' => 'Women Enrolled', 'value' => $stats['trainees_enrolled']],
            ['label' => 'Certificates Issued', 'value' => $stats['certificates_issued']],
            ['label' => 'Products Showcased', 'value' => $stats['products_total']],
            ['label' => 'Events Documented', 'value' => $stats['events_total']],
            ['label' => 'Enquiries Received', 'value' => $stats['contact_enquiries_total'] + $stats['product_enquiries_total']],
        ];
    @endphp

    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
            @foreach ($summary as $item)
                <article class="rounded-2xl border border-rose-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-stone-500">{{ $item['label'] }}</p>
                    <p class="mt-3 text-3xl font-semibold text-stone-950">{{ $item['value'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <article class="rounded-3xl border border-rose-100 bg-white p-6">
                <h3 class="text-lg font-semibold text-stone-950">Trainee Statistics</h3>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <p>Total: <strong>{{ $stats['trainees_total'] }}</strong></p>
                    <p>Pending: <strong>{{ $stats['trainees_pending'] }}</strong></p>
                    <p>Enrolled: <strong>{{ $stats['trainees_enrolled'] }}</strong></p>
                    <p>Completed: <strong>{{ $stats['trainees_completed'] }}</strong></p>
                    <p>Rejected: <strong>{{ $stats['trainees_rejected'] }}</strong></p>
                </div>
            </article>
            <article class="rounded-3xl border border-rose-100 bg-white p-6">
                <h3 class="text-lg font-semibold text-stone-950">Training Statistics</h3>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <p>Active Programs: <strong>{{ $stats['programs_active'] }}</strong></p>
                    <p>Featured Programs: <strong>{{ $stats['programs_featured'] }}</strong></p>
                </div>
                <div class="mt-5 space-y-2">
                    @forelse ($programWiseTrainees as $program)
                        <div class="flex items-center justify-between rounded-xl bg-rose-50 px-3 py-2 text-sm">
                            <span>{{ $program->name }}</span>
                            <strong>{{ $program->trainees_count }}</strong>
                        </div>
                    @empty
                        <p class="text-sm text-stone-500">No program data available.</p>
                    @endforelse
                </div>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-3xl border border-rose-100 bg-white p-6">
                <h3 class="text-lg font-semibold text-stone-950">Certificates</h3>
                <p class="mt-3 text-sm">Total: <strong>{{ $stats['certificates_total'] }}</strong></p>
                <p class="text-sm">Issued: <strong>{{ $stats['certificates_issued'] }}</strong></p>
                <p class="text-sm">Draft: <strong>{{ $stats['certificates_draft'] }}</strong></p>
                <p class="text-sm">Revoked: <strong>{{ $stats['certificates_revoked'] }}</strong></p>
            </article>
            <article class="rounded-3xl border border-rose-100 bg-white p-6">
                <h3 class="text-lg font-semibold text-stone-950">Products</h3>
                <p class="mt-3 text-sm">Total: <strong>{{ $stats['products_total'] }}</strong></p>
                <p class="text-sm">Featured: <strong>{{ $stats['products_featured'] }}</strong></p>
                <p class="text-sm">Enquiries: <strong>{{ $stats['product_enquiries_total'] }}</strong></p>
                <p class="text-sm">New Enquiries: <strong>{{ $stats['product_enquiries_new'] }}</strong></p>
            </article>
            <article class="rounded-3xl border border-rose-100 bg-white p-6">
                <h3 class="text-lg font-semibold text-stone-950">Contact Enquiries</h3>
                <p class="mt-3 text-sm">Total: <strong>{{ $stats['contact_enquiries_total'] }}</strong></p>
                <p class="text-sm">CSR Partnerships: <strong>{{ $stats['contact_enquiries_csr'] }}</strong></p>
                <p class="text-sm">Volunteer: <strong>{{ $stats['contact_enquiries_volunteer'] }}</strong></p>
                <p class="text-sm">Visit Requests: <strong>{{ $stats['contact_enquiries_visit'] }}</strong></p>
                <p class="text-sm">New: <strong>{{ $stats['contact_enquiries_new'] }}</strong></p>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_1fr]">
            <article class="rounded-3xl border border-rose-100 bg-white p-6">
                <h3 class="text-lg font-semibold text-stone-950">Gallery & Events</h3>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <p>Gallery Items: <strong>{{ $stats['gallery_total'] }}</strong></p>
                    <p>Featured Gallery: <strong>{{ $stats['gallery_featured'] }}</strong></p>
                    <p>Total Events: <strong>{{ $stats['events_total'] }}</strong></p>
                    <p>Completed Events: <strong>{{ $stats['events_completed'] }}</strong></p>
                    <p>Upcoming Events: <strong>{{ $stats['events_upcoming'] }}</strong></p>
                </div>
            </article>

            <article class="rounded-3xl border border-stone-200 bg-stone-950 p-6 text-white">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-200">S-kala Impact Snapshot</p>
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach (['Skill Development', 'Women Empowerment', 'Product Visibility', 'Certification', 'CSR Documentation', 'Community Education Support'] as $item)
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium">{{ $item }}</div>
                    @endforeach
                </div>
            </article>
        </section>
    </div>
</x-admin-layout>
