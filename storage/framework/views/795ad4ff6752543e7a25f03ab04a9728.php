<?php $__env->startSection('content'); ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-control { border-radius: 0.5rem !important; padding: 0.5rem 0.75rem !important; border-color: #d1d5db !important; }
    .ts-wrapper.focus .ts-control { border-color: #DD3517 !important; box-shadow: 0 0 0 2px rgba(221, 53, 23, 0.1) !important; }
</style>

<div class="space-y-6 animate-fade-in">
    
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Pusat Arsip Digital</h2>
            <p class="text-sm text-gray-500">PT. Sinom Jati Mas - Manajemen Berkas Terintegrasi</p>
        </div>
    </div>

    
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200"
         x-data="{
            init() {
                new TomSelect('#filter_client', {
                    render: {
                        option: (data, escape) => `<div><span class='mr-2 text-gray-400'><i class='fas fa-user-tie w-4'></i></span>${escape(data.text)}</div>`,
                        item: (data, escape) => `<div><span class='mr-2 text-[#DD3517]'><i class='fas fa-user-tie w-4'></i></span>${escape(data.text)}</div>`
                    }
                });
                new TomSelect('#filter_project', {
                    render: {
                        option: (data, escape) => `<div><span class='mr-2 text-gray-400'><i class='fas fa-building w-4'></i></span>${escape(data.text)}</div>`,
                        item: (data, escape) => `<div><span class='mr-2 text-[#DD3517]'><i class='fas fa-building w-4'></i></span>${escape(data.text)}</div>`
                    }
                });
            }
         }">
        <form action="<?php echo e(route('admin.documents.index')); ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-end">
            
            
            <div>
                <label for="filter_client" class="block text-sm font-medium text-gray-700 mb-1">Klien</label>
                <select name="client_id" id="filter_client" placeholder="Pilih Klien...">
                    <option value="">Semua Klien</option>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                            <?php echo e($client->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label for="filter_project" class="block text-sm font-medium text-gray-700 mb-1">Proyek</label>
                <select name="project_id" id="filter_project" placeholder="Pilih Proyek...">
                    <option value="">Semua Proyek</option>
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($project->id); ?>" <?php echo e(request('project_id') == $project->id ? 'selected' : ''); ?>>
                            <?php echo e($project->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="date" value="<?php echo e(request('date')); ?>" 
                       class="w-full border-gray-300 rounded-lg focus:ring-[#DD3517] focus:border-[#DD3517] h-[42px] text-sm">
            </div>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis File</label>
                <select name="type" class="w-full border-gray-300 rounded-lg focus:ring-[#DD3517] focus:border-[#DD3517] h-[42px] text-sm">
                    <option value="">Semua Jenis</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e(request('type') == $key ? 'selected' : ''); ?>><?php echo e($cat['label']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div class="flex space-x-2">
                <button type="submit" class="w-full bg-gray-900 text-white px-4 py-2.5 rounded-lg hover:bg-gray-800 text-sm font-medium transition-colors h-[42px]">
                    <i class="fa-solid fa-filter mr-1"></i> Terapkan
                </button>
                <?php if(request()->anyFilled(['client_id', 'project_id', 'date', 'type'])): ?>
                    <a href="<?php echo e(route('admin.documents.index')); ?>" 
                       class="inline-flex items-center justify-center bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-200 text-sm font-medium h-[42px]">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.documents.index', ['type' => $key, 'client_id' => request('client_id'), 'project_id' => request('project_id'), 'date' => request('date')])); ?>" 
           class="group bg-white p-6 rounded-[2rem] border-2 <?php echo e(request('type') == $key ? 'border-[#DD3517] bg-red-50/20' : 'border-transparent'); ?> shadow-sm hover:border-[#DD3517] transition-all transform hover:-translate-y-1">
            <div class="<?php echo e($cat['color']); ?> w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl mb-4 shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid <?php echo e($cat['icon']); ?>"></i>
            </div>
            <h4 class="font-black text-gray-900 text-sm"><?php echo e($cat['label']); ?></h4>
            <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest"><?php echo e($cat['count']); ?> Berkas</p>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Berkas</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Klien</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Proyek</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <?php
                                    $icon = 'fa-file-lines text-gray-400';
                                    if($file->source == 'chat') $icon = 'fa-comment-dots text-blue-500';
                                    if($file->source == 'report') $icon = 'fa-images text-emerald-500';
                                ?>
                                <i class="fa-solid <?php echo e($icon); ?> mr-3 text-lg"></i>
                                <span class="font-bold text-gray-800 text-xs break-all"><?php echo e($file->file_name ?? 'N/A'); ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-600">
                            <?php echo e($file->client_name); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-gray-100 rounded-full text-[10px] font-black text-gray-500 uppercase">
                                <?php echo e($file->project_name); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo e(route('admin.documents.download', $file->id)); ?>?source=<?php echo e($file->source); ?>" 
                               class="bg-gray-900 text-white px-4 py-2 rounded-lg font-black text-[10px] hover:bg-gray-800 transition-all">
                                <i class="fa-solid fa-download mr-1"></i> DOWNLOAD
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center text-gray-400 font-bold">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/documents/index.blade.php ENDPATH**/ ?>