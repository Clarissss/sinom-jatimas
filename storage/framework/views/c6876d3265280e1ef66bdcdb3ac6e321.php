

<?php $__env->startSection('content'); ?>
<div class="space-y-6 animate-fade-in">
    
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Katalog Layanan</h2>
            <p class="text-sm text-gray-500 font-medium">Manajemen daftar jasa konstruksi & alat berat PT. Sinom Jati Mas.</p>
        </div>
        <a href="<?php echo e(route('admin.services.create')); ?>" 
           class="px-8 py-3 bg-[#DD3517] text-white font-black rounded-2xl shadow-lg hover:bg-[#FF812E] transition-all transform hover:scale-105 active:scale-95 text-xs tracking-widest uppercase">
            <i class="fa-solid fa-plus mr-2"></i> TAMBAH LAYANAN
        </a>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm group hover:border-[#DD3517] hover:shadow-xl transition-all duration-300 relative">
            
            <div class="flex justify-between items-start mb-6">
                
                <a href="<?php echo e(route('admin.services.show', $service)); ?>" class="block">
                    <div class="w-16 h-16 bg-gray-50 rounded-[1.5rem] flex items-center justify-center overflow-hidden border border-gray-100 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <?php if($service->icon): ?>
                            <img src="<?php echo e(asset('storage/' . $service->icon)); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <i class="fa-solid fa-screwdriver-wrench text-gray-300 text-2xl"></i>
                        <?php endif; ?>
                    </div>
                </a>
                
                
                <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    
                    <a href="<?php echo e(route('admin.services.edit', $service)); ?>" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                    </a>
                    <form action="<?php echo e(route('admin.services.destroy', $service)); ?>" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

            
            <a href="<?php echo e(route('admin.services.show', $service)); ?>" class="block group/text">
                <h3 class="text-lg font-black text-gray-900 mb-3 uppercase tracking-tight group-hover/text:text-[#DD3517] transition-colors">
                    <?php echo e($service->name); ?>

                </h3>
            </a>
            <p class="text-xs text-gray-500 leading-relaxed mb-6 line-clamp-3">
                <?php echo e($service->description); ?>

            </p>

            
            <div class="flex justify-between items-center pt-5 border-t border-gray-50">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter bg-green-100 text-green-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse mr-1.5"></span>
                    Aktif
                </span>
                <a href="<?php echo e(route('admin.services.show', $service)); ?>" class="text-[10px] font-black text-[#DD3517] uppercase tracking-widest hover:underline">
                    Detail <i class="fa-solid fa-chevron-right ml-1 text-[8px]"></i>
                </a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-layer-group text-3xl text-gray-200"></i>
            </div>
            <p class="text-gray-400 font-black uppercase tracking-widest">Belum ada layanan terdaftar</p>
            <a href="<?php echo e(route('admin.services.create')); ?>" class="mt-4 inline-block text-xs font-bold text-[#DD3517] hover:underline uppercase tracking-tighter">Tambah Sekarang</a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIP\sinom-jatimas\resources\views/admin/services/index.blade.php ENDPATH**/ ?>