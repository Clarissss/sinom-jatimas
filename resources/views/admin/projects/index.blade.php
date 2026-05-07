@extends('layouts.app')

@section('title', 'Kelola Proyek - PT. Sinom Jati Mas')
@section('page-title', 'Kelola Proyek')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-control { 
        border-radius: 0.75rem !important; 
        padding: 0.6rem 0.75rem !important; 
        border-color: #f3f4f6 !important;
        background-color: #f9fafb !important;
        font-size: 0.875rem !important;
        font-weight: 700 !important;
    }
    .ts-wrapper.focus .ts-control { 
        border-color: #DD3517 !important; 
        box-shadow: 0 0 0 2px rgba(221, 53, 23, 0.1) !important; 
    }
    .ts-dropdown { border-radius: 1rem !important; shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important; }
</style>

<div class="space-y-6 animate-fade-in pb-10">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Daftar Proyek</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Monitoring pengerjaan operasional PT. Sinom Jati Mas.</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" 
           class="inline-flex items-center justify-center px-8 py-3 bg-gray-900 text-white text-[10px] font-black rounded-2xl hover:bg-[#DD3517] transition-all transform hover:-translate-y-1 active:scale-[0.98] shadow-xl uppercase tracking-widest">
            <i class="fas fa-plus mr-2 text-[8px]"></i> Tambah Proyek Baru
        </a>
    </div>

    {{-- Filter Bar (Gaya Laporan Harian) --}}
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <form action="{{ route('admin.projects.index') }}" method="GET" id="filterForm" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 items-end">
            
            {{-- Filter Klien --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">1. Pilih Klien</label>
                <select name="client_id" id="filter_client" placeholder="Cari Klien...">
                    <option value="">Semua Klien</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Proyek (Dependent Dropdown) --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">2. Pilih Proyek</label>
                <select name="project_id" id="filter_project" placeholder="Pilih Klien Dahulu...">
                    <option value="">Pilih Klien Dahulu</option>
                </select>
            </div>

            {{-- Filter Status --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">3. Status</label>
                <select name="status" class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm h-[46px] font-bold focus:ring-[#DD3517] uppercase tracking-tighter transition-all">
                    <option value="">SEMUA STATUS</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>PENDING</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>InProgress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Done</option>
                </select>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-2 h-[46px]">
                <button type="submit" class="flex-1 bg-gray-900 text-white rounded-xl hover:bg-black text-[10px] font-black uppercase tracking-widest transition-all shadow-md">
                    <i class="fas fa-filter mr-1 text-[8px]"></i> Terapkan
                </button>
                @if(request()->anyFilled(['client_id', 'project_id', 'status']))
                    <a href="{{ route('admin.projects.index') }}" class="w-14 inline-flex items-center justify-center bg-gray-100 text-gray-400 rounded-xl hover:bg-gray-200 transition-all shadow-sm">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Detail Proyek</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Klien</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Progress</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-6 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50/50 transition-all group">
                            <td class="px-8 py-5">
                                <div class="font-black text-gray-900 text-sm uppercase tracking-tight group-hover:text-[#DD3517] transition-colors">{{ $project->name }}</div>
                                <div class="text-[10px] text-gray-400 font-bold mt-1 flex items-center uppercase tracking-widest italic">
                                    <i class="fa-solid fa-location-dot mr-1.5 text-[#FF812E]"></i>
                                    {{ $project->location ?? 'Indonesia' }}
                                </div>
                            </td>
                            <td class="px-8 py-5 font-black text-gray-700 text-xs uppercase tracking-tighter">
                                {{ $project->client->name }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 bg-gray-100 rounded-full h-1.5 min-w-[80px] overflow-hidden">
                                        <div class="bg-[#FF812E] h-full rounded-full transition-all duration-1000" style="width: {{ $project->progress_percentage }}%"></div>
                                    </div>
                                    <span class="text-[11px] font-black text-gray-900">{{ $project->progress_percentage }}%</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                @php
                                    $styles = [
                                        'in_progress' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'completed' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $styles[$project->status] ?? 'bg-gray-50 text-gray-400' }}">
                                    {{ $project->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.projects.show', $project) }}" class="p-2 text-gray-400 hover:text-[#DD3517] transition-all"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="p-2 text-gray-400 hover:text-blue-600 transition-all"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-300 hover:text-red-600 transition-all"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-gray-400 font-black uppercase text-[10px] tracking-widest">Data Tidak Ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- JAVASCRIPT DEPENDENT DROPDOWN --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi TomSelect
        var clientSelect = new TomSelect('#filter_client', { plugins: ['clear_button'] });
        var projectSelect = new TomSelect('#filter_project', { plugins: ['clear_button'] });

        // Fungsi Memuat Proyek
        function loadProjects(clientId, selectedProjectId = null) {
            projectSelect.clearOptions();
            projectSelect.clear();
            
            if (!clientId) {
                projectSelect.addOption({value: '', text: 'Pilih Klien Dahulu'});
                projectSelect.refreshOptions();
                return;
            }

            // AJAX call ke route index
            fetch(`{{ route('admin.projects.index') }}?get_projects=true&client_id=${clientId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.length > 0) {
                    data.forEach(p => projectSelect.addOption({value: p.id, text: p.name}));
                } else {
                    projectSelect.addOption({value: '', text: 'Tidak ada proyek'});
                }
                projectSelect.refreshOptions();
                if (selectedProjectId) projectSelect.setValue(selectedProjectId);
            })
            .catch(err => console.error('Error fetching projects:', err));
        }

        // Listener saat Klien berubah
        clientSelect.on('change', function(val) {
            loadProjects(val);
        });

        // Cek jika ada filter yang sedang aktif (setelah submit)
        const currentClientId = "{{ request('client_id') }}";
        const currentProjectId = "{{ request('project_id') }}";
        if (currentClientId) {
            loadProjects(currentClientId, currentProjectId);
        }
    });
</script>
@endsection