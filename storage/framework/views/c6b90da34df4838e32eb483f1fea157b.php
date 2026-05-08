

<?php $__env->startSection('title', $project->name . ' - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Detail Proyek'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6 animate-fade-in"
     x-data="{
    activeTab: 'overview',
    showProgressPreview: false
}">

    
    <div class="flex items-center justify-between">

        <div class="flex items-center gap-4">

            <a href="<?php echo e(route('client.dashboard')); ?>"
               class="w-11 h-11 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center text-gray-500 hover:text-[#DD3517] hover:border-[#DD3517]/20 transition-all">

                <i class="fa-solid fa-arrow-left"></i>

            </a>

            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em]">

                <a href="<?php echo e(route('client.dashboard')); ?>"
                   class="text-gray-400 hover:text-[#DD3517] transition-colors duration-300">

                    Dashboard

                </a>

                <span class="text-gray-300">/</span>

                <span class="text-gray-500">

                    Detail Proyek

                </span>

            </div>

        </div>

    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="p-6">

            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

                <div>

                    <h2 class="text-2xl font-bold text-gray-900">

                        <?php echo e($project->name); ?>


                    </h2>

                    <div class="flex items-center text-gray-500 mt-2">

                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                        </svg>

                        <span>

                            <?php echo e($project->location ?? 'Lokasi belum ditentukan'); ?>


                        </span>

                    </div>

                </div>

                
                <div class="flex flex-wrap gap-2">

                    <?php

                        $statusConfig = [

                            'in_progress' => [
                                'class' => 'bg-green-100 text-green-800',
                                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                                'label' => 'Aktif'
                            ],

                            'completed' => [
                                'class' => 'bg-blue-100 text-blue-800',
                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                'label' => 'Selesai'
                            ],

                            'pending' => [
                                'class' => 'bg-yellow-100 text-yellow-800',
                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                'label' => 'Pending'
                            ],

                            'cancelled' => [
                                'class' => 'bg-gray-100 text-gray-800',
                                'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                                'label' => 'Dibatalkan'
                            ],

                        ];

                        $config = $statusConfig[$project->status] ?? $statusConfig['pending'];

                    ?>

                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium <?php echo e($config['class']); ?>">

                        <svg class="w-4 h-4 mr-1.5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="<?php echo e($config['icon']); ?>"/>

                        </svg>

                        <?php echo e($config['label']); ?>


                    </span>

                    <a href="<?php echo e(route('chat.index', $project)); ?>"
                       class="inline-flex items-center px-4 py-1.5 bg-secondary-600 text-white rounded-lg text-sm font-medium hover:bg-secondary-700 transition-colors shadow-sm">

                        <svg class="w-4 h-4 mr-1.5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>

                        </svg>

                        Chat

                    </a>

                </div>

            </div>

            
<div class="relative">

    <div class="flex items-center justify-between mb-2">

        <span class="text-sm font-medium text-gray-700">

            Progress Proyek

        </span>

        <span class="text-lg font-bold text-primary-600">

            <?php echo e($project->progress_percentage); ?>%

        </span>

    </div>

    <button type="button"
            @mouseenter="showProgressPreview = true"
            @mouseleave="showProgressPreview = false"
            @click="activeTab = 'progress'"
            class="w-full group relative">

        
        <?php if($project->progressPhotos->count()): ?>

            <?php
                $latestPhoto = $project->progressPhotos->last();
            ?>

            <div x-show="showProgressPreview"
                 x-transition
                 class="absolute left-1/2 -translate-x-1/2 bottom-8 z-20 w-64 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">

                <div class="aspect-video overflow-hidden bg-gray-100">

                    <img src="<?php echo e(asset('storage/' . $latestPhoto->photo_path)); ?>"
                         class="w-full h-full object-cover">

                </div>

                <div class="p-4 text-left">

                    <div class="flex items-center justify-between mb-2">

                        <span class="text-xs font-bold uppercase tracking-wider text-primary-600">

                            Progress Terbaru

                        </span>

                        <span class="text-xs text-gray-400">

                            <?php echo e($project->progress_percentage); ?>%

                        </span>

                    </div>

                    <?php if($latestPhoto->description): ?>

                        <p class="text-sm text-gray-600 line-clamp-2">

                            <?php echo e($latestPhoto->description); ?>


                        </p>

                    <?php endif; ?>

                </div>

            </div>

        <?php endif; ?>

        
        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">

            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-3 rounded-full transition-all duration-500 group-hover:brightness-110"
                 style="width: <?php echo e($project->progress_percentage); ?>%">

            </div>

        </div>

    </button>

</div>

        </div>

    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        
        <div class="border-b border-gray-200">

            <nav class="flex -mb-px overflow-x-auto">

                <button @click="activeTab = 'overview'"
                        :class="activeTab === 'overview'
                            ? 'border-primary-500 text-primary-600 bg-primary-50'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">

                    Overview

                </button>

                <button @click="activeTab = 'progress'"
                        :class="activeTab === 'progress'
                            ? 'border-primary-500 text-primary-600 bg-primary-50'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">

                    Foto Progress

                </button>

                <button @click="activeTab = 'invoice'"
                        :class="activeTab === 'invoice'
                            ? 'border-primary-500 text-primary-600 bg-primary-50'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">

                    Invoice

                </button>

            </nav>

        </div>

        <div class="p-6">

            
            <div x-show="activeTab === 'overview'"
                 class="space-y-6"
                 x-cloak>

                <div class="grid md:grid-cols-2 gap-8">

                    <div>

                        <dl class="space-y-3">

                            <div class="flex justify-between py-2 border-b border-gray-100">

                                <dt class="text-sm text-gray-500">
                                    Klien
                                </dt>

                                <dd class="text-sm font-semibold text-gray-900">
                                    <?php echo e($project->client->name); ?>

                                </dd>

                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-100">

                                <dt class="text-sm text-gray-500">
                                    Nilai Kontrak
                                </dt>

                                <dd class="text-sm font-bold text-gray-900">
                                    Rp <?php echo e(number_format($project->contract_value, 0, ',', '.')); ?>

                                </dd>

                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-100 bg-blue-50/50 px-2 -mx-2 rounded">

                                <dt class="text-sm text-blue-600 font-medium">
                                    Total Ter-Invoice
                                </dt>

                                <dd class="text-sm font-bold text-blue-700">
                                    Rp <?php echo e(number_format($project->total_invoiced, 0, ',', '.')); ?>

                                </dd>

                            </div>

                            <div class="flex justify-between py-3 border-b border-gray-100 bg-red-50 px-2 -mx-2 rounded">

                                <dt class="text-sm text-red-600 font-bold uppercase tracking-tight">
                                    Sisa Pembayaran
                                </dt>

                                <dd class="text-base font-black text-red-700">
                                    Rp <?php echo e(number_format($project->remaining_payment, 0, ',', '.')); ?>

                                </dd>

                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-100">

                                <dt class="text-sm text-gray-500">
                                    Tanggal Mulai
                                </dt>

                                <dd class="text-sm font-medium text-gray-900">

                                    <?php echo e($project->start_date ? $project->start_date->format('d M Y') : '-'); ?>


                                </dd>

                            </div>

                            <div class="flex justify-between py-2 border-b border-gray-100">

                                <dt class="text-sm text-gray-500">
                                    Tanggal Selesai
                                </dt>

                                <dd class="text-sm font-medium text-gray-900">

                                    <?php echo e($project->end_date ? $project->end_date->format('d M Y') : '-'); ?>


                                </dd>

                            </div>

                        </dl>

                    </div>

                    <div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-4">

                            Deskripsi

                        </h3>

                        <p class="text-sm text-gray-600 leading-relaxed">

                            <?php echo e($project->description ?? 'Tidak ada deskripsi proyek.'); ?>


                        </p>

                    </div>

                </div>

            </div>

            
            <div x-show="activeTab === 'progress'"
                 class="space-y-6"
                 x-cloak>

                <div class="grid md:grid-cols-3 gap-4">

                    <?php $__empty_1 = true; $__currentLoopData = $project->progressPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200 hover:shadow-md transition-shadow">

                            <div class="aspect-[4/3] overflow-hidden bg-gray-100">

                                <img src="<?php echo e(asset('storage/' . $photo->photo_path)); ?>"
                                     alt="Foto Progress"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">

                            </div>

                            <div class="p-4">

                                <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                    <?php if($photo->type === 'before'): ?>
                                        bg-gray-100 text-gray-800
                                    <?php elseif($photo->type === 'after'): ?>
                                        bg-green-100 text-green-800
                                    <?php else: ?>
                                        bg-blue-100 text-blue-800
                                    <?php endif; ?>">

                                    <?php echo e(ucfirst($photo->type)); ?>


                                </span>

                                <?php if($photo->description): ?>

                                    <p class="text-sm text-gray-600 mt-2">

                                        <?php echo e($photo->description); ?>


                                    </p>

                                <?php endif; ?>

                            </div>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <div class="col-span-3 text-center py-10 text-gray-500">

                            <div class="bg-gray-100 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">

                                <i class="fa-solid fa-image text-3xl text-gray-300"></i>

                            </div>

                            <p>

                                Belum ada foto progress

                            </p>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

            
            <div x-show="activeTab === 'invoice'"
                 class="space-y-4"
                 x-cloak>

                <?php $__empty_1 = true; $__currentLoopData = $project->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 hover:shadow-sm transition-all">

                        <div class="flex items-center justify-between">

                            <div>

                                <h4 class="font-bold text-gray-900">

                                    <?php echo e($invoice->invoice_number); ?>


                                </h4>

                                <p class="text-sm text-gray-500 mt-1">

                                    <?php echo e($invoice->created_at->format('d M Y')); ?>


                                </p>

                                <p class="text-lg font-black text-primary-600 mt-3">

                                    Rp <?php echo e(number_format($invoice->amount, 0, ',', '.')); ?>


                                </p>

                            </div>

                            <div class="flex items-center gap-2">

                                <a href="<?php echo e(route('client.invoices.show', $invoice)); ?>"
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-all">

                                    <i class="fa-solid fa-eye text-sm"></i>

                                </a>

                                <a href="<?php echo e(route('client.invoices.download', $invoice)); ?>"
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-green-50 text-green-600 hover:bg-green-100 transition-all">

                                    <i class="fa-solid fa-download text-sm"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <div class="text-center py-10 text-gray-500">

                        <div class="bg-gray-100 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">

                            <i class="fa-solid fa-file-invoice text-3xl text-gray-300"></i>

                        </div>

                        <p>

                            Belum ada invoice

                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIP\sinom-jatimas\resources\views/client/projects/show.blade.php ENDPATH**/ ?>