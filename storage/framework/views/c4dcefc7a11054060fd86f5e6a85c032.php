<?php $__env->startSection('title', $project->name . ' - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Detail Proyek'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 animate-fade-in" x-data="{ activeTab: 'overview' }">
    
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
                            'in_progress' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'Aktif'],
                            'completed' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Selesai'],
                            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Pending'],
                            'cancelled' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Dibatalkan'],
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
                    <span class="text-lg font-bold text-primary-600" id="progress-text"><?php echo e($project->progress_percentage); ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="progress-bar" class="bg-gradient-to-r from-primary-500 to-secondary-500 h-3 rounded-full transition-all duration-500" style="width: <?php echo e($project->progress_percentage); ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                        class="py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Overview
                </button>
                <button @click="activeTab = 'progress'" 
                        :class="activeTab === 'progress' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                        class="py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Foto Progress
                </button>
                <button @click="activeTab = 'documents'" 
                        :class="activeTab === 'documents' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                        class="py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Dokumen
                </button>
                <button @click="activeTab = 'invoices'" 
                        :class="activeTab === 'invoices' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                        class="py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                    Invoice
                </button>
            </nav>
        </div>

        <div class="p-6">
            
            <div x-show="activeTab === 'overview'" class="space-y-6" x-cloak>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Proyek</h3>
                        <dl class="space-y-3">
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
                            <div class="flex justify-between py-3 border-b border-gray-100">
                                <dt class="text-sm text-gray-500">Nilai Kontrak</dt>
                                <dd class="text-sm font-medium text-gray-900"><?php echo e($project->contract_value ? 'Rp ' . number_format($project->contract_value, 0, ',', '.') : '-'); ?></dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Progress</h3>
                        <form action="<?php echo e(route('admin.projects.progress.update', $project)); ?>" method="POST" class="bg-gray-50 p-4 rounded-lg">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Persentase Progress</label>
                                <input type="range" 
                                       name="progress_percentage" 
                                       min="0" 
                                       max="100" 
                                       value="<?php echo e($project->progress_percentage); ?>" 
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary-600"
                                       oninput="document.getElementById('progress-preview').textContent = this.value + '%'">
                                <div class="text-center mt-2">
                                    <span id="progress-preview" class="text-lg font-bold text-primary-600"><?php echo e($project->progress_percentage); ?>%</span>
                                </div>
                            </div>
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Update Progress
                            </button>
                        </form>
                    </div>
                </div>

                <?php if($project->description): ?>
                    <div class="pt-6 border-t border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed"><?php echo e($project->description); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            
            <div x-show="activeTab === 'progress'" class="space-y-6" x-cloak>
                <form action="<?php echo e(route('admin.projects.progress.store', $project)); ?>" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded-lg">
                    <?php echo csrf_field(); ?>
                    <h4 class="font-medium text-gray-900 mb-4">Upload Foto Progress</h4>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Foto</label>
                            <select name="type" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                <option value="before">Before</option>
                                <option value="progress">Progress</option>
                                <option value="after">After</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Foto</label>
                            <input type="file" name="photo" accept="image/*" required class="w-full">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"></textarea>
                    </div>
                    <button type="submit" 
                            class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload
                    </button>
                </form>

                <div class="grid md:grid-cols-3 gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $project->progressPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                            <div class="h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">Foto Progress</span>
                            </div>
                            <div class="p-4">
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                    <?php if($photo->type === 'before'): ?> bg-gray-100 text-gray-800
                                    <?php elseif($photo->type === 'after'): ?> bg-green-100 text-green-800
                                    <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($photo->type)); ?>

                                </span>
                                <p class="text-sm text-gray-600 mt-2"><?php echo e($photo->description); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            <div class="bg-gray-100 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p>Belum ada foto progress</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div x-show="activeTab === 'documents'" class="space-y-6" x-cloak>
                <div class="text-center py-8 text-gray-500">
                    <div class="bg-gray-100 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p>Dokumen proyek akan ditampilkan di sini</p>
                </div>
            </div>

            
            <div x-show="activeTab === 'invoices'" class="space-y-6" x-cloak>
                <div class="text-center py-8 text-gray-500">
                    <div class="bg-gray-100 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                    </div>
                    <p>Invoice proyek akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sinom-portal-laravel\resources\views/admin/projects/show.blade.php ENDPATH**/ ?>