<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\WebsiteSettingRequest;
use App\Models\WebsiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WebsiteSettingController extends Controller
{
    /**
     * Show the website settings form.
     */
    public function edit(): View
    {
        return view('admin.website.settings.edit', [
            'pageTitle' => 'Website Settings',
            'breadcrumb' => 'Website CMS / Settings',
            'settings' => $this->settings(),
        ]);
    }

    /**
     * Update the website settings.
     */
    public function update(WebsiteSettingRequest $request): RedirectResponse
    {
        $settings = $this->settings();
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $this->deleteUpload($settings->logo);
            $data['logo'] = $this->storeUpload($request->file('logo'), 'logo');
        }

        $settings->update($data);

        return redirect()
            ->route('admin.website.settings.edit')
            ->with('status', 'Website settings updated.');
    }

    private function settings(): WebsiteSetting
    {
        return WebsiteSetting::query()->firstOrCreate([], [
            'site_name' => 'S-kala – Shakuntala Shishu Lok',
            'tagline' => 'Skill, Strength & Self-Reliance',
            'email' => 'info@skala.test',
            'phone' => '+91 00000 00000',
            'address' => 'Dhampur, Uttar Pradesh',
            'footer_text' => 'Skill, Strength & Self-Reliance',
        ]);
    }

    private function storeUpload($file, string $prefix): string
    {
        $directory = public_path('uploads/website');
        File::ensureDirectoryExists($directory);

        $filename = $prefix.'-'.Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/website/'.$filename;
    }

    private function deleteUpload(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/website/')) {
            File::delete(public_path($path));
        }
    }
}
