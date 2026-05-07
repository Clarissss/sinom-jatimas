<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="max-w-5xl mx-auto pb-10">
    <form action="<?php echo e(route('admin.projects.store')); ?>" method="POST" x-data="{ loading: false }" @submit="loading = true">
        <?php echo csrf_field(); ?>
        
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm space-y-8">
            
            <div class="border-b border-gray-50 pb-6">
                <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Tambah Proyek Baru</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Proyek</label>
                    <input type="text" name="name" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold" required>
                </div>

                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Klien</label>
                    <select name="client_id" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold" required>
                        <option value="">Pilih Klien</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            
            <div class="bg-gray-50 rounded-[2rem] p-6 border border-gray-100">
                <div class="grid lg:grid-cols-3 gap-8">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Nama Kota / Lokasi</label>
                            <div class="relative">
                                
                                <input type="text" id="citySearch" name="location" placeholder="Ketik nama kota..." 
                                       class="w-full bg-white border-gray-100 rounded-xl py-3 px-4 font-bold text-sm">
                                <button type="button" onclick="searchCity()" 
                                        class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-gray-900 text-white rounded-lg text-[9px] font-black uppercase tracking-widest">Cari</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase">Latitude</label>
                                <input type="text" name="latitude" id="latInput" readonly class="w-full bg-white border-none rounded-lg py-2 px-3 text-[10px] font-mono font-bold text-gray-400">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase">Longitude</label>
                                <input type="text" name="longitude" id="lngInput" readonly class="w-full bg-white border-none rounded-lg py-2 px-3 text-[10px] font-mono font-bold text-gray-400">
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-2">
                        <div id="mapPicker" class="h-64 rounded-2xl border border-white shadow-sm z-10"></div>
                    </div>
                </div>
            </div>

            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</label>
                    <select name="status" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold">
                        <option value="pending">PENDING</option>
                        <option value="in_progress">IN PROGRESS</option>
                        <option value="completed">COMPLETED</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Progress (%)</label>
                    <input type="number" name="progress_percentage" value="0" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nilai Kontrak</label>
                    <input type="number" name="contract_value" class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-6 font-bold">
                </div>
            </div>

            
            <div class="flex justify-end pt-6">
                <button type="submit" :disabled="loading" 
                        class="px-12 py-4 bg-gray-900 text-white text-[10px] font-black rounded-2xl hover:bg-[#DD3517] transition-all uppercase tracking-widest">
                    <span x-text="loading ? 'Menyimpan...' : 'Simpan Proyek'"></span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    var map, marker;
    document.addEventListener('DOMContentLoaded', function() {
        map = L.map('mapPicker').setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);
        map.on('click', function(e) { updateMarker(e.latlng.lat, e.latlng.lng); });
    });

    async function searchCity() {
        const query = document.getElementById('citySearch').value;
        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&countrycodes=id`);
        const data = await res.json();
        if (data.length > 0) {
            const lat = data[0].lat, lon = data[0].lon;
            map.flyTo([lat, lon], 12);
            updateMarker(lat, lon);
        }
    }

    function updateMarker(lat, lng) {
        if (marker) marker.setLatLng([lat, lng]);
        else marker = L.marker([lat, lng]).addTo(map);
        document.getElementById('latInput').value = parseFloat(lat).toFixed(8);
        document.getElementById('lngInput').value = parseFloat(lng).toFixed(8);
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/projects/create.blade.php ENDPATH**/ ?>