<?php

namespace Database\Seeders;

use App\Models\CsrReport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CsrReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $title = 'S-kala Women Empowerment Impact Overview';

        CsrReport::query()->updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'title' => $title,
                'report_period' => '2025-2026',
                'summary' => 'A premium CSR impact overview documenting training, confidence-building, product visibility, and community education support.',
                'highlights' => 'Training participation growth, increased documentation readiness, and stronger visibility of women-made outputs.',
                'challenges' => 'Scaling programs while maintaining individualized support and consistent documentation quality.',
                'future_plan' => 'Expand structured livelihood pathways, strengthen report publication cadence, and deepen collaboration support.',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'sort_order' => 10,
            ],
        );
    }
}
