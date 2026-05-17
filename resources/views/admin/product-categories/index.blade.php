<x-admin-layout :page-title="$pageTitle" :breadcrumb="$breadcrumb">
    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="flex justify-end">
            <a href="{{ route('admin.product-categories.create') }}" class="inline-flex rounded-xl bg-rose-900 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-800">Add Category</a>
        </div>

        <section class="overflow-hidden rounded-3xl border border-rose-100 bg-white shadow-xl shadow-rose-100/40">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-rose-100">
                    <thead class="bg-[#fffdf9]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Slug</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Sort</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-100">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-4 py-3 text-sm font-semibold text-stone-800">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-sm text-stone-600">{{ $category->slug }}</td>
                                <td class="px-4 py-3 text-sm text-stone-600">{{ $category->sort_order }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $category->is_active ? 'bg-emerald-100 text-emerald-900' : 'bg-stone-100 text-stone-600' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.product-categories.edit', $category) }}" class="rounded-xl border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50">Edit</a>
                                        <form method="POST" action="{{ route('admin.product-categories.toggle-status', $category) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-xl border border-stone-200 px-3 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-50">Toggle</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.product-categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-sm text-stone-500">No categories found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{ $categories->links() }}
    </div>
</x-admin-layout>
