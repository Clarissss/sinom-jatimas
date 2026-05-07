<?php $__env->startSection('title', 'Detail Activity Log - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Detail Activity Log'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Detail Aktivitas</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?php echo e($activityLog->action_color); ?>-100 text-<?php echo e($activityLog->action_color); ?>-800">
                <?php echo e(ucfirst($activityLog->action)); ?>

            </span>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900"><?php echo e($activityLog->description); ?></h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($activityLog->created_at->format('d M Y H:i:s')); ?>

                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 pt-6 border-t border-gray-100">
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi User
                    </h4>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">User</dt>
                            <dd class="text-sm font-medium text-gray-900"><?php echo e($activityLog->user?->name ?? 'System'); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($activityLog->user?->email ?? '-'); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Role</dt>
                            <dd class="text-sm text-gray-900"><?php echo e($activityLog->user?->role ?? '-'); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">IP Address</dt>
                            <dd class="text-sm font-mono text-gray-900"><?php echo e($activityLog->ip_address); ?></dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Informasi Model
                    </h4>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Tipe</dt>
                            <dd class="text-sm font-medium text-gray-900"><?php echo e(class_basename($activityLog->model_type)); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">ID</dt>
                            <dd class="text-sm font-mono text-gray-900"><?php echo e($activityLog->model_id); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    
    <?php if($activityLog->old_values || $activityLog->new_values): ?>
        <div class="grid md:grid-cols-2 gap-6">
            <?php if($activityLog->old_values): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
                        <h4 class="text-sm font-semibold text-red-700 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Data Lama
                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4 overflow-x-auto">
                            <pre class="text-xs text-gray-700"><?php echo e(json_encode($activityLog->old_values, JSON_PRETTY_PRINT)); ?></pre>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($activityLog->new_values): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                        <h4 class="text-sm font-semibold text-green-700 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Data Baru
                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4 overflow-x-auto">
                            <pre class="text-xs text-gray-700"><?php echo e(json_encode($activityLog->new_values, JSON_PRETTY_PRINT)); ?></pre>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    
    <div class="flex justify-between">
        <a href="<?php echo e(route('admin.activity-logs.index')); ?>" 
           class="inline-flex items-center px-6 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <form action="<?php echo e(route('admin.activity-logs.destroy', $activityLog)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus log ini?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" 
                    class="inline-flex items-center px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Log
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sinom-portal-laravel\resources\views/admin/activity-logs/show.blade.php ENDPATH**/ ?>