@extends('layouts.app')

@section('title', 'Dokumen - PT. Sinom Jati Mas')
@section('page-title', 'Dokumen Saya')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        .ts-control {
            min-height: 42px !important;
            border-radius: 0.75rem !important;
            border: 1px solid #d1d5db !important;
            padding: 0.45rem 0.75rem !important;
            box-shadow: none !important;
        }

        .ts-wrapper.single .ts-control {
            background: white !important;
        }

        .ts-dropdown {
            border-radius: 1rem !important;
            overflow: hidden;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }

        .ts-dropdown .option {
            padding: 12px 14px !important;
        }

        .ts-dropdown .active {
            background: #fff5f2 !important;
            color: #DD3517 !important;
        }
    </style>

    <div class="space-y-6 animate-fade-in pb-12">

        {{-- HEADER --}}
        <div class="flex justify-between items-end px-2">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">
                    DOKUMEN PROYEK
                </h2>
                <p class="text-sm text-gray-500 font-medium mt-2">
                    Akses seluruh dokumen dan berkas proyek Anda.
                </p>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200" x-data="{
            init() {
                new TomSelect('#filter_project', {
                    create: false,
                    maxOptions: 500,
                    placeholder: 'Pilih Proyek...',
                    render: {
                        option: (data, escape) =>
                            `<div class='py-2 px-3 flex items-center'>
                                <i class='fa-solid fa-building text-gray-400 mr-2'></i>
                                <span>${escape(data.text)}</span>
                            </div>`,
                        item: (data, escape) =>
                            `<div class='flex items-center'>
                                <i class='fa-solid fa-building text-[#DD3517] mr-2'></i>
                                <span>${escape(data.text)}</span>
                            </div>`
                    }
                });
            }
        }">

            <form method="GET" action="{{ route('client.documents.index') }}"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-end">

                {{-- PROJECT --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Proyek
                    </label>
                    <select name="project_id" id="filter_project" placeholder="Pilih Proyek...">
                        <option value="">
                            Semua Proyek
                        </option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TYPE (Disesuaikan menjadi Kategori Invoice) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jenis File
                    </label>
                    <select name="type"
                        class="w-full border-gray-300 rounded-xl focus:ring-[#DD3517] focus:border-[#DD3517] h-[42px] text-sm">
                        <option value="">
                            Semua Jenis
                        </option>
                        <option value="daily_report" {{ request('type') == 'daily_report' ? 'selected' : '' }}>
                            Laporan Harian
                        </option>
                        <option value="invoice" {{ request('type') == 'invoice' ? 'selected' : '' }}>
                            Invoice Tagihan
                        </option>
                        <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>
                            Kontrak Kerja
                        </option>
                    </select>
                </div>

                {{-- DATE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal
                    </label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full border-gray-300 rounded-xl focus:ring-[#DD3517] focus:border-[#DD3517] h-[42px] text-sm px-4">
                </div>

                {{-- SEARCH --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Cari Dokumen
                    </label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari dokumen..."
                            class="w-full border-gray-300 rounded-xl focus:ring-[#DD3517] focus:border-[#DD3517] h-[42px] text-sm pl-10">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="w-full bg-[#0F172A] text-white px-4 py-2.5 rounded-xl hover:bg-black text-sm font-semibold transition-all h-[42px]">
                        <i class="fa-solid fa-filter mr-1"></i>
                        Terapkan
                    </button>
                    @if (request()->anyFilled(['project_id', 'type', 'date', 'search']))
                        <a href="{{ route('client.documents.index') }}"
                            class="inline-flex items-center justify-center bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl hover:bg-gray-200 text-sm font-medium h-[42px]">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- CATEGORY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- DAILY REPORT --}}
            <a href="{{ route('client.documents.index', ['type' => 'daily_report', 'project_id' => request('project_id'), 'date' => request('date'), 'search' => request('search')]) }}"
                class="group bg-white p-6 rounded-[2rem] border-2 {{ request('type') == 'daily_report' ? 'border-[#DD3517] bg-red-50/20' : 'border-transparent' }} shadow-sm hover:border-[#DD3517] transition-all transform hover:-translate-y-1">
                <div class="bg-emerald-600 w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl mb-4 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h4 class="font-black text-gray-900 text-sm">
                    Laporan Harian
                </h4>
                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">
                    {{ $categories['daily_report']['count'] }} Berkas
                </p>
            </a>

            {{-- INVOICE TAGIHAN (Mengubah Tampilan File Chat Lama) --}}
            <a href="{{ route('client.documents.index', ['type' => 'invoice', 'project_id' => request('project_id'), 'date' => request('date'), 'search' => request('search')]) }}"
                class="group bg-white p-6 rounded-[2rem] border-2 {{ request('type') == 'invoice' ? 'border-[#DD3517] bg-red-50/20' : 'border-transparent' }} shadow-sm hover:border-[#DD3517] transition-all transform hover:-translate-y-1">
                <div class="bg-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl mb-4 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <h4 class="font-black text-gray-900 text-sm">
                    Invoice Tagihan
                </h4>
                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">
                    {{ $categories['invoice']['count'] }} Berkas
                </p>
            </a>

            {{-- CONTRACT --}}
            <a href="{{ route('client.documents.index', ['type' => 'contract', 'project_id' => request('project_id'), 'date' => request('date'), 'search' => request('search')]) }}"
                class="group bg-white p-6 rounded-[2rem] border-2 {{ request('type') == 'contract' ? 'border-[#DD3517] bg-red-50/20' : 'border-transparent' }} shadow-sm hover:border-[#DD3517] transition-all transform hover:-translate-y-1">
                <div class="bg-orange-500 w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl mb-4 shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-contract"></i>
                </div>
                <h4 class="font-black text-gray-900 text-sm">
                    Kontrak Kerja
                </h4>
                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">
                    {{ $categories['contract']['count'] }} Berkas
                </p>
            </a>
        </div>

        {{-- DATA TABLE --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                Berkas
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                Proyek
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                Tipe
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @forelse($results as $file)
                            @php
                                $fileObj = (object) $file; 
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @php
                                            $icon = 'fa-file-lines text-gray-400';

                                            if ($fileObj->source == 'chat') {
                                                $icon = 'fa-file-invoice-dollar text-blue-500'; // Ikon invoice tagihan
                                            }

                                            if ($fileObj->source == 'report') {
                                                $icon = 'fa-image text-emerald-500'; // Ikon foto lapangan harian
                                            }
                                        @endphp
                                        <i class="fa-solid {{ $icon }} mr-3 text-lg"></i>
                                        <span class="font-bold text-gray-800 text-xs break-all">
                                            {{ $fileObj->file_name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-gray-100 rounded-full text-[10px] font-black text-gray-500 uppercase">
                                        {{ $fileObj->project_name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-gray-100 rounded-full text-[10px] font-black text-gray-500 uppercase">
                                        {{ str_replace('_', ' ', $fileObj->type == 'chat_file' ? 'invoice' : $fileObj->type) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    {{-- Mengamankan rute unduhan dengan query parameter path spesifik multiple foto --}}
                                    <a href="{{ route('client.documents.download', ['project' => $fileObj->project_id, 'document' => $fileObj->id]) }}?source={{ $fileObj->source }}{{ isset($fileObj->extra_path) && $fileObj->extra_path ? '&path=' . urlencode($fileObj->extra_path) : '' }}"
                                        class="bg-[#0F172A] text-white px-4 py-2 rounded-xl font-bold text-[10px] hover:bg-black transition-all">
                                        <i class="fa-solid fa-download mr-1"></i>
                                        DOWNLOAD
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