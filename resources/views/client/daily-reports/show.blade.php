@extends('layouts.app')

@section('title', 'Laporan Harian - PT. Sinom Jati Mas')
@section('page-title', 'Laporan Harian Proyek')

@section('content')
<div class="space-y-6 animate-fade-in">
    {{-- Project Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h2>
        <p class="text-sm text-gray-500 mt-1 flex items-center">
            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ $project->location ?? 'Lokasi belum ditentukan' }}
        </p>
    </div>
    
    {{-- Reports List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Laporan</h3>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($reports ?? [] as $report)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-3">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $report->report_date->format('d M Y') }}</p>
                                <p class="text-sm text-gray-500">{{ $report->creator->name ?? 'Admin' }}</p>
                            </div>
                        </div>
                        @php
                            $weatherConfig = [
                                'sunny' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Cerah'],
                                'cloudy' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', 'label' => 'Berawan'],
                                'rainy' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'M20 16.2A4.5 4.5 0 0017.5 8h-1.832A4.996 4.996 0 0011 4.5a5.002 5.002 0 00-4.9 4.005A4.5 4.5 0 003 16.2c-.6.1-1 .6-1 1.2v.1a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-.1c0-.6-.4-1.1-1-1.2zM8 19v2m4-2v2m4-2v2', 'label' => 'Hujan'],
                                'storm' => ['class' => 'bg-purple-100 text-purple-800', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'Badai'],
                            ];
                            $config = $weatherConfig[$report->weather_condition] ?? $weatherConfig['sunny'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }} self-start">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                            </svg>
                            {{ $config['label'] }}
                        </span>
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $report->activity_description }}</p>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <div class="bg-gray-100 rounded-full p-4 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada laporan</p>
                        <p class="text-sm text-gray-400 mt-1">Laporan akan muncul di sini</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
