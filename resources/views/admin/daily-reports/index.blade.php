@extends('layouts.app')

@section('title', 'Kelola Invoice - PT. Sinom Jati Mas')
@section('page-title', 'Kelola Invoice')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    /* Konsistensi styling Tom Select */
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
    .ts-dropdown { border-radius: 1rem !important; shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important; }
</style>

<div class="space-y-6 animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Daftar Invoice</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola invoice dan termin pembayaran proyek</p>
        </div>
        <a href="{{ route('admin.invoices.create') }}" 
           class="inline-flex items-center justify-center px-6 py-2.5 bg-[#DD3517] text-white text-xs font-black rounded-xl hover:bg-[#FF812E] transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-md uppercase tracking-widest">
            <i class="fas fa-plus mr-2"></i> Buat Invoice
        </a>
    </div>

    {{-- Filter Bar (Gaya Laporan Harian) --}}
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100"
         x-data="{
            init() {
                new TomSelect('#filter_client', {
                    plugins: ['clear_button'],
                    render: {
                        option: (data, escape) => `<div><span class='mr-2 text-gray-400'><i class='fas fa-user-tie w-4'></i></span>${escape(data.text)}</div>`,
                        item: (data, escape) => `<div><span class='mr-2 text-[#DD3517]'><i class='fas fa-user-tie w-4'></i></span>${escape(data.text)}</div>`
                    }
                });
                new TomSelect('#filter_project', {
                    plugins: ['clear_button'],
                    render: {
                        option: (data, escape) => `<div><span class='mr-2 text-gray-400'><i class='fas fa-building w-4'></i></span>${escape(data.text)}</div>`,
                        item: (data, escape) => `<div><span class='mr-2 text-[#DD3517]'><i class='fas fa-building w-4'></i></span>${escape(data.text)}</div>`
                    }
                });
            }
         }">
        <form action="{{ route('admin.invoices.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-end">
            
            {{-- Filter Klien --}}
            <div class="md:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Klien</label>
                <select name="client_id" id="filter_client" placeholder="Pilih Klien...">
                    <option value="">Semua Klien</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Proyek --}}
            <div class="md:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Proyek</label>
                <select name="project_id" id="filter_project" placeholder="Pilih Proyek...">
                    <option value="">Semua Proyek</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Status --}}
            <div class="md:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Status</label>
                <select name="status" class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm focus:ring-[#DD3517] focus:border-[#DD3517] h-[46px] font-bold transition-all">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>DRAFT</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>TERKIRIM</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>LUNAS</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>JATUH TEMPO</option>
                </select>
            </div>

            {{-- Filter Tanggal --}}
            <div class="md:col-span-1">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm focus:ring-[#DD3517] focus:border-[#DD3517] h-[46px] font-medium">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-2 h-[46px]">
                <button type="submit" class="w-full bg-gray-900 text-white rounded-xl hover:bg-black text-[10px] font-black uppercase tracking-widest transition-colors shadow-sm">
                    <i class="fas fa-filter mr-1"></i> Terapkan
                </button>
                @if(request()->anyFilled(['client_id', 'project_id', 'date', 'status']))
                    <a href="{{ route('admin.invoices.index') }}" class="w-full inline-flex items-center justify-center bg-gray-100 text-gray-500 rounded-xl hover:bg-gray-200 text-[10px] font-black uppercase tracking-widest transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Klien</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyek</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cuaca</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($reports ?? [] as $report)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar-day text-green-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-900 text-sm">{{ $report->report_date->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                {{ $report->client->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $report->project->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-xs">{{ Str::limit($report->activity_description, 40) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $weatherConfig = [
                                        'sunny' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-sun', 'label' => 'Cerah'],
                                        'cloudy' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-cloud', 'label' => 'Berawan'],
                                        'rainy' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-cloud-showers-heavy', 'label' => 'Hujan'],
                                        'storm' => ['class' => 'bg-purple-100 text-purple-800', 'icon' => 'fa-bolt', 'label' => 'Badai'],
                                    ];
                                    $config = $weatherConfig[$report->weather_condition] ?? $weatherConfig['sunny'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                    <i class="fas {{ $config['icon'] }} mr-1"></i>
                                    {{ $config['label'] }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($report->photo)
                                    <div class="inline-flex h-10 w-10 rounded-lg border border-gray-200 shadow-sm p-0.5 bg-white overflow-hidden">
                                        <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto" class="h-full w-full object-cover rounded-md">
                                    </div>
                                @else
                                    <i class="fas fa-image text-gray-300"></i>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.daily-reports.show', $report) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.daily-reports.edit', $report) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.daily-reports.destroy', $report) }}" method="POST" class="inline" onsubmit="return confirm('Hapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-search text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Laporan tidak ditemukan</p>
                                    <p class="text-sm text-gray-400 mt-1">Coba sesuaikan filter pencarian Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection