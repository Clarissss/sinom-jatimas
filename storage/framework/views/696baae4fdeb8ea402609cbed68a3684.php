<?php $__env->startSection('title', 'Laporan Harian - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Laporan Harian'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-control { 
        border-radius: 0.75rem !important; 
        padding: 0.6rem 0.75rem !important; 
        border-color: #f3f4f6 !important;
        background-color: #f9fafb !important;
        font-size: 0.875rem !important;
    }
    .ts-wrapper.focus .ts-control { 
        border-color: #DD3517 !important; 
        box-shadow: 0 0 0 2px rgba(221, 53, 23, 0.1) !important; 
    }
</style>

<div class="space-y-6 animate-fade-in pb-10">
    
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Laporan Harian</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Monitoring aktivitas pengerjaan lapangan harian.</p>
        </div>
        <a href="<?php echo e(route('admin.daily-reports.create')); ?>" 
           class="inline-flex items-center justify-center px-8 py-3 bg-gray-900 text-white text-[10px] font-black rounded-2xl hover:bg-[#DD3517] transition-all transform hover:-translate-y-1 active:scale-[0.98] shadow-xl uppercase tracking-widest">
            <i class="fas fa-plus mr-2"></i> Buat Laporan Baru
        </a>
    </div>

    
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100"
         x-data="{
            init() {
                new TomSelect('#filter_client', { plugins: ['clear_button'] });
                new TomSelect('#filter_project', { plugins: ['clear_button'] });
            }
         }">
        <form action="<?php echo e(route('admin.daily-reports.index')); ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 items-end">
            
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Klien</label>
                <select name="client_id" id="filter_client" placeholder="Cari Klien...">
                    <option value="">Semua Klien</option>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>><?php echo e($client->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Proyek</label>
                <select name="project_id" id="filter_project" placeholder="Cari Proyek...">
                    <option value="">Semua Proyek</option>
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($project->id); ?>" <?php echo e(request('project_id') == $project->id ? 'selected' : ''); ?>><?php echo e($project->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Tanggal</label>
                <input type="date" name="date" value="<?php echo e(request('date')); ?>" class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm h-[46px] font-bold focus:ring-[#DD3517] focus:border-[#DD3517] transition-all">
            </div>

            
            <div class="flex space-x-2 h-[46px]">
                <button type="submit" class="flex-1 bg-gray-900 text-white rounded-xl hover:bg-black text-[10px] font-black uppercase tracking-widest transition-all shadow-md">
                    <i class="fas fa-filter mr-1 text-[8px]"></i> Terapkan
                </button>
                <?php if(request()->anyFilled(['client_id', 'project_id', 'date'])): ?>
                    <a href="<?php echo e(route('admin.daily-reports.index')); ?>" class="w-14 inline-flex items-center justify-center bg-gray-100 text-gray-400 rounded-xl hover:bg-gray-200 transition-all shadow-sm">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Proyek & Klien</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Aktivitas</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Cuaca</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Foto</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <p class="font-black text-gray-900 text-sm leading-none mb-1"><?php echo e($report->report_date->format('d M Y')); ?></p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest italic">Oleh: <?php echo e($report->creator->name ?? 'System'); ?></p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm font-black text-gray-900 leading-none uppercase tracking-tighter"><?php echo e($report->project->name); ?></p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 italic"><?php echo e($report->client->name); ?></p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs text-gray-600 line-clamp-2 max-w-xs font-medium"><?php echo e($report->activity_description); ?></p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <?php
                                    $weatherMap = [
                                        'sunny' => ['icon' => 'fa-sun', 'color' => 'text-orange-500', 'label' => 'CERAH'],
                                        'cloudy' => ['icon' => 'fa-cloud', 'color' => 'text-gray-400', 'label' => 'BERAWAN'],
                                        'rainy' => ['icon' => 'fa-cloud-showers-heavy', 'color' => 'text-blue-500', 'label' => 'HUJAN'],
                                        'storm' => ['icon' => 'fa-bolt', 'color' => 'text-purple-600', 'label' => 'BADAI'],
                                    ];
                                    $w = $weatherMap[$report->weather_condition] ?? $weatherMap['sunny'];
                                ?>
                                <div class="<?php echo e($w['color']); ?> flex flex-col items-center">
                                    <i class="fa-solid <?php echo e($w['icon']); ?> text-sm mb-1"></i>
                                    <span class="text-[8px] font-black"><?php echo e($w['label']); ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <?php if($report->photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $report->photo)); ?>" class="w-10 h-10 rounded-xl object-cover border border-gray-100 shadow-sm mx-auto">
                                <?php else: ?>
                                    <i class="fa-solid fa-image text-gray-200"></i>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?php echo e(route('admin.daily-reports.show', $report)); ?>" class="p-2 bg-gray-50 text-gray-400 hover:text-blue-600 rounded-xl transition-all"><i class="fa-solid fa-eye"></i></a>
                                    <a href="<?php echo e(route('admin.daily-reports.edit', $report)); ?>" class="p-2 bg-gray-50 text-gray-400 hover:text-yellow-600 rounded-xl transition-all"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="<?php echo e(route('admin.daily-reports.destroy', $report)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus laporan ini?');">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-2 bg-gray-50 text-gray-400 hover:text-red-600 rounded-xl transition-all"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-clipboard-list text-4xl text-gray-100 mb-4"></i>
                                    <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">Laporan belum tersedia</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($reports->hasPages()): ?>
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
                <?php echo e($reports->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/daily-reports/index.blade.php ENDPATH**/ ?>