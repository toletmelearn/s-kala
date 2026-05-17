<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="title" class="mb-1.5 block text-sm font-semibold text-stone-700">Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $report->title) }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>
    <div>
        <label for="report_period" class="mb-1.5 block text-sm font-semibold text-stone-700">Report Period</label>
        <input id="report_period" name="report_period" type="text" value="{{ old('report_period', $report->report_period) }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>
    <div>
        <label for="sort_order" class="mb-1.5 block text-sm font-semibold text-stone-700">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $report->sort_order ?? 0) }}" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>
    <div class="md:col-span-2">
        <label for="summary" class="mb-1.5 block text-sm font-semibold text-stone-700">Summary</label>
        <textarea id="summary" name="summary" rows="4" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">{{ old('summary', $report->summary) }}</textarea>
    </div>
    <div>
        <label for="highlights" class="mb-1.5 block text-sm font-semibold text-stone-700">Highlights</label>
        <textarea id="highlights" name="highlights" rows="4" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">{{ old('highlights', $report->highlights) }}</textarea>
    </div>
    <div>
        <label for="challenges" class="mb-1.5 block text-sm font-semibold text-stone-700">Challenges</label>
        <textarea id="challenges" name="challenges" rows="4" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">{{ old('challenges', $report->challenges) }}</textarea>
    </div>
    <div class="md:col-span-2">
        <label for="future_plan" class="mb-1.5 block text-sm font-semibold text-stone-700">Future Plan</label>
        <textarea id="future_plan" name="future_plan" rows="4" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">{{ old('future_plan', $report->future_plan) }}</textarea>
    </div>
    <div>
        <label for="report_file" class="mb-1.5 block text-sm font-semibold text-stone-700">Report PDF</label>
        <input id="report_file" name="report_file" type="file" accept="application/pdf" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>
    <div>
        <label for="cover_image" class="mb-1.5 block text-sm font-semibold text-stone-700">Cover Image</label>
        <input id="cover_image" name="cover_image" type="file" accept="image/*" class="w-full rounded-xl border border-rose-100 px-4 py-3 text-sm">
    </div>
    <div class="flex items-center gap-3">
        <input id="is_featured" name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $report->is_featured)) class="h-4 w-4 rounded border-rose-200 text-rose-900">
        <label for="is_featured" class="text-sm font-semibold text-stone-700">Featured</label>
    </div>
    <div class="flex items-center gap-3">
        <input id="is_published" name="is_published" type="checkbox" value="1" @checked(old('is_published', $report->is_published)) class="h-4 w-4 rounded border-rose-200 text-rose-900">
        <label for="is_published" class="text-sm font-semibold text-stone-700">Published</label>
    </div>
</div>
