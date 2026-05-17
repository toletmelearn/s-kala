<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.gallery.form', [
        'action' => route('admin.gallery.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Gallery Item',
    ])
</x-admin-layout>
