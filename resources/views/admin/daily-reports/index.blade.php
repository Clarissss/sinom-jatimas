@extends('layouts.app')

@section('title', 'Laporan Harian - PT. Sinom Jati Mas')
@section('page-title', 'Laporan Harian')

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
    }
    .ts-wrapper.focus .ts-control { 
        border-color: #DD3517 !important; 
        box-shadow: 0 0 0 2px rgba(221, 53, 23, 0.1) !important; 
    }
</style>

<div class="space-y-6 animate-fade-in pb-10">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Laporan Harian</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Monitoring aktivitas pengerjaan lapangan harian.</p>
        </div>
        <a href="{{ route('admin.daily-reports.create') }}" 
           class="inline-flex items-center justify-center px-8 py-3 bg-gray-900 text-white text-[10px] font-black rounded-2xl hover:bg-[#DD3517] transition-all transform hover:-translate-y-1 active:scale-[0.98] shadow-xl uppercase tracking-widest">
            <i class="fas fa-plus mr-2"></i> Buat Laporan Baru
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100"
         x-data="{
            init() {
                new TomSelect('#filter_client', { plugins: ['clear_button'] });
                new TomSelect('#filter_project', { plugins: ['clear_button'] });
            }
         }">
        <form action="{{ route('admin.daily-reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 items-end">
            
            {{-- Filter Klien --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Klien</label>
                <select name="client_id" id="filter_client" placeholder="Cari Klien...">
                    <option value="">Semua Klien</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Proyek --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Proyek</label>
                <select name="project_id" id="filter_project" placeholder="Cari Proyek...">
                    <option value="">Semua Proyek</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tanggal --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm h-[46px] font-bold focus:ring-[#DD3517] focus:border-[#DD3517] transition-all">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-2 h-[46px]">
                <button type="submit" class="flex-1 bg-gray-900 text-white rounded-xl hover:bg-black text-[10px] font-black uppercase tracking-widest transition-all shadow-md">
                    <i class="fas fa-filter mr-1 text-[8px]"></i> Terapkan
                </button>
                @if(request()->anyFilled(['client_id', 'project_id', 'date']))
                    <a href="{{ route('admin.daily-reports.index') }}" class="w-14 inline-flex items-center justify-center bg-gray-100 text-gray-400 rounded-xl hover:bg-gray-200 transition-all shadow-sm">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Proyek & Klien</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Aktivitas</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Cuaca</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Foto</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <p class="font-black text-gray-900 text-sm leading-none mb-1">{{ $report->report_date->format('d M Y') }}</p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest italic">Oleh: {{ $report->creator->name ?? 'System' }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm font-black text-gray-900 leading-none uppercase tracking-tighter">{{ $report->project->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 italic flex items-center">
                                    {{ $report->client->name }}
                                    @if($report->is_accepted)
                                        <span class="ml-2 bg-emerald-50 text-emerald-600 border border-emerald-200 text-[8px] px-2 py-0.5 rounded-md font-black">DITERIMA</span>
                                    @else
                                        <span class="ml-2 bg-orange-50 text-orange-600 border border-orange-200 text-[8px] px-2 py-0.5 rounded-md font-black">PENDING</span>
                                    @endif
                                </p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs text-gray-600 line-clamp-2 max-w-xs font-medium">{{ $report->activity_description }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                @php
                                    $weatherMap = [
                                        'sunny' => ['icon' => 'fa-sun', 'color' => 'text-orange-500', 'label' => 'CERAH'],
                                        'cloudy' => ['icon' => 'fa-cloud', 'color' => 'text-gray-400', 'label' => 'BERAWAN'],
                                        'rainy' => ['icon' => 'fa-cloud-showers-heavy', 'color' => 'text-blue-500', 'label' => 'HUJAN'],
                                        'storm' => ['icon' => 'fa-bolt', 'color' => 'text-purple-600', 'label' => 'BADAI'],
                                    ];
                                    $w = $weatherMap[$report->weather_condition] ?? $weatherMap['sunny'];
                                @endphp
                                <div class="{{ $w['color'] }} flex flex-col items-center">
                                    <i class="fa-solid {{ $w['icon'] }} text-sm mb-1"></i>
                                    <span class="text-[8px] font-black">{{ $w['label'] }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                {{-- PERBAIKAN: Mengambil foto pertama untuk thumbnail --}}
                                @if($report->photo)
                                    @php
                                        $allPhotos = explode(',', $report->photo);
                                        $firstPhoto = trim($allPhotos[0]);
                                    @endphp
                                    <div class="relative inline-block">
                                        <img src="{{ asset('storage/' . $firstPhoto) }}" class="w-10 h-10 rounded-xl object-cover border border-gray-100 shadow-sm mx-auto">
                                        @if(count($allPhotos) > 1)
                                            <span class="absolute -top-1.5 -right-1.5 bg-gray-900 text-white font-black text-[8px] px-1 py-0.5 rounded-md border border-white">
                                                +{{ count($allPhotos) - 1 }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <i class="fa-solid fa-image text-gray-200"></i>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.daily-reports.show', $report) }}" class="p-2 bg-gray-50 text-gray-400 hover:text-blue-600 rounded-xl transition-all"><i class="fa-solid fa-eye"></i></a>
                                    
                                    @if(!$report->is_accepted)
                                        <a href="{{ route('admin.daily-reports.edit', $report) }}" class="p-2 bg-gray-50 text-gray-400 hover:text-yellow-600 rounded-xl transition-all"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <button type="button"
                                                x-data="{}"
                                                @click="$dispatch('open-confirm', {
                                                    title: 'Hapus Laporan Harian',
                                                    message: 'Yakin ingin menghapus laporan harian tanggal {{ $report->report_date->format('d/m/Y') }}?',
                                                    action: '{{ route('admin.daily-reports.destroy', $report) }}',
                                                    method: 'DELETE',
                                                    buttonText: 'Hapus',
                                                    buttonClass: 'bg-red-600 hover:bg-red-700',
                                                    icon: 'fa-trash-can'
                                                })"
                                                class="p-2 bg-gray-50 text-gray-400 hover:text-red-600 rounded-xl transition-all"
                                                title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 font-bold px-2 flex items-center italic"><i class="fa-solid fa-lock mr-1 text-[10px]"></i> Terkunci</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-clipboard-list text-4xl text-gray-100 mb-4"></i>
                                    <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">Laporan belum tersedia</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection