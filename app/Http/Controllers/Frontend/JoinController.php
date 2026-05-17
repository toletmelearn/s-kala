<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PublicTraineeApplicationRequest;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class JoinController extends Controller
{
    /**
     * Show the public trainee application form.
     */
    public function create(): View
    {
        $programs = collect();
        $selectedProgram = null;

        if (Schema::hasTable('training_programs')) {
            $programs = TrainingProgram::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            $selectedProgram = request('program')
                ? $programs->firstWhere('slug', request('program'))
                : null;
        }

        return view('frontend.join.create', [
            'settings' => $this->websiteSettings(),
            'programs' => $programs,
            'selectedProgramId' => old('preferred_program_id', $selectedProgram?->id),
        ]);
    }

    /**
     * Store a public trainee application.
     */
    public function store(PublicTraineeApplicationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storeUpload($request->file('photo'), 'photos', 'photo');
        }

        if ($request->hasFile('id_proof')) {
            $data['id_proof'] = $this->storeUpload($request->file('id_proof'), 'id-proofs', 'id-proof');
        }

        $data['status'] = 'pending';
        $data['source'] = 'public_join_form';

        Trainee::query()->create($data);

        return redirect()->route('join.thank-you');
    }

    /**
     * Show the thank-you page.
     */
    public function thankYou(): View
    {
        return view('frontend.join.thank-you', [
            'settings' => $this->websiteSettings(),
        ]);
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }

    private function storeUpload($file, string $folder, string $prefix): string
    {
        $directory = public_path("uploads/trainees/{$folder}");
        File::ensureDirectoryExists($directory);

        $filename = $prefix.'-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return "uploads/trainees/{$folder}/{$filename}";
    }
}
