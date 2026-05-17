<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductShowcaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Tailoring', 'description' => 'Stitched utility and garment-focused showcase items.'],
            ['name' => 'Embroidery', 'description' => 'Hand embroidery products crafted with detail and care.'],
            ['name' => 'Craft', 'description' => 'Creative handmade products developed through craft training.'],
            ['name' => 'Handmade Accessories', 'description' => 'Useful accessories made through women-led production practice.'],
            ['name' => 'Learning Material', 'description' => 'Skill-learning support kits and stitched learning aids.'],
        ];

        $categoryMap = [];

        foreach ($categories as $index => $category) {
            $record = ProductCategory::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'sort_order' => ($index + 1) * 10,
                    'is_active' => true,
                ],
            );

            $categoryMap[$category['name']] = $record->id;
        }

        $products = [
            [
                'name' => 'Embroidered Cloth Bag',
                'category' => 'Embroidery',
                'short_description' => 'A reusable embroidered cloth bag made through structured handwork training.',
                'description' => 'This product represents precision handwork, practical utility, and confidence-building outcomes from S-kala embroidery sessions.',
                'material' => 'Cotton fabric',
                'size' => 'Medium',
                'color' => 'Multi-color threadwork',
                'price' => null,
                'skill_used' => 'Embroidery',
                'is_featured' => true,
            ],
            [
                'name' => 'Handmade Decorative Craft',
                'category' => 'Craft',
                'short_description' => 'A decorative handmade craft developed through creative skill practice.',
                'description' => 'A display-ready craft item showcasing design confidence, finishing discipline, and product presentation value.',
                'material' => 'Mixed craft material',
                'size' => 'Standard',
                'color' => 'Natural and warm tones',
                'price' => null,
                'skill_used' => 'Craft',
                'is_featured' => true,
            ],
            [
                'name' => 'Stitched Utility Pouch',
                'category' => 'Tailoring',
                'short_description' => 'A stitched pouch built in tailoring practice with focus on utility and quality.',
                'description' => 'An everyday-use stitched pouch reflecting measurement accuracy, stitching control, and practical design learning.',
                'material' => 'Fabric',
                'size' => 'Small',
                'color' => 'Assorted',
                'price' => null,
                'skill_used' => 'Tailoring',
                'is_featured' => true,
            ],
            [
                'name' => 'Fabric Learning Kit',
                'category' => 'Learning Material',
                'short_description' => 'A stitched kit prepared for practice sessions and learner support.',
                'description' => 'A practical learning kit used to strengthen repetition, consistency, and confidence during early skill-building stages.',
                'material' => 'Fabric and support components',
                'size' => 'Training set',
                'color' => 'Assorted',
                'price' => null,
                'skill_used' => 'Tailoring and Livelihood Readiness',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $index => $item) {
            Product::query()->updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'product_category_id' => $categoryMap[$item['category']] ?? null,
                    'name' => $item['name'],
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'material' => $item['material'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'price' => $item['price'],
                    'made_by' => 'S-kala trainees',
                    'skill_used' => $item['skill_used'],
                    'is_featured' => $item['is_featured'],
                    'is_active' => true,
                    'sort_order' => ($index + 1) * 10,
                ],
            );
        }
    }
}
