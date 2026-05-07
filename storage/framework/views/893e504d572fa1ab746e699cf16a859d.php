<?php $__env->startSection('title', 'Activity Log - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Activity Log'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 animate-fade-in">
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Hari Ini</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($stats['total_today']); ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 hover:shadow-md transition-shadow">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Login Hari Ini</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($stats['total_login']); ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500 hover:shadow-md transition-shadow">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Data Dibuat</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($stats['total_created']); ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Data Diupdate</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($stats['total_updated']); ?></p>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-900">Filter Aktivitas</h3>
        </div>
        <div class="p-6">
            <form action="<?php echo e(route('admin.activity-logs.index')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aksi</label>
                    <select name="action" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Aksi</option>
                        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($action); ?>" <?php echo e(request('action') == $action ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($action)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                    <select name="user_id" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua User</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                <?php echo e($user->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">IP Address</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($log->created_at->format('d M Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($log->user): ?>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-xs font-bold">
                                            <?php echo e(strtoupper(substr($log->user->name, 0, 1))); ?>

                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900"><?php echo e($log->user->name); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($log->user->role); ?></p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-sm text-gray-500">System</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?php echo e($log->action_color); ?>-100 text-<?php echo e($log->action_color); ?>-800">
                                    <?php echo e(ucfirst($log->action)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?php echo e($log->description); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($log->ip_address); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="<?php echo e(route('admin.activity-logs.show', $log)); ?>" 
                                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada aktivitas</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($logs->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <?php echo e($logs->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/activity-logs/index.blade.php ENDPATH**/ ?>