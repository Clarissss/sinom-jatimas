@extends('layouts.app')

@section('title', 'Tambah Laporan Harian - PT. Sinom Jati Mas')
@section('page-title', 'Tambah Laporan Harian')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Form Laporan Harian</h3>
        </div>
        
        <div class="p-6">
            <form action="{{ route('admin.daily-reports.store') }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                
                <div class="mb-6">
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Proyek <span class="text-red-500">*</span>
                    </label>
                    <select id="project_id"
                            name="project_id" 
                            class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('project_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Proyek</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="report_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="date" 
                               id="report_date"
                               name="report_date" 
                               class="block w-full pl-10 pr-3 py-2.5 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('report_date') border-red-500 @enderror"
                               required>
                    </div>
                    @error('report_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="weather_condition" class="block text-sm font-medium text-gray-700 mb-2">Kondisi Cuaca</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <select id="weather_condition"
                                name="weather_condition" 
                                class="block w-full pl-10 pr-3 py-2.5 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="sunny">Cerah</option>
                            <option value="cloudy">Berawan</option>
                            <option value="rainy">Hujan</option>
                            <option value="storm">Badai</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="activity_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Aktivitas <span class="text-red-500">*</span>
                    </label>
                    <textarea id="activity_description"
                              name="activity_description" 
                              rows="4" 
                              class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('activity_description') border-red-500 @enderror"
                              placeholder="Jelaskan aktivitas yang dilakukan hari ini..."
                              required></textarea>
                    @error('activity_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.daily-reports.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            :disabled="loading"
                            class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed shadow-sm">
                        <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? 'Menyimpan...' : 'Simpan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
