

<?php $__env->startSection('title', 'Detail Laporan - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Detail Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Laporan</h3>
            <a href="<?php echo e(route('admin.daily-reports.index')); ?>" 
               class="inline-flex items-center text-sm text-gray-600 hover:text-[#DD3517] transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
        
        <div class="p-6">
            
            
            <div class="mb-8 p-5 rounded-xl border border-gray-200 bg-gray-50/50 shadow-sm">
                
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-xs font-semibold text-[#DD3517] uppercase tracking-wider mb-1">Nama Proyek</p>
                    <h2 class="text-2xl font-bold text-gray-900"><?php echo e($dailyReport->project->name); ?></h2>
                    <div class="flex items-center mt-1 text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <?php echo e($dailyReport->project->location ?? 'Lokasi belum ditentukan'); ?>

                    </div>
                </div>

                
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Klien / Pemilik Proyek</p>
                    <div class="flex items-center">
                        <div class="w-9 h-9 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-3 shadow-sm">
                            <svg class="w-4 h-4 text-[#DD3517]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800 text-lg"><?php echo e($dailyReport->client->name ?? 'Klien tidak terdaftar'); ?></span>
                    </div>
                </div>
            </div>
            
            
            <div class="grid md:grid-cols-2 gap-6 mb-6 px-2">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Tanggal Laporan</p>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium text-gray-900"><?php echo e($dailyReport->report_date->format('d M Y')); ?></span>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Kondisi Cuaca</p>
                    <?php
                        $weatherConfig = [
                            'sunny' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Cerah'],
                            'cloudy' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', 'label' => 'Berawan'],
                            'rainy' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'M20 16.2A4.5 4.5 0 0017.5 8h-1.832A4.996 4.996 0 0011 4.5a5.002 5.002 0 00-4.9 4.005A4.5 4.5 0 003 16.2c-.6.1-1 .6-1 1.2v.1a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-.1c0-.6-.4-1.1-1-1.2zM8 19v2m4-2v2m4-2v2', 'label' => 'Hujan'],
                            'storm' => ['class' => 'bg-purple-100 text-purple-800', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'Badai'],
                        ];
                        $config = $weatherConfig[$dailyReport->weather_condition] ?? $weatherConfig['sunny'];
                    ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($config['class']); ?>">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($config['icon']); ?>"/>
                        </svg>
                        <?php echo e($config['label']); ?>

                    </span>
                </div>
            </div>
            
            <div class="pt-6 border-t border-gray-100 px-2">
                <p class="text-sm text-gray-500 mb-2">Deskripsi Aktivitas</p>
                <p class="text-gray-700 leading-relaxed"><?php echo e($dailyReport->activity_description); ?></p>
            </div>

            <?php if($dailyReport->photo): ?>
            <div class="pt-6 mt-6 border-t border-gray-100 px-2">
                <p class="text-sm text-gray-500 mb-3">Dokumentasi Laporan</p>
                <div class="inline-block bg-white rounded-lg border border-gray-200 p-1 shadow-sm max-w-full">
                    <img src="<?php echo e(asset('storage/' . $dailyReport->photo)); ?>" 
                         alt="Dokumentasi aktivitas" 
                         class="max-w-full h-auto rounded-md object-contain">
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIP\sinom-jatimas\resources\views/admin/daily-reports/show.blade.php ENDPATH**/ ?>