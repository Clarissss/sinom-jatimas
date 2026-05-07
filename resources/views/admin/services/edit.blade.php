@extends('layouts.app')

@section('title', 'Edit Layanan - PT. Sinom Jati Mas')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in" 
     x-data="{ photoPreview: '{{ $service->icon ? asset('storage/' . $service->icon) : null }}' }">
    
    {{-- Breadcrumbs & Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <nav class="flex text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#DD3517] transition-colors">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.services.index') }}" class="hover:text-[#DD3517] transition-colors">Layanan</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Perbarui</span>
            </nav>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Edit Layanan</h2>
            <p class="text-sm text-gray-500 font-medium tracking-tight">Melakukan pembaruan informasi pada kategori jasa #{{ $service->id }}.</p>
        </div>
        
        <a href="{{ route('admin.services.index') }}" 
           class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-[#DD3517] transition-all group">
            <div class="w-8 h-8 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center mr-3 group-hover:bg-red-50 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-50 overflow-hidden">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12 space-y-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                {{-- Sisi Kiri: Media Identitas --}}
                <div class="lg:col-span-4 space-y-8">
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Visual Identitas Current</label>
                        <div class="relative group">
                            <div class="aspect-square w-full rounded-[2rem] bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-[#DD3517]/30">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-center p-6">
                                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 text-gray-300">
                                            <i class="fa-solid fa-image text-2xl"></i>
                                        </div>
                                    </div>
                                </template>
                                
                                {{-- Overlay on Hover --}}
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm cursor-pointer" @click="$refs.iconInput.click()">
                                    <span class="px-6 py-2 bg-white text-gray-900 text-[10px] font-black uppercase rounded-xl shadow-xl">
                                        Ganti Berkas
                                    </span>
                                </div>
                            </div>
                        </div>
                        <input type="file" name="icon" x-ref="iconInput" class="hidden" accept="image/*"
                               @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                        
                        <p class="text-[9px] text-gray-400 font-medium leading-relaxed italic text-center uppercase tracking-widest">Klik gambar untuk mengubah ikon layanan.</p>
                    </div>
                </div>

                {{-- Sisi Kanan: Konten --}}
                <div class="lg:col-span-8 space-y-10">
                    {{-- Nama Layanan --}}
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Judul Layanan</label>
                        <input type="text" name="name" value="{{ old('name', $service->name) }}"
                               class="w-full bg-white border-0 border-b-2 border-gray-100 py-4 px-0 text-2xl font-black text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all" 
                               placeholder="Masukkan Nama Jasa..." required>
                        @error('name') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Deskripsi Pekerjaan</label>
                        <div class="relative">
                            <textarea name="description" rows="10" 
                                      class="w-full bg-gray-50 border-0 rounded-[2rem] p-8 text-sm text-gray-600 focus:ring-2 focus:ring-[#DD3517]/10 focus:bg-white transition-all shadow-inner leading-relaxed" 
                                      required>{{ old('description', $service->description) }}</textarea>
                            <div class="absolute bottom-6 right-8 text-[10px] font-black text-gray-300 uppercase tracking-widest">SJM Editor</div>
                        </div>
                        @error('description') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-10 border-t border-gray-50 flex flex-col md:flex-row gap-4">
                <button type="submit" 
                        class="flex-1 py-5 bg-[#DD3517] text-white font-black rounded-[1.5rem] shadow-[0_15px_30px_rgba(221,53,23,0.2)] hover:bg-gray-900 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-[0.2em] text-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.services.index') }}" 
                   class="px-12 py-5 bg-gray-100 text-gray-400 font-black rounded-[1.5rem] hover:bg-gray-200 transition-all text-sm uppercase tracking-widest text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection