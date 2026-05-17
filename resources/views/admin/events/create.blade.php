<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.events.form', [
        'action' => route('admin.events.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Event',
    ])
</x-admin-layout>
