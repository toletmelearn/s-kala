<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\TrainingProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrainingModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainerRecords = [
            ['name' => 'Tailoring Trainer', 'specialization' => 'Tailoring'],
            ['name' => 'Embroidery Trainer', 'specialization' => 'Embroidery'],
            ['name' => 'Craft Trainer', 'specialization' => 'Craft'],
            ['name' => 'Livelihood Skills Trainer', 'specialization' => 'Future Livelihood Skills'],
        ];

        $trainers = collect();

        foreach ($trainerRecords as $index => $trainer) {
            $trainers->put($trainer['specialization'], Trainer::query()->updateOrCreate(
                ['name' => $trainer['name']],
                [
                    'designation' => 'S-kala Trainer',
                    'specialization' => $trainer['specialization'],
                    'bio' => 'Supports practical skill development through patient guidance, structured practice, and confidence-building learning.',
                    'is_active' => true,
                    'sort_order' => ($index + 1) * 10,
                ],
            ));
        }

        $programRecords = [
            [
                'name' => 'Tailoring',
                'short_description' => 'Practical stitching skills for confidence, utility, and livelihood readiness.',
                'category' => 'Skill Development',
                'duration' => 'Foundation program',
                'level' => 'Beginner friendly',
                'outcome' => 'Learners build garment-making confidence and practical stitching discipline.',
                'trainer' => 'Tailoring',
            ],
            [
                'name' => 'Embroidery',
                'short_description' => 'Fine handwork that strengthens craft quality and product value.',
                'category' => 'Handmade Skills',
                'duration' => 'Foundation program',
                'level' => 'Beginner friendly',
                'outcome' => 'Learners develop decorative handwork skills for product finishing and value addition.',
                'trainer' => 'Embroidery',
            ],
            [
                'name' => 'Craft',
                'short_description' => 'Creative handmade skills for useful, presentable community products.',
                'category' => 'Creative Skills',
                'duration' => 'Foundation program',
                'level' => 'Beginner friendly',
                'outcome' => 'Learners gain confidence in creating handmade items with presentation value.',
                'trainer' => 'Craft',
            ],
            [
                'name' => 'Future Livelihood Skills',
                'short_description' => 'New livelihood-focused programs can be added as the centre grows.',
                'category' => 'Livelihood Readiness',
                'duration' => 'Upcoming',
                'level' => 'Future program',
                'outcome' => 'The centre can introduce future skills aligned with opportunity, demand, and learner readiness.',
                'trainer' => 'Future Livelihood Skills',
            ],
        ];

        foreach ($programRecords as $index => $programRecord) {
            $program = TrainingProgram::query()->updateOrCreate(
                ['slug' => Str::slug($programRecord['name'])],
                [
                    'name' => $programRecord['name'],
                    'short_description' => $programRecord['short_description'],
                    'description' => $programRecord['short_description'].' This program is part of S-kala’s skill-to-confidence-to-livelihood journey.',
                    'category' => $programRecord['category'],
                    'duration' => $programRecord['duration'],
                    'level' => $programRecord['level'],
                    'outcome' => $programRecord['outcome'],
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => ($index + 1) * 10,
                ],
            );

            $program->trainers()->syncWithoutDetaching([
                $trainers->get($programRecord['trainer'])->id,
            ]);
        }
    }
}
