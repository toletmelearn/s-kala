<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.website.counters.form', [
        'action' => route('admin.website.counters.update', $counter),
        'method' => 'PUT',
        'submitLabel' => 'Update Counter',
    ])
</x-admin-layout>
