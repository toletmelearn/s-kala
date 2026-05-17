<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PublicContactEnquiryRequest;
use App\Models\ContactEnquiry;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('frontend.contact', [
            'settings' => $this->websiteSettings(),
            'enquiryTypes' => $this->enquiryTypes(),
        ]);
    }

    public function store(PublicContactEnquiryRequest $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('contact_enquiries'), 404);

        $data = $request->validated();
        $data['status'] = 'new';

        ContactEnquiry::query()->create($data);

        return back()->with('success', 'Thank you for contacting S-kala. Our team will respond soon.');
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }

    /**
     * @return array<string, string>
     */
    private function enquiryTypes(): array
    {
        return [
            'general' => 'General Enquiry',
            'csr_partner' => 'CSR Partnership',
            'volunteer' => 'Volunteer',
            'visit_request' => 'Visit Request',
            'collaboration' => 'Collaboration',
            'training_help' => 'Training Help',
            'other' => 'Other',
        ];
    }
}
