<?php $__env->startSection('title', $project->name . ' - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Detail Proyek'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 animate-fade-in">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900"><?php echo e($project->name); ?></h2>
                    <div class="flex items-center text-gray-500 mt-2">
                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span><?php echo e($project->location ?? 'Lokasi belum ditentukan'); ?></span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <?php
                        $statusConfig = [
                            'in_progress' => ['class' => 'bg-green-100 text-green-800', 'label' => 'Aktif', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            'completed' => ['class' => 'bg-blue-100 text-blue-800', 'label' => 'Selesai', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'label' => 'Pending', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'cancelled' => ['class' => 'bg-gray-100 text-gray-800', 'label' => 'Dibatalkan', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                        $config = $statusConfig[$project->status] ?? $statusConfig['pending'];
                    ?>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e($config['class']); ?>">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($config['icon']); ?>"/>
                        </svg>
                        <?php echo e($config['label']); ?>

                    </span>
                    <a href="<?php echo e(route('chat.index', $project)); ?>" 
                       class="inline-flex items-center px-4 py-1.5 bg-secondary-600 text-white rounded-lg text-sm font-medium hover:bg-secondary-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Chat
                    </a>
                </div>
            </div>
            
            
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress Proyek</span>
                    <span class="text-lg font-bold text-primary-600"><?php echo e($project->progress_percentage); ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-3 rounded-full transition-all duration-500" style="width: <?php echo e($project->progress_percentage); ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid md:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Foto Progress</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($project->progressPhotos->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Dokumen</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($project->documents->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Invoice</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($project->invoices->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Proyek</h3>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <dl class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Klien</dt>
                            <dd class="text-sm font-medium text-gray-900"><?php echo e($project->client->name); ?></dd>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Tanggal Mulai</dt>
                            <dd class="text-sm font-medium text-gray-900"><?php echo e($project->start_date ? $project->start_date->format('d M Y') : '-'); ?></dd>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Tanggal Selesai</dt>
                            <dd class="text-sm font-medium text-gray-900"><?php echo e($project->end_date ? $project->end_date->format('d M Y') : '-'); ?></dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <dl class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Nilai Kontrak</dt>
                            <dd class="text-sm font-medium text-gray-900"><?php echo e($project->contract_value ? 'Rp ' . number_format($project->contract_value, 0, ',', '.') : '-'); ?></dd>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Status</dt>
                            <dd class="text-sm font-medium text-gray-900"><?php echo e($config['label']); ?></dd>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-500">Progress</dt>
                            <dd class="text-sm font-medium text-primary-600"><?php echo e($project->progress_percentage); ?>%</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <?php if($project->description): ?>
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h4>
                    <p class="text-sm text-gray-600 leading-relaxed"><?php echo e($project->description); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/client/projects/show.blade.php ENDPATH**/ ?>