<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.gallery.form', [
        'action' => route('admin.gallery.update', $item),
        'method' => 'PUT',
        'submitLabel' => 'Update Gallery Item',
    ])
</x-admin-layout>
