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
        // Ambil data pertama, jika tidak ada buat objek kosong
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
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo) Storage::delete($profile->logo);
            $validated['logo'] = $request->file('logo')->store('company_logos', 'public');
        }

        // Update data jika ada, buat baru jika belum ada
        CompanyProfile::updateOrCreate(['id' => 1], $validated);

        return back()->with('success', 'Profil Perusahaan berhasil diperbarui.');
    }
}