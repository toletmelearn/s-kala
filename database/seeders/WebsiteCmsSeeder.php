<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use App\Models\ImpactCounter;
use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteCmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebsiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'S-kala – Shakuntala Shishu Lok',
                'tagline' => 'Skill, Strength & Self-Reliance',
                'email' => 'info@skala.test',
                'phone' => '+91 00000 00000',
                'address' => 'Dhampur, Uttar Pradesh',
                'footer_text' => 'S-kala – Shakuntala Shishu Lok | Skill, Strength & Self-Reliance',
            ],
        );

        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'A livelihood-centered ecosystem for women.',
                'subtitle' => 'Training, enterprise readiness, and community confidence.',
                'content' => 'S-kala supports women with practical skill-building, mentorship, product visibility, and transparent CSR impact documentation.',
                'button_text' => 'Explore S-kala',
                'button_url' => '#',
                'sort_order' => 10,
            ],
            [
                'section_key' => 'vision',
                'title' => 'Transforming skills into dignity, confidence, and livelihood.',
                'subtitle' => 'A women empowerment workspace shaped by care, craft, and opportunity.',
                'content' => 'The S-kala vision is to help women move from learning to confidence through tailoring, embroidery, craft, and future livelihood programs.',
                'sort_order' => 20,
            ],
            [
                'section_key' => 'leadership',
                'title' => 'Vision, direction, and daily guidance.',
                'subtitle' => 'Mrs. Pranjali Goyal, Mrs. Rashmi Rekha, and Ms. Neetu Singh.',
                'content' => 'S-kala is guided by the vision of Mrs. Pranjali Goyal, direction of Mrs. Rashmi Rekha, and incharge Ms. Neetu Singh.',
                'sort_order' => 30,
            ],
        ];

        foreach ($sections as $section) {
            HomepageSection::query()->updateOrCreate(
                ['section_key' => $section['section_key']],
                array_merge(['is_active' => true], $section),
            );
        }

        $counters = [
            ['label' => 'Women Trained', 'value' => '0', 'suffix' => '+', 'icon' => 'WT', 'sort_order' => 10],
            ['label' => 'Women Earning After Training', 'value' => '0', 'suffix' => '+', 'icon' => 'WE', 'sort_order' => 20],
            ['label' => 'Certificates Issued', 'value' => '0', 'suffix' => '+', 'icon' => 'CI', 'sort_order' => 30],
            ['label' => 'Women-made Products Created', 'value' => '0', 'suffix' => '+', 'icon' => 'WP', 'sort_order' => 40],
        ];

        foreach ($counters as $counter) {
            ImpactCounter::query()->updateOrCreate(
                ['label' => $counter['label']],
                array_merge(['is_active' => true], $counter),
            );
        }
    }
}
