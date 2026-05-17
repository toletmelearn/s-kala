<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\ImpactCounterRequest;
use App\Models\ImpactCounter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ImpactCounterController extends Controller
{
    /**
     * Display impact counters.
     */
    public function index(): View
    {
        return view('admin.website.counters.index', [
            'pageTitle' => 'Impact Counters',
            'breadcrumb' => 'Website CMS / Impact Counters',
            'counters' => ImpactCounter::query()->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Show the counter creation form.
     */
    public function create(): View
    {
        return view('admin.website.counters.create', [
            'pageTitle' => 'Create Impact Counter',
            'breadcrumb' => 'Website CMS / Impact Counters / Create',
            'counter' => new ImpactCounter(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    /**
     * Store a new impact counter.
     */
    public function store(ImpactCounterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        ImpactCounter::query()->create($data);

        return redirect()
            ->route('admin.website.counters.index')
            ->with('status', 'Impact counter created.');
    }

    /**
     * Show the counter edit form.
     */
    public function edit(ImpactCounter $impactCounter): View
    {
        return view('admin.website.counters.edit', [
            'pageTitle' => 'Edit Impact Counter',
            'breadcrumb' => 'Website CMS / Impact Counters / Edit',
            'counter' => $impactCounter,
        ]);
    }

    /**
     * Update an impact counter.
     */
    public function update(ImpactCounterRequest $request, ImpactCounter $impactCounter): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $impactCounter->update($data);

        return redirect()
            ->route('admin.website.counters.index')
            ->with('status', 'Impact counter updated.');
    }

    /**
     * Delete an impact counter.
     */
    public function destroy(ImpactCounter $impactCounter): RedirectResponse
    {
        $impactCounter->delete();

        return redirect()
            ->route('admin.website.counters.index')
            ->with('status', 'Impact counter deleted.');
    }
}
