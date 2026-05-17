<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.events.form', [
        'action' => route('admin.events.update', $event),
        'method' => 'PUT',
        'submitLabel' => 'Update Event',
    ])
</x-admin-layout>
