<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    @include('admin.trainers.form', [
        'action' => route('admin.trainers.update', $trainer),
        'method' => 'PUT',
        'submitLabel' => 'Update Trainer',
    ])
</x-admin-layout>
