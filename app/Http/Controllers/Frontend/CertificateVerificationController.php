<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class CertificateVerificationController extends Controller
{
    public function show(string $verificationCode): View
    {
        abort_unless(Schema::hasTable('certificates'), 404);

        $certificate = Certificate::query()
            ->with(['trainee', 'trainingProgram'])
            ->where('verification_code', $verificationCode)
            ->first();

        return view('frontend.certificates.verify', [
            'settings' => $this->websiteSettings(),
            'certificate' => $certificate,
            'isValid' => $certificate && $certificate->status === 'issued',
            'isRevoked' => $certificate && $certificate->status === 'revoked',
        ]);
    }

    private function websiteSettings(): ?WebsiteSetting
    {
        if (! Schema::hasTable('website_settings')) {
            return null;
        }

        return WebsiteSetting::query()->first();
    }
}
