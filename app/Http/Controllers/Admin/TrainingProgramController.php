<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrainingProgramRequest;
use App\Models\Trainer;
use App\Models\TrainingProgram;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TrainingProgramController extends Controller
{
    /**
     * Display training programs.
     */
    public function index(): View
    {
        return view('admin.training-programs.index', [
            'pageTitle' => 'Training Programs',
            'breadcrumb' => 'Training Programs',
            'programs' => TrainingProgram::query()
                ->with('trainers')
                ->orderBy('sort_order')
                ->paginate(12),
        ]);
    }

    /**
     * Show the creation form.
     */
    public function create(): View
    {
        return view('admin.training-programs.create', [
            'pageTitle' => 'Create Training Program',
            'breadcrumb' => 'Training Programs / Create',
            'program' => new TrainingProgram([
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 0,
            ]),
            'trainers' => Trainer::query()->orderBy('sort_order')->get(),
            'selectedTrainers' => [],
        ]);
    }

    /**
     * Store a training program.
     */
    public function store(TrainingProgramRequest $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeUpload($request->file('image'));
        }

        $program = TrainingProgram::query()->create($data);
        $program->trainers()->sync($request->input('trainer_ids', []));

        return redirect()
            ->route('admin.training-programs.index')
            ->with('status', 'Training program created.');
    }

    /**
     * Show the edit form.
     */
    public function edit(TrainingProgram $trainingProgram): View
    {
        return view('admin.training-programs.edit', [
            'pageTitle' => 'Edit Training Program',
            'breadcrumb' => 'Training Programs / Edit',
            'program' => $trainingProgram->load('trainers'),
            'trainers' => Trainer::query()->orderBy('sort_order')->get(),
            'selectedTrainers' => $trainingProgram->trainers->pluck('id')->all(),
        ]);
    }

    /**
     * Update a training program.
     */
    public function update(TrainingProgramRequest $request, TrainingProgram $trainingProgram): RedirectResponse
    {
        $data = $this->validatedData($request, $trainingProgram);

        if ($request->hasFile('image')) {
            $this->deleteUpload($trainingProgram->image);
            $data['image'] = $this->storeUpload($request->file('image'));
        }

        $trainingProgram->update($data);
        $trainingProgram->trainers()->sync($request->input('trainer_ids', []));

        return redirect()
            ->route('admin.training-programs.index')
            ->with('status', 'Training program updated.');
    }

    /**
     * Delete a training program.
     */
    public function destroy(TrainingProgram $trainingProgram): RedirectResponse
    {
        $this->deleteUpload($trainingProgram->image);
        $trainingProgram->delete();

        return redirect()
            ->route('admin.training-programs.index')
            ->with('status', 'Training program deleted.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(TrainingProgram $trainingProgram): RedirectResponse
    {
        $trainingProgram->update(['is_active' => ! $trainingProgram->is_active]);

        return back()->with('status', 'Training program status updated.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(TrainingProgram $trainingProgram): RedirectResponse
    {
        $trainingProgram->update(['is_featured' => ! $trainingProgram->is_featured]);

        return back()->with('status', 'Training program featured status updated.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(TrainingProgramRequest $request, ?TrainingProgram $program = null): array
    {
        $data = $request->validated();
        unset($data['trainer_ids']);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $program);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function uniqueSlug(string $value, ?TrainingProgram $program = null): string
    {
        $slug = Str::slug($value);
        $baseSlug = $slug;
        $counter = 2;

        while (TrainingProgram::query()
            ->where('slug', $slug)
            ->when($program, fn ($query) => $query->whereKeyNot($program->id))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function storeUpload($file): string
    {
        $directory = public_path('uploads/programs');
        File::ensureDirectoryExists($directory);

        $filename = 'program-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/programs/'.$filename;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/programs/')) {
            File::delete(public_path($path));
        }
    }
}
