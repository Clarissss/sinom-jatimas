@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-control { border-radius: 0.5rem !important; padding: 0.5rem 0.75rem !important; border-color: #d1d5db !important; }
    .ts-wrapper.focus .ts-control { border-color: #DD3517 !important; box-shadow: 0 0 0 2px rgba(221, 53, 23, 0.1) !important; }
</style>

<div class="space-y-6 animate-fade-in pb-12">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Pusat Arsip Digital</h2>
            <p class="text-sm text-gray-500">PT. Sinom Jati Mas - Manajemen Berkas Terintegrasi</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200"
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
        <form action="{{ route('admin.documents.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-end">
            
            {{-- Filter Klien --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Klien</label>
                <select name="client_id" id="filter_client" placeholder="Pilih Klien...">
                    <option value="">Semua Klien</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Proyek --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Proyek</label>
                <select name="project_id" id="filter_project" placeholder="Pilih Proyek...">
                    <option value="">Semua Proyek</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tanggal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                       class="w-full border-gray-300 rounded-lg focus:ring-[#DD3517] focus:border-[#DD3517] h-[42px] text-sm">
            </div>

            {{-- Filter Jenis File --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis File</label>
                <select name="type" class="w-full border-gray-300 rounded-lg focus:ring-[#DD3517] focus:border-[#DD3517] h-[42px] text-sm">
                    <option value="">Semua Jenis</option>
                    @foreach($categories as $key => $cat)
                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $cat['label'] }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-2">
                <button type="submit" class="w-full bg-gray-900 text-white px-4 py-2.5 rounded-lg hover:bg-gray-800 text-sm font-medium transition-colors h-[42px]">
                    <i class="fa-solid fa-filter mr-1"></i> Terapkan
                </button>
                @if(request()->anyFilled(['client_id', 'project_id', 'date', 'type']))
                    <a href="{{ route('admin.documents.index') }}" 
                       class="inline-flex items-center justify-center bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-200 text-sm font-medium h-[42px]">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Category Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categories as $key => $cat)
        <a href="{{ route('admin.documents.index', ['type' => $key, 'client_id' => request('client_id'), 'project_id' => request('project_id'), 'date' => request('date')]) }}" 
           class="group bg-white p-5 rounded-[1.5rem] border-2 {{ request('type') == $key ? 'border-[#DD3517] bg-red-50/20' : 'border-transparent' }} shadow-sm hover:border-[#DD3517] transition-all transform hover:-translate-y-1">
            <div class="{{ $cat['color'] }} w-10 h-10 rounded-xl flex items-center justify-center text-white text-lg mb-3 shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid {{ $cat['icon'] }}"></i>
            </div>
            <h4 class="font-black text-gray-900 text-xs">{{ $cat['label'] }}</h4>
            <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">{{ $cat['count'] }} Berkas</p>
        </a>
        @endforeach
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Berkas</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Klien</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Proyek</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($results as $file)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @php
                                    $typeIcons = [
                                        'contract' => 'fa-file-contract text-orange-500',
                                        'field_map' => 'fa-map text-amber-500',
                                        'technical_drawing' => 'fa-ruler-combined text-blue-500',
                                        'bast' => 'fa-clipboard-check text-emerald-500',
                                        'material_report' => 'fa-boxes-stacked text-purple-500',
                                        'other' => 'fa-file-lines text-gray-400',
                                    ];
                                    $icon = $typeIcons[$file['type'] ?? 'other'] ?? 'fa-file-lines text-gray-400';
                                @endphp
                                <i class="fa-solid {{ $icon }} mr-3 text-lg"></i>
                                <span class="font-bold text-gray-800 text-xs break-all">
                                    {{ $file['file_name'] ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-600">
                            {{ $file['client_name'] }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-gray-100 rounded-full text-[10px] font-black text-gray-500 uppercase">
                                {{ $file['project_name'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.documents.download', $file['id']) }}" 
                               class="bg-gray-900 text-white px-4 py-2 rounded-lg font-black text-[10px] hover:bg-gray-800 transition-all">
                                <i class="fa-solid fa-download mr-1"></i> DOWNLOAD
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center text-gray-400 font-bold">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
