<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $profile = CompanyProfile::first() ?? new CompanyProfile();

        return view('admin.company-profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = CompanyProfile::first() ?? new CompanyProfile();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'about_us' => 'required',
            'vision' => 'required',
            'mission' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'about_image_1' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
            'about_image_2' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
            'about_image_3' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company_logos', 'public');
        }

        foreach (['about_image_1', 'about_image_2', 'about_image_3'] as $field) {
            if ($request->hasFile($field)) {
                if ($profile->{$field}) {
                    Storage::disk('public')->delete($profile->{$field});
                }
                $validated[$field] = $request->file($field)->store('company_about', 'public');
            }
        }

        CompanyProfile::updateOrCreate(['id' => 1], $validated);

        return back()->with('success', 'Profil Perusahaan berhasil diperbarui.');
    }
}
