<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.website.counters.form', [
        'action' => route('admin.website.counters.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Counter',
    ])
</x-admin-layout>
