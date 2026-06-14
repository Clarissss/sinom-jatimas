@extends('layouts.app')

@section('content')
<div class="p-8 space-y-6 animate-fade-in">
    {{-- Header Section --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Manajemen Mitra</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Kelola hubungan dan publikasi mitra strategis Sinom Jati Mas.</p>
        </div>
        <button onclick="openModal('modalAdd')" class="bg-[#DD3517] text-white px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-red-100 flex items-center group">
            <i class="fa-solid fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i> Tambah Mitra Baru
        </button>
    </div>

    {{-- Grid Content --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($partners as $partner)
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all group relative overflow-hidden {{ !$partner->is_active ? 'opacity-70' : '' }}">
            
            {{-- Tombol Mata (Toggle Status) --}}
            <div class="absolute top-6 right-6">
                <form action="{{ route('admin.partners.toggle', $partner) }}" method="POST">
                    @csrf 
                    @method('PATCH')
                    <button type="submit" 
                            title="{{ $partner->is_active ? 'Klik untuk Sembunyikan' : 'Klik untuk Tampilkan' }}"
                            class="w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-300 
                            {{ $partner->is_active 
                                ? 'bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white' 
                                : 'bg-gray-100 text-gray-400 hover:bg-[#DD3517] hover:text-white' }}">
                        <i class="fa-solid {{ $partner->is_active ? 'fa-eye' : 'fa-eye-slash' }} text-sm"></i>
                    </button>
                </form>
            </div>

            <div class="flex flex-col items-center text-center space-y-5 pt-4">
                {{-- Logo Container --}}
                <div class="w-28 h-28 rounded-[2rem] bg-gray-50 border border-gray-50 flex items-center justify-center overflow-hidden p-6 group-hover:scale-105 transition-transform duration-500 shadow-inner">
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain">
                </div>

                {{-- Info --}}
                <div>
                    <h3 class="font-black text-gray-900 uppercase text-xs tracking-[0.15em] mb-2">{{ $partner->name }}</h3>
                    @if($partner->is_active)
                        <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-xl border border-blue-100">Visible</span>
                    @else
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest bg-gray-100 px-3 py-1.5 rounded-xl border border-gray-200">Hidden</span>
                    @endif
                </div>
                
                {{-- Action Group --}}
                <div class="flex space-x-2 pt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button onclick="openEditModal({{ $partner }})" class="w-10 h-10 flex items-center justify-center bg-gray-900 text-white hover:bg-blue-600 rounded-xl transition-all shadow-lg">
                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                    </button>
                    <button type="button"
                            x-data="{}"
                            @click="$dispatch('open-confirm', {
                                title: 'Hapus Mitra',
                                message: 'Yakin ingin menghapus mitra {{ addslashes($partner->name) }}?',
                                action: '{{ route('admin.partners.destroy', $partner) }}',
                                method: 'DELETE',
                                buttonText: 'Hapus',
                                buttonClass: 'bg-red-600 hover:bg-red-700',
                                icon: 'fa-trash'
                            })"
                            class="w-10 h-10 flex items-center justify-center bg-white text-[#DD3517] border border-red-50 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-lg">
                        <i class="fa-solid fa-trash text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- MODAL: CREATE MITRA --}}
<div id="modalAdd" class="hidden fixed inset-0 bg-black/60 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[3rem] w-full max-w-md overflow-hidden shadow-2xl animate-modal-in">
        <div class="p-10">
            <div class="flex justify-between items-start mb-8">
                <div class="w-16 h-16 bg-red-50 rounded-[1.5rem] flex items-center justify-center text-[#DD3517]">
                    <i class="fa-solid fa-handshake text-2xl"></i>
                </div>
                <button onclick="closeModal('modalAdd')" class="text-gray-300 hover:text-gray-900 transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tighter mb-2">Tambah Mitra</h3>
            <p class="text-sm text-gray-400 mb-8 font-medium">Lengkapi informasi mitra untuk publikasi.</p>

            <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Nama Lengkap Mitra</label>
                    <input type="text" name="name" placeholder="Contoh: PT. Adhi Karya" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-[#DD3517]/20 rounded-2xl p-4 text-sm font-bold text-gray-900" required>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Logo Perusahaan</label>
                    <div class="relative group">
                        <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer z-10" required onchange="previewImage(this, 'preview_add')">
                        <div class="w-full bg-gray-50 border-2 border-dashed border-gray-100 rounded-2xl p-8 text-center group-hover:border-[#DD3517] transition-colors">
                            <div id="preview_add_container" class="hidden mb-4">
                                <img id="preview_add" src="" class="h-20 mx-auto object-contain">
                            </div>
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-300 mb-2"></i>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pilih Gambar (PNG/JPG)</p>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeModal('modalAdd')" class="flex-1 p-5 rounded-2xl font-black text-[10px] uppercase text-gray-400 hover:bg-gray-50 transition-all tracking-[0.2em]">Batal</button>
                    <button type="submit" class="flex-1 p-5 bg-gray-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-[#DD3517] transition-all shadow-xl shadow-gray-200">Simpan Mitra</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL: EDIT MITRA --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-black/60 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[3rem] w-full max-w-md overflow-hidden shadow-2xl">
        <div class="p-10">
            <div class="flex justify-between items-start mb-8">
                <div class="w-16 h-16 bg-blue-50 rounded-[1.5rem] flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-pen-nib text-2xl"></i>
                </div>
                <button onclick="closeModal('modalEdit')" class="text-gray-300 hover:text-gray-900 transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tighter mb-2">Edit Mitra</h3>
            <p class="text-sm text-gray-400 mb-8 font-medium">Perbarui data atau logo mitra terpilih.</p>

            <form id="formEdit" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Nama Mitra</label>
                    <input type="text" name="name" id="edit_name" class="w-full bg-gray-50 border-none focus:ring-2 focus:ring-[#DD3517]/20 rounded-2xl p-4 text-sm font-bold text-gray-900" required>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Ganti Logo (Opsional)</label>
                    <div class="relative group">
                        <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this, 'preview_edit')">
                        <div class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-6 flex items-center space-x-6">
                            <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center p-2 shadow-sm border border-gray-100">
                                <img id="preview_edit" src="" class="max-w-full max-h-full object-contain">
                            </div>
                            <div class="text-left">
                                <p class="text-[9px] font-black text-gray-900 uppercase tracking-widest mb-1">Klik untuk Ganti</p>
                                <p class="text-[8px] text-gray-400 uppercase font-bold">Max. 2MB (PNG/JPG)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeModal('modalEdit')" class="flex-1 p-5 rounded-2xl font-black text-[10px] uppercase text-gray-400 hover:bg-gray-50 transition-all tracking-[0.2em]">Batal</button>
                    <button type="submit" class="flex-1 p-5 bg-gray-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-blue-600 transition-all shadow-xl shadow-gray-200">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes modal-in {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .animate-modal-in { animation: modal-in 0.3s ease-out forwards; }
</style>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Fungsi Preview Image saat pilih file
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const container = document.getElementById(previewId + '_container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                if(container) container.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Fungsi Open Edit Modal & Fill Data
    function openEditModal(partner) {
        const form = document.getElementById('formEdit');
        form.action = `/admin/partners/${partner.id}`;
        
        document.getElementById('edit_name').value = partner.name;
        document.getElementById('preview_edit').src = `/storage/${partner.logo}`;
        
        openModal('modalEdit');
    }
</script>
@endsection