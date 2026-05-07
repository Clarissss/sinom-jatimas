<?php $__env->startSection('title', 'Client Dashboard - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Dashboard Klien'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 animate-fade-in">
    
    <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl p-6 text-white shadow-lg">
        <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?php echo e(auth()->user()->name); ?>!</h2>
        <p class="text-primary-100">Pantau progress proyek Anda secara real-time melalui portal ini.</p>
    </div>

    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100 hover:shadow-md transition-shadow">
            <div class="text-2xl font-bold text-primary-600"><?php echo e($stats['total_projects']); ?></div>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Total Proyek</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100 hover:shadow-md transition-shadow">
            <div class="text-2xl font-bold text-secondary-600"><?php echo e($stats['active_projects']); ?></div>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Sedang Berjalan</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100 hover:shadow-md transition-shadow">
            <div class="text-2xl font-bold text-green-600"><?php echo e($stats['completed_projects']); ?></div>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Selesai</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 text-center border border-gray-100 hover:shadow-md transition-shadow">
            <div class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending_invoices']); ?></div>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Invoice Pending</p>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Proyek Saya</h3>
        </div>
        
        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                    
                    <div class="flex-1 min-w-0">
                        
                        <h4 class="text-lg font-bold text-gray-900 mb-2"><?php echo e($project->name); ?></h4>
                        
                        
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="truncate"><?php echo e($project->location ?? 'Lokasi belum ditentukan'); ?></span>
                        </div>
                        
                        
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Progress Proyek</span>
                                <span class="text-sm font-bold text-primary-600"><?php echo e($project->progress_percentage); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-2.5 rounded-full transition-all duration-500" style="width: <?php echo e($project->progress_percentage); ?>%"></div>
                            </div>
                        </div>
                        
                        
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span><?php echo e($project->progressPhotos->count()); ?> Foto</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span><?php echo e($project->documents->count()); ?> Dokumen</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <span><?php echo e($project->invoices->count()); ?> Invoice</span>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="flex flex-row lg:flex-col gap-2 lg:min-w-[140px]">
                        <a href="<?php echo e(route('client.projects.show', $project)); ?>" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail
                        </a>
                        <a href="<?php echo e(route('chat.index', $project)); ?>" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-secondary-600 text-white text-sm font-medium rounded-lg hover:bg-secondary-700 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Chat
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-12 text-center">
                <div class="bg-gray-100 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h4 class="text-lg font-medium text-gray-900 mb-1">Anda belum memiliki proyek</h4>
                <p class="text-sm text-gray-500">Hubungi admin untuk informasi lebih lanjut</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/client/dashboard.blade.php ENDPATH**/ ?>