<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.product-categories.form', [
        'action' => route('admin.product-categories.update', $category),
        'method' => 'PUT',
        'submitLabel' => 'Update Category',
    ])
</x-admin-layout>
