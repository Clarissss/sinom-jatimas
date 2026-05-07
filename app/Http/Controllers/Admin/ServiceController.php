<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Penting untuk manipulasi file

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            // Simpan di folder services/icons dalam disk public
            $path = $request->file('icon')->store('services/icons', 'public');
            $validated['icon'] = $path;
        }

        $validated['slug'] = Str::slug($request->name);
        
        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dibuat.');
    }

    /**
     * Method Show untuk melihat detail layanan
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            // 'is_active' dihapus dari validasi karena inputnya sudah kita buang dari form elegant
        ]);

        if ($request->hasFile('icon')) {
            // Hapus file lama jika ada sebelum upload yang baru
            if ($service->icon && Storage::disk('public')->exists($service->icon)) {
                Storage::disk('public')->delete($service->icon);
            }
            
            $path = $request->file('icon')->store('services/icons', 'public');
            $validated['icon'] = $path;
        }

        $validated['slug'] = Str::slug($request->name);
        
        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan diperbarui.');
    }

    public function destroy(Service $service)
    {
        // Hapus file fisik agar tidak memenuhi storage
        if ($service->icon && Storage::disk('public')->exists($service->icon)) {
            Storage::disk('public')->delete($service->icon);
        }

        $service->delete();
        
        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}