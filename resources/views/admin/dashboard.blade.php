@extends('layouts.app')

@section('title', 'Admin Dashboard - PT. Sinom Jati Mas')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    #projectMap { height: 500px; width: 100%; border-radius: 2.5rem; z-index: 1; }
    .leaflet-container { font-family: inherit; background: #f8fafc; }
    .custom-popup .leaflet-popup-content-wrapper { border-radius: 1.5rem; padding: 5px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
</style>

<div class="space-y-6 animate-fade-in pb-10">
    
    {{-- Header --}}
    <div class="flex justify-between items-end px-2">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Dashboard</h2>
            <p class="text-sm text-gray-500 font-medium mt-2">Monitoring operasional nasional PT. Sinom Jati Mas.</p>
        </div>
        <div class="text-right hidden md:block border-l-2 border-gray-100 pl-6">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Update Terakhir</p>
            <p class="text-xs font-bold text-gray-900 uppercase tracking-tighter">{{ now()->translatedFormat('d F Y, H:i') }}</p>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pendapatan Proyek Selesai</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600"><i class="fa-solid fa-money-bill-trend-up text-xl"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Proyek</p>
                    <p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['total_projects'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-[#FF812E]"><i class="fa-solid fa-helmet-safety text-xl"></i></div>
            </div>
            <div class="mt-4 flex items-center text-[10px] font-black uppercase tracking-tighter">
                <span class="text-[#FF812E]">{{ $stats['active_projects'] }} Aktif</span>
                <span class="text-gray-200 mx-2">|</span>
                <span class="text-gray-400">{{ $stats['completed_projects'] }} Selesai</span>
            </div>
        </div>
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Database Klien</p><p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['total_clients'] }}</p></div>
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600"><i class="fa-solid fa-users text-xl"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-[2rem] shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tagihan Terkirim</p><p class="text-2xl font-black text-gray-900 mt-1">{{ $stats['pending_invoices'] }}</p></div>
                <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600"><i class="fa-solid fa-file-invoice-dollar text-xl"></i></div>
            </div>
        </div>
    </div>

    {{-- PETA NASIONAL --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-[0.2em]">Sebaran Proyek Indonesia</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 italic">Titik operasional pengerjaan lapangan</p>
            </div>
            <div class="flex space-x-4">
                <div class="flex items-center text-[9px] font-black uppercase text-gray-400"><span class="w-2 h-2 rounded-full bg-[#FF812E] mr-2"></span> Aktif</div>
                <div class="flex items-center text-[9px] font-black uppercase text-gray-400"><span class="w-2 h-2 rounded-full bg-[#10B981] mr-2"></span> Selesai</div>
            </div>
        </div>
        <div id="projectMap" class="bg-gray-50 border border-gray-50"></div>
    </div>

    {{-- ANALYTICS GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Tren Arus Kas Selesai</h3>
                <div class="text-[10px] font-black text-[#DD3517] uppercase tracking-widest underline decoration-2 underline-offset-4">6 Bulan Terakhir</div>
            </div>
            <div class="h-[300px]"><canvas id="revenueChart"></canvas></div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm text-center">
            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-8">Status Proyek</h3>
            <div class="h-[250px] relative"><canvas id="projectChart"></canvas></div>
            <div class="mt-6 space-y-3">
                <div class="flex justify-between text-[10px] font-black uppercase"><span class="text-gray-400 tracking-widest">Penyelesaian</span><span class="text-gray-900">{{ $stats['completed_projects'] }} / {{ $stats['total_projects'] }}</span></div>
                <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden"><div class="bg-emerald-500 h-full" style="width: {{ $stats['total_projects'] > 0 ? ($stats['completed_projects']/$stats['total_projects'])*100 : 0 }}%"></div></div>
            </div>
        </div>
    </div>

    {{-- TABLES --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Aktivitas Proyek</h3>
                <a href="{{ route('admin.projects.index') }}" class="text-[9px] font-black text-[#DD3517] uppercase tracking-widest">View All</a>
            </div>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-gray-50">
                    @foreach($recent_projects as $project)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-4"><p class="font-black text-gray-900 uppercase tracking-tight">{{ $project->name }}</p><p class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">{{ $project->client->name }}</p></td>
                        <td class="px-8 py-4 text-right"><span class="font-black text-gray-900">{{ $project->progress_percentage }}%</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Log Penagihan</h3>
                <a href="{{ route('admin.invoices.index') }}" class="text-[9px] font-black text-[#DD3517] uppercase tracking-widest">View All</a>
            </div>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-gray-50">
                    @foreach($recent_invoices as $invoice)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-4 font-black text-gray-900">{{ $invoice->invoice_number }}</td>
                        <td class="px-8 py-4 font-black text-gray-700 tracking-tighter text-sm">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                        <td class="px-8 py-4 text-right"><span class="px-3 py-1 bg-gray-100 rounded text-[8px] font-black uppercase text-gray-400 border border-gray-200">{{ $invoice->status_label }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. INISIALISASI PETA ---
        var map = L.map('projectMap', { scrollWheelZoom: false }).setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { 
            attribution: 'PT. Sinom Jati Mas' 
        }).addTo(map);

        var projects = {!! json_encode($projects_for_map) !!};
        
        // --- 2. LOGIKA PENGELOMPOKAN KOORDINAT ---
        // Kita gunakan objek untuk menyimpan proyek berdasarkan "lat,lng" sebagai key
        var groupedProjects = {};

        projects.forEach(function(p) {
            var key = p.latitude + ',' + p.longitude;
            if (!groupedProjects[key]) {
                groupedProjects[key] = [];
            }
            groupedProjects[key].push(p);
        });

        // --- 3. RENDERING MARKER ---
        for (var key in groupedProjects) {
            var items = groupedProjects[key];
            var firstItem = items[0];
            var coords = key.split(',');

            // Tentukan warna marker: jika ada salah satu yang 'in_progress', beri warna oranye. 
            // Jika semua selesai, beri warna hijau.
            var hasActive = items.some(i => i.status === 'in_progress');
            var color = hasActive ? '#FF812E' : '#10B981';

            // Susun HTML untuk Pop-up (Menampilkan semua proyek di lokasi ini)
            var popupContent = `<div class="custom-popup space-y-3 p-1 min-w-[200px]">
                <div class="border-b border-gray-100 pb-2 mb-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Titik Lokasi</p>
                    <p class="text-xs font-bold text-gray-900">${items.length} Proyek Ditemukan</p>
                </div>
                <div class="max-h-[200px] overflow-y-auto space-y-4">`;

            items.forEach(function(item) {
                var statusColor = item.status === 'completed' ? 'text-emerald-500' : 'text-[#FF812E]';
                popupContent += `
                    <div class="border-l-2 border-gray-100 pl-3">
                        <p class="text-[8px] font-black text-gray-300 uppercase leading-none mb-1">#SJM-${item.id}</p>
                        <h4 class="font-black text-gray-900 uppercase text-[11px] leading-tight mb-1">${item.name}</h4>
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-bold text-gray-500 italic">${item.progress_percentage}% Done</span>
                            <span class="text-[9px] font-black uppercase ${statusColor}">${item.status}</span>
                        </div>
                    </div>`;
            });

            popupContent += `</div></div>`;

            // Buat satu marker untuk koordinat ini
            L.circleMarker([coords[0], coords[1]], {
                radius: 12, // Sedikit lebih besar karena bisa menampung banyak data
                fillColor: color,
                color: "#fff",
                weight: 3,
                opacity: 1,
                fillOpacity: 0.9
            })
            .addTo(map)
            .bindPopup(popupContent);
        }

        // --- 4. REVENUE CHART (Tetap Sama) ---
        const revCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenue_data->pluck('month')) !!},
                datasets: [{
                    label: 'Revenue', 
                    data: {!! json_encode($revenue_data->pluck('total')) !!},
                    borderColor: '#DD3517', 
                    backgroundColor: 'rgba(221, 53, 23, 0.05)', 
                    borderWidth: 4, 
                    fill: true, 
                    tension: 0.4, 
                    pointRadius: 5
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } }, 
                scales: { 
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' }, border: { display: false } }, 
                    x: { grid: { display: false }, border: { display: false } } 
                } 
            }
        });

        // --- 5. PROJECT CHART (Tetap Sama) ---
        const projCtx = document.getElementById('projectChart').getContext('2d');
        new Chart(projCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Active', 'Completed'],
                datasets: [{
                    data: {!! json_encode($project_distribution) !!},
                    backgroundColor: ['#f3f4f6', '#FF812E', '#10B981'], 
                    borderWidth: 0
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                cutout: '80%', 
                plugins: { 
                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { weight: 'bold', size: 10 } } } 
                } 
            }
        });
    });
</script>
@endsection