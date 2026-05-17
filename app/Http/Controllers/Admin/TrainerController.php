<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrainerRequest;
use App\Models\Trainer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TrainerController extends Controller
{
    /**
     * Display trainers.
     */
    public function index(): View
    {
        return view('admin.trainers.index', [
            'pageTitle' => 'Trainers',
            'breadcrumb' => 'Trainers',
            'trainers' => Trainer::query()
                ->with('trainingPrograms')
                ->orderBy('sort_order')
                ->paginate(12),
        ]);
    }

    /**
     * Show the creation form.
     */
    public function create(): View
    {
        return view('admin.trainers.create', [
            'pageTitle' => 'Create Trainer',
            'breadcrumb' => 'Trainers / Create',
            'trainer' => new Trainer([
                'is_active' => true,
                'sort_order' => 0,
            ]),
        ]);
    }

    /**
     * Store a trainer.
     */
    public function store(TrainerRequest $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storeUpload($request->file('photo'));
        }

        Trainer::query()->create($data);

        return redirect()
            ->route('admin.trainers.index')
            ->with('status', 'Trainer created.');
    }

    /**
     * Show the edit form.
     */
    public function edit(Trainer $trainer): View
    {
        return view('admin.trainers.edit', [
            'pageTitle' => 'Edit Trainer',
            'breadcrumb' => 'Trainers / Edit',
            'trainer' => $trainer->load('trainingPrograms'),
        ]);
    }

    /**
     * Update a trainer.
     */
    public function update(TrainerRequest $request, Trainer $trainer): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $this->deleteUpload($trainer->photo);
            $data['photo'] = $this->storeUpload($request->file('photo'));
        }

        $trainer->update($data);

        return redirect()
            ->route('admin.trainers.index')
            ->with('status', 'Trainer updated.');
    }

    /**
     * Delete a trainer.
     */
    public function destroy(Trainer $trainer): RedirectResponse
    {
        $this->deleteUpload($trainer->photo);
        $trainer->delete();

        return redirect()
            ->route('admin.trainers.index')
            ->with('status', 'Trainer deleted.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Trainer $trainer): RedirectResponse
    {
        $trainer->update(['is_active' => ! $trainer->is_active]);

        return back()->with('status', 'Trainer status updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(TrainerRequest $request): array
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function storeUpload($file): string
    {
        $directory = public_path('uploads/trainers');
        File::ensureDirectoryExists($directory);

        $filename = 'trainer-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/trainers/'.$filename;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/trainers/')) {
            File::delete(public_path($path));
        }
    }
}
