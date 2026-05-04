@extends('layouts.app')

@section('title', 'Edit Laporan - PT. Sinom Jati Mas')
@section('page-title', 'Edit Laporan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.daily-reports.update', $dailyReport) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Proyek</label>
                <select name="project_id" class="w-full border-gray-300 rounded-lg">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $dailyReport->project_id == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="report_date" value="{{ $dailyReport->report_date->format('Y-m-d') }}" class="w-full border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Cuaca</label>
                <select name="weather_condition" class="w-full border-gray-300 rounded-lg">
                    <option value="sunny" {{ $dailyReport->weather_condition == 'sunny' ? 'selected' : '' }}>Cerah</option>
                    <option value="cloudy" {{ $dailyReport->weather_condition == 'cloudy' ? 'selected' : '' }}>Berawan</option>
                    <option value="rainy" {{ $dailyReport->weather_condition == 'rainy' ? 'selected' : '' }}>Hujan</option>
                    <option value="storm" {{ $dailyReport->weather_condition == 'storm' ? 'selected' : '' }}>Badai</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Aktivitas</label>
                <textarea name="activity_description" rows="4" class="w-full border-gray-300 rounded-lg" required>{{ $dailyReport->activity_description }}</textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.daily-reports.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
