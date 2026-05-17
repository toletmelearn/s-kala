<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.trainers.form', [
        'action' => route('admin.trainers.store'),
        'method' => 'POST',
        'submitLabel' => 'Create Trainer',
    ])
</x-admin-layout>
