@extends('layouts.app')

@section('title', 'Edit Proyek - PT. Sinom Jati Mas')
@section('page-title', 'Edit Proyek')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="max-w-5xl mx-auto animate-fade-in pb-12">
    {{-- Financial Summary Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nilai Kontrak</p>
            <p class="text-xl font-black text-gray-900 mt-1">Rp {{ number_format($project->contract_value, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Ter-Invoice</p>
            <p class="text-xl font-black text-blue-600 mt-1">Rp {{ number_format($project->total_invoiced, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
            <p class="text-[10px] font-black text-red-400 uppercase tracking-widest">Sisa Tagihan</p>
            <p class="text-xl font-black text-red-600 mt-1">Rp {{ number_format($project->remaining_payment, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Edit Data Proyek #{{ $project->id }}</h3>
                <p class="text-xs text-gray-500 font-medium">Lakukan pembaruan status pengerjaan dan lokasi proyek.</p>
            </div>
            <span class="px-4 py-1.5 bg-gray-900 text-white rounded-full text-[9px] font-black uppercase tracking-widest">{{ $project->status }}</span>
        </div>
        
        <div class="p-8 md:p-12">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                @csrf @method('PUT')
                
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Proyek</label>
                        <input type="text" name="name" value="{{ $project->name }}" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold text-gray-900 focus:ring-2 focus:ring-[#DD3517]/20 focus:border-[#DD3517]" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Klien</label>
                        <select name="client_id" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold text-gray-900" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Map Picker Section dengan Fitur Search --}}
                <div class="bg-gray-50 rounded-[2rem] p-6 mb-8 border border-gray-100">
                    <div class="grid lg:grid-cols-3 gap-8">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Cari Kota / Lokasi</label>
                                <div class="relative">
                                    {{-- Input Search (Gunakan name="location" agar nama kota tersimpan) --}}
                                    <input type="text" id="citySearch" name="location" value="{{ $project->location }}" placeholder="Ketik nama kota..." 
                                           class="w-full bg-white border-gray-100 rounded-xl py-3 px-4 pr-16 text-sm font-bold focus:ring-2 focus:ring-[#DD3517]/20">
                                    <button type="button" onclick="searchCity()" 
                                            class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-gray-900 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-[#DD3517] transition-all">
                                        Cari
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[9px] font-black text-gray-400 uppercase">Lat</label>
                                    <input type="text" name="latitude" id="latInput" value="{{ $project->latitude }}" readonly class="w-full bg-white border-none rounded-lg py-2 px-3 text-[10px] font-mono font-bold text-gray-500">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-gray-400 uppercase">Lng</label>
                                    <input type="text" name="longitude" id="lngInput" value="{{ $project->longitude }}" readonly class="w-full bg-white border-none rounded-lg py-2 px-3 text-[10px] font-mono font-bold text-gray-500">
                                </div>
                            </div>
                            <p class="text-[9px] text-gray-400 italic leading-relaxed">Ketik nama kota lalu klik cari, atau klik langsung pada peta untuk titik presisi.</p>
                        </div>
                        <div class="lg:col-span-2">
                            <div id="mapPicker" class="h-64 rounded-2xl border border-white shadow-sm z-10"></div>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Proyek</label>
                        <select name="status" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold">
                            <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                            <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>COMPLETED</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Penyelesaian (%)</label>
                        <div class="flex items-center space-x-4 h-full pt-2">
                            <input type="number" name="progress_percentage" value="{{ $project->progress_percentage }}" class="w-20 bg-gray-50 border-gray-100 rounded-xl py-2 px-3 font-black text-center">
                            <div class="flex-1 bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-[#DD3517] h-full" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-8 border-t border-gray-50">
                    <a href="{{ route('admin.projects.index') }}" class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-all">Batal</a>
                    <button type="submit" :disabled="loading" class="px-12 py-4 bg-[#DD3517] text-white text-[10px] font-black rounded-2xl hover:bg-gray-900 transition-all transform hover:-translate-y-1 shadow-xl uppercase tracking-widest">
                        <span x-text="loading ? 'Updating...' : 'Update Data Proyek'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var map, marker;
    document.addEventListener('DOMContentLoaded', function() {
        var startLat = {{ $project->latitude ?? -2.5489 }};
        var startLng = {{ $project->longitude ?? 118.0149 }};
        var startZoom = {{ $project->latitude ? 15 : 5 }};

        map = L.map('mapPicker').setView([startLat, startLng], startZoom);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);

        if({{ $project->latitude ? 'true' : 'false' }}) {
            marker = L.marker([startLat, startLng]).addTo(map);
        }

        map.on('click', function(e) {
            updateMarker(e.latlng.lat, e.latlng.lng);
        });
    });

    // FUNGSI PENCARIAN OTOMATIS (INI YANG KURANG)
    async function searchCity() {
        const query = document.getElementById('citySearch').value;
        if (!query) return alert('Masukkan nama kota!');

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&countrycodes=id`);
            const data = await response.json();

            if (data.length > 0) {
                const lat = data[0].lat;
                const lon = data[0].lon;

                map.flyTo([lat, lon], 13);
                updateMarker(lat, lon);
            } else {
                alert("Lokasi tidak ditemukan di Indonesia.");
            }
        } catch (error) {
            console.error("Error geocoding:", error);
        }
    }

    function updateMarker(lat, lng) {
        if (marker) marker.setLatLng([lat, lng]);
        else marker = L.marker([lat, lng]).addTo(map);
        
        document.getElementById('latInput').value = parseFloat(lat).toFixed(8);
        document.getElementById('lngInput').value = parseFloat(lng).toFixed(8);
    }
</script>
@endsection