<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminSettingController extends Controller
{
    public function index(): View
    {
        return view('backend.settings', [
            'siteLogo' => Setting::getValue('site_logo', asset('assets/images/logo.png')),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $directory = public_path('uploads/settings');
            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $currentLogo = Setting::getValue('site_logo');
            if ($currentLogo && str_starts_with((string) $currentLogo, 'uploads/settings/') && File::exists(public_path($currentLogo))) {
                File::delete(public_path($currentLogo));
            }

            $filename = 'site-logo-' . time() . '-' . Str::random(8) . '.' . $logo->getClientOriginalExtension();
            $logo->move($directory, $filename);

            Setting::setValue('site_logo', 'uploads/settings/' . $filename);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
