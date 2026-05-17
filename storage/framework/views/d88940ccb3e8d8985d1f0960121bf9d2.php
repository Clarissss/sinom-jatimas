<?php $__env->startSection('title', 'Detail Laporan - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Detail Laporan'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="max-w-2xl mx-auto space-y-4 animate-fade-in pb-10">
    
    
    <?php if(!$dailyReport->is_accepted): ?>
        <div class="bg-gradient-to-r from-[#DD3517] to-[#b8260d] rounded-3xl p-6 text-white shadow-xl shadow-red-100 flex items-start space-x-4 relative overflow-hidden">
            <div class="absolute right-0 bottom-0 translate-x-4 translate-y-4 opacity-10 text-9xl">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0 backdrop-blur-sm shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-white text-sm animate-pulse"></i>
            </div>
            <div class="space-y-1 relative z-10">
                <h4 class="text-xs font-black uppercase tracking-widest text-red-100 leading-none">Pengingat Penting</h4>
                <p class="text-sm font-bold tracking-tight leading-snug">
                    Mohon periksa detail pengerjaan di bawah ini. Jika sesuai, tekan tombol <span class="underline decoration-white font-black uppercase tracking-tighter">Terima Laporan</span> di kanan atas untuk kelancaran proyek.
                </p>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">
                Informasi Laporan
            </h3>

            <div class="flex items-center space-x-3">
                <?php if(!$dailyReport->is_accepted): ?>
                    <form action="<?php echo e(route('client.daily-reports.accept', $dailyReport)); ?>" method="POST" onsubmit="return confirm('Konfirmasi terima laporan ini?');">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="inline-flex items-center text-[10px] font-black bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl uppercase tracking-wider transition-all shadow-md">
                            <i class="fa-solid fa-check mr-1.5"></i> Terima Laporan
                        </button>
                    </form>
                <?php else: ?>
                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-black px-4 py-2 rounded-xl flex items-center shadow-sm uppercase tracking-wider">
                        <i class="fa-solid fa-circle-check mr-1.5"></i> Laporan Diterima
                    </span>
                <?php endif; ?>

                <a href="<?php echo e(route('client.daily-reports.index')); ?>"
                   class="w-10 h-10 flex items-center justify-center bg-gray-100 text-gray-400 hover:text-[#DD3517] rounded-xl transition-all"
                   title="Kembali ke Daftar">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
            </div>
        </div>

        <div class="p-8">
            
            <div class="mb-8 p-6 rounded-[2rem] border border-gray-100 bg-gray-50/50 shadow-inner">
                <div class="mb-4 pb-4 border-b border-gray-100">
                    <p class="text-[10px] font-black text-[#DD3517] uppercase tracking-widest mb-1">
                        Nama Proyek
                    </p>

                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">
                        <?php echo e($dailyReport->project->name); ?>

                    </h2>

                    <div class="flex items-center mt-1 text-xs text-gray-400 font-bold uppercase tracking-wide">
                        <i class="fa-solid fa-location-dot mr-1.5 text-gray-300"></i>
                        <?php echo e($dailyReport->project->location ?? 'Lokasi belum ditentukan'); ?>

                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">
                        Klien / Pemilik Proyek
                    </p>

                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-xl bg-white border border-gray-100 flex items-center justify-center mr-3 shadow-sm text-[#DD3517]">
                            <i class="fa-solid fa-user-tie text-xs"></i>
                        </div>

                        <span class="font-black text-gray-800 uppercase text-xs tracking-wider">
                            <?php echo e($dailyReport->client->name ?? 'Klien tidak terdaftar'); ?>

                        </span>
                    </div>
                </div>
            </div>

            
            <div class="grid md:grid-cols-2 gap-6 mb-8 px-2">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">
                        Tanggal Laporan
                    </p>

                    <div class="flex items-center text-sm font-black text-gray-900 tracking-tight">
                        <i class="fa-solid fa-calendar-day mr-2 text-gray-300"></i>
                        <span><?php echo e($dailyReport->report_date->format('d M Y')); ?></span>
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">
                        Kondisi Cuaca
                    </p>

                    <?php
                        $weatherConfig = [
                            'sunny' => ['class' => 'bg-orange-50 text-orange-600 border-orange-100', 'icon' => 'fa-sun', 'label' => 'Cerah'],
                            'cloudy' => ['class' => 'bg-gray-100 text-gray-600 border-gray-200', 'icon' => 'fa-cloud', 'label' => 'Berawan'],
                            'rainy' => ['class' => 'bg-blue-50 text-blue-600 border-blue-100', 'icon' => 'fa-cloud-showers-heavy', 'label' => 'Hujan'],
                            'storm' => ['class' => 'bg-purple-50 text-purple-600 border-purple-100', 'icon' => 'fa-bolt', 'label' => 'Badai'],
                        ];
                        $config = $weatherConfig[$dailyReport->weather_condition] ?? $weatherConfig['sunny'];
                    ?>

                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border <?php echo e($config['class']); ?>">
                        <i class="fa-solid <?php echo e($config['icon']); ?> mr-1.5 text-xs"></i>
                        <?php echo e($config['label']); ?>

                    </span>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 px-2">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">
                    Deskripsi Aktivitas Lapangan
                </p>

                <p class="text-sm text-gray-700 font-medium leading-relaxed bg-gray-50/50 p-5 rounded-2xl border border-gray-50 shadow-inner">
                    <?php echo e($dailyReport->activity_description); ?>

                </p>
            </div>

            
            <?php if($dailyReport->photo): ?>
                <div class="pt-6 mt-6 border-t border-gray-50 px-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">
                        Dokumentasi Aktivitas (Foto Lapangan)
                    </p>

                    <?php
                        // Pecah data gabungan teks string menjadi array berkas
                        $photos = explode(',', $dailyReport->photo);
                    ?>

                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 justify-center items-center">
                        <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="w-full flex justify-center bg-gray-50/30 rounded-2xl border border-gray-100 p-2 shadow-md overflow-hidden">
                                <img
                                    src="<?php echo e(asset('storage/' . trim($photo))); ?>"
                                    alt="Dokumentasi aktivitas"
                                    class="max-w-full h-auto rounded-xl object-contain max-h-[300px] transition-transform hover:scale-[1.02] duration-300">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/client/daily-reports/show.blade.php ENDPATH**/ ?>