@extends('layouts.app')

@section('title', 'Client Dashboard - PT. Sinom Jati Mas')

@section('content')

    <div class="space-y-6 animate-fade-in pb-10">

        {{-- HEADER --}}
        <div class="flex justify-between items-end px-2">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">
                    Dashboard Client
                </h2>

                <p class="text-sm text-gray-500 font-medium mt-2">
                    Monitoring progress proyek PT. Sinom Jati Mas.
                </p>
            </div>

            <div class="text-right hidden md:block border-l-2 border-gray-100 pl-6">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">
                    Update Terakhir
                </p>

                <p class="text-xs font-bold text-gray-900 uppercase tracking-tighter">
                    {{ now()->translatedFormat('d F Y, H:i') }}
                </p>
            </div>
        </div>

        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Proyek --}}
            <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            Total Proyek
                        </p>

                        <p class="text-2xl font-black text-gray-900 mt-1">
                            {{ $stats['total_projects'] }}
                        </p>
                    </div>

                    <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-[#FF812E]">
                        <i class="fa-solid fa-building-user text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Aktif --}}
            <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            Proyek Aktif
                        </p>

                        <p class="text-2xl font-black text-gray-900 mt-1">
                            {{ $stats['active_projects'] }}
                        </p>
                    </div>

                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-helmet-safety text-xl"></i>
                    </div>

                </div>
            </div>

            {{-- Selesai --}}
            <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            Proyek Selesai
                        </p>

                        <p class="text-2xl font-black text-gray-900 mt-1">
                            {{ $stats['completed_projects'] }}
                        </p>
                    </div>

                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Invoice --}}
            <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            Invoice Pending
                        </p>

                        <p class="text-2xl font-black text-gray-900 mt-1">
                            {{ $stats['pending_invoices'] }}
                        </p>
                    </div>

                    <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600">
                        <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- PROJECT LIST --}}
        <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">
                        Proyek Saya
                    </h3>

                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 italic">
                        Monitoring progress proyek client
                    </p>
                </div>
            </div>

            @forelse($projects as $project)
                <div class="p-8 border-b border-gray-50 hover:bg-gray-50/30 transition-all duration-300">
                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-8">
                        {{-- LEFT --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-2">
                                        #SJM-{{ $project->id }}
                                    </p>

                                    <h4 class="text-xl font-black text-gray-900 uppercase tracking-tight leading-tight">
                                        {{ $project->name }}
                                    </h4>

                                    <div class="flex items-center text-sm text-gray-400 mt-3">
                                        <i class="fa-solid fa-location-dot mr-2"></i>
                                        <span>
                                            {{ $project->location ?? 'Lokasi belum tersedia' }}
                                        </span>
                                    </div>
                                </div>

                                <span
                                    class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                            {{ $project->status == 'completed'
                                ? 'bg-emerald-50 text-emerald-600 border border-emerald-100'
                                : 'bg-orange-50 text-[#FF812E] border border-orange-100' }}">
                                    {{ $project->status }}
                                </span>
                            </div>

                            {{-- PROGRESS --}}
                            <div class="mt-8">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Progress Proyek
                                    </p>
                                    <p class="text-sm font-black text-gray-900">
                                        {{ $project->progress_percentage }}%
                                    </p>
                                </div>

                                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-[#DD3517] to-[#FF812E] transition-all duration-700"
                                        style="width: {{ $project->progress_percentage }}%">
                                    </div>
                                </div>
                            </div>

                            {{-- QUICK INFO --}}
                            <div class="flex flex-wrap gap-6 mt-6">
                                <div class="flex items-center text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    <i class="fa-solid fa-image mr-2 text-gray-300"></i>
                                    {{ $project->progressPhotos->count() }} Foto
                                </div>

                                <div class="flex items-center text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    <i class="fa-solid fa-file-lines mr-2 text-gray-300"></i>
                                    {{ $project->documents->count() }} Dokumen
                                </div>

                                <div class="flex items-center text-xs font-bold text-gray-500 uppercase tracking-wide">
                                    <i class="fa-solid fa-file-invoice-dollar mr-2 text-gray-300"></i>
                                    {{ $project->invoices->count() }} Invoice
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT --}}
                        <div class="flex flex-col gap-3 min-w-[180px]">
                            <a href="{{ route('client.projects.show', $project) }}"
                                class="flex items-center justify-center px-5 py-3 rounded-2xl bg-[#DD3517] text-white text-xs font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-lg">

                                <i class="fa-solid fa-eye mr-2"></i>
                                Detail Proyek
                            </a>

                            <a href="{{ route('client.documents.index') }}"
                                class="flex items-center justify-center px-5 py-3 rounded-2xl bg-gray-100 text-gray-700 text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition-all">

                                <i class="fa-solid fa-file-lines mr-2"></i>
                                Dokumen
                            </a>

                            <a href="{{ route('client.invoices.index') }}"
                                class="flex items-center justify-center px-5 py-3 rounded-2xl bg-gray-100 text-gray-700 text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition-all">

                                <i class="fa-solid fa-file-invoice-dollar mr-2"></i>
                                Invoice
                            </a>
                        </div>
                    </div>
                </div>

            @empty

                <div class="p-20 text-center">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-6">
                        <i class="fa-solid fa-folder-open text-4xl text-gray-300"></i>
                    </div>

                    <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">
                        Belum Ada Proyek
                    </h3>

                    <p class="text-sm text-gray-400 mt-3 uppercase tracking-widest">
                        Data proyek client belum tersedia
                    </p>
                </div>
            @endforelse
        </div>

        @if($projects->hasPages())
            <div class="px-8 py-4 border-t border-gray-50">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

@endsection
