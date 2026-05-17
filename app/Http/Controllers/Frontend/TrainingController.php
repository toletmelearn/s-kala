<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\TrainingProgram;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class TrainingController extends Controller
{
    /**
     * Display public training programs.
     */
    public function programs(): View
    {
        return view('frontend.training.index', [
            'settings' => $this->websiteSettings(),
            'programs' => $this->trainingPrograms(),
        ]);
    }

    /**
     * Display public trainers.
     */
    public function trainers(): View
    {
        return view('frontend.training.trainers', [
            'settings' => $this->websiteSettings(),
            'trainers' => $this->trainersList(),
        ]);
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }

    private function trainingPrograms()
    {
        if (! Schema::hasTable('training_programs')) {
            return collect();
        }

        return TrainingProgram::query()
            ->with(['trainers' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    private function trainersList()
    {
        if (! Schema::hasTable('trainers')) {
            return collect();
        }

        return Trainer::query()
            ->with(['trainingPrograms' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
