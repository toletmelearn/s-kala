<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.gallery-categories.form', [
        'action' => route('admin.gallery-categories.update', $category),
        'method' => 'PUT',
        'submitLabel' => 'Update Category',
    ])
</x-admin-layout>
