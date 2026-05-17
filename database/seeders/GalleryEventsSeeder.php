<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GalleryEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Training', 'description' => 'Skill learning, practical sessions, and trainer-led activities.'],
            ['name' => 'Products', 'description' => 'Women-made product development and visibility moments.'],
            ['name' => 'Events', 'description' => 'Institutional events, workshops, and key gatherings.'],
            ['name' => 'Transformation', 'description' => 'Journey from old structure to empowerment workspace.'],
            ['name' => 'Evening Tuition', 'description' => 'Education support and evening learning initiatives.'],
        ];

        foreach ($categories as $index => $category) {
            GalleryCategory::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'sort_order' => ($index + 1) * 10,
                    'is_active' => true,
                ],
            );
        }

        $events = [
            [
                'title' => 'S-kala Inauguration',
                'short_description' => 'A new beginning for women empowerment and skill development in Dhampur.',
                'description' => 'The inauguration marked the formal beginning of S-kala as a women-focused skill and confidence development workspace.',
                'event_date' => '2025-05-14',
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Trainer Orientation Program',
                'short_description' => 'A focused preparation program to strengthen training quality.',
                'description' => 'Orientation support for trainers on program quality, learner guidance, and practical outcomes.',
                'event_date' => null,
                'status' => 'completed',
                'is_featured' => true,
            ],
            [
                'title' => 'Women Skill Workshop',
                'short_description' => 'Hands-on learning for tailoring, embroidery, craft, and confidence-building.',
                'description' => 'A practical workshop designed to reinforce skill confidence and community learning.',
                'event_date' => null,
                'status' => 'completed',
                'is_featured' => true,
            ],
        ];

        foreach ($events as $index => $event) {
            Event::query()->updateOrCreate(
                ['slug' => Str::slug($event['title'])],
                [
                    'title' => $event['title'],
                    'short_description' => $event['short_description'],
                    'description' => $event['description'],
                    'event_date' => $event['event_date'],
                    'status' => $event['status'],
                    'is_featured' => $event['is_featured'],
                    'is_active' => true,
                    'sort_order' => ($index + 1) * 10,
                ],
            );
        }
    }
}
