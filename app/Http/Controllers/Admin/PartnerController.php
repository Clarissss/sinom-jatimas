<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('logo')->store('partners', 'public');

        Partner::create([
            'name' => $request->name,
            'logo' => $path,
            'is_active' => true
        ]);

        return back()->with('success', 'Mitra berhasil ditambahkan');
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($partner->logo);
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);
        return back()->with('success', 'Mitra berhasil diperbarui');
    }

  
    public function toggleStatus(Partner $partner)
{
    $partner->update(['is_active' => !$partner->is_active]);
    
   
    $statusText = $partner->is_active ? 'diaktifkan (terlihat)' : 'dinonaktifkan (tersembunyi)';
    return back()->with('success', "Mitra {$partner->name} berhasil {$statusText}.");
}

    public function destroy(Partner $partner)
    {
        Storage::disk('public')->delete($partner->logo);
        $partner->delete();
        return back()->with('success', 'Mitra berhasil dihapus');
    }
}
