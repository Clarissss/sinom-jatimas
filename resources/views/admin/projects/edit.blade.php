@extends('layouts.app')

@section('title', 'Edit Proyek - PT. Sinom Jati Mas')
@section('page-title', 'Edit Proyek')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Edit Informasi Proyek</h3>
        </div>
        
        <div class="p-6">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                @method('PUT')
                
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Proyek <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name"
                               name="name" 
                               value="{{ $project->name }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama proyek"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Klien <span class="text-red-500">*</span>
                        </label>
                        <select id="client_id" 
                                name="client_id" 
                                class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 @error('client_id') border-red-500 @enderror"
                                required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="location"
                               name="location" 
                               value="{{ $project->location }}"
                               class="block w-full pl-10 pr-3 py-2.5 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Masukkan lokasi proyek">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" 
                               id="start_date"
                               name="start_date" 
                               value="{{ $project->start_date?->format('Y-m-d') }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" 
                               id="end_date"
                               name="end_date" 
                               value="{{ $project->end_date?->format('Y-m-d') }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" 
                                name="status" 
                                class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $project->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="progress_percentage" class="block text-sm font-medium text-gray-700 mb-2">Progress (%)</label>
                        <input type="number" 
                               id="progress_percentage"
                               name="progress_percentage" 
                               min="0" 
                               max="100" 
                               value="{{ $project->progress_percentage }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="contract_value" class="block text-sm font-medium text-gray-700 mb-2">Nilai Kontrak (Rp)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">Rp</span>
                        </div>
                        <input type="number" 
                               id="contract_value"
                               name="contract_value" 
                               value="{{ $project->contract_value }}"
                               class="block w-full pl-12 pr-3 py-2.5 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                               placeholder="0">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description"
                              name="description" 
                              rows="4" 
                              class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                              placeholder="Masukkan deskripsi proyek">{{ $project->description }}</textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.projects.index') }}" 
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
                        <span x-text="loading ? 'Menyimpan...' : 'Update'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
