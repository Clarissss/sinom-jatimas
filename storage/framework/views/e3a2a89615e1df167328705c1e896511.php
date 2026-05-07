<?php $__env->startSection('title', 'Detail Jasa - ' . $service->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto animate-fade-in space-y-8">
    
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 px-2">
        <div class="space-y-2">
            <nav class="flex text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 mb-2">
                <a href="<?php echo e(route('admin.services.index')); ?>" class="hover:text-[#DD3517] transition-colors">Catalog</a>
                <span class="mx-3 opacity-30">/</span>
                <span class="text-gray-900">Service Specification</span>
            </nav>
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter uppercase leading-none">
                <?php echo e($service->name); ?>

            </h2>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.services.edit', $service)); ?>" 
               class="px-8 py-4 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl hover:bg-[#DD3517] transition-all transform hover:-translate-y-1">
                Modify Content
            </a>
            <a href="<?php echo e(route('admin.services.index')); ?>" 
               class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center border border-gray-100 text-gray-400 hover:text-gray-900 shadow-sm transition-all">
                <i class="fa-solid fa-xmark text-xl"></i>
            </a>
        </div>
    </div>

    
    <div class="bg-white rounded-[3.5rem] shadow-[0_40px_100px_rgba(0,0,0,0.04)] border border-gray-50 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[600px]">
            
            
            <div class="lg:col-span-5 relative bg-gray-50 p-8 md:p-12 flex flex-col justify-between">
                <div class="relative z-10">
                    <div class="inline-block px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
                        <p class="text-[9px] font-black text-[#DD3517] uppercase tracking-widest">Master Asset #<?php echo e($service->id); ?></p>
                    </div>
                    
                    <div class="aspect-square w-full rounded-[3rem] bg-white shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden group">
                        <?php if($service->icon): ?>
                            <img src="<?php echo e(asset('storage/' . $service->icon)); ?>" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-100">
                                <i class="fa-solid fa-layer-group text-9xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="absolute top-0 right-0 p-12 opacity-[0.03] select-none">
                    <i class="fa-solid fa-building text-[15rem]"></i>
                </div>

                <div class="relative z-10 space-y-4">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Sinom Jati Mas Construction</p>
                    <div class="flex gap-2">
                        <div class="w-12 h-1 bg-[#DD3517] rounded-full"></div>
                        <div class="w-4 h-1 bg-gray-200 rounded-full"></div>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-7 p-8 md:p-20 bg-white">
                <div class="max-w-xl space-y-12">
                    
                    
                    <section class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <span class="w-8 h-[2px] bg-[#DD3517]"></span>
                            <h4 class="text-[10px] font-black text-[#DD3517] uppercase tracking-[0.5em]">Service Overview</h4>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight leading-tight">
                            Detail Kualifikasi dan Cakupan Pekerjaan Lapangan
                        </h3>
                    </section>

                    
                    <section class="relative">
                        <i class="fa-solid fa-quote-left absolute -top-4 -left-6 text-gray-50 text-6xl"></i>
                        <div class="relative prose prose-slate max-w-none">
                            <p class="text-lg text-gray-600 leading-[1.8] font-medium italic italic-none">
                                <?php echo nl2br(e($service->description)); ?>

                            </p>
                        </div>
                    </section>

                    
                    <div class="pt-12 border-t border-gray-100 grid grid-cols-2 gap-y-10">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Slug Identifier</p>
                            <p class="text-sm font-bold text-gray-900 tracking-tight">/<?php echo e($service->slug); ?></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Entry Date</p>
                            <p class="text-sm font-bold text-gray-900 tracking-tight"><?php echo e($service->created_at->translatedFormat('d F Y')); ?></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">System Status</p>
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                                <p class="text-sm font-bold text-gray-900 tracking-tight uppercase">Published</p>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Last Modified</p>
                            <p class="text-sm font-bold text-gray-900 tracking-tight"><?php echo e($service->updated_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="flex flex-col items-center justify-center space-y-4 py-8">
        <div class="w-px h-12 bg-gradient-to-b from-[#DD3517] to-transparent"></div>
        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.8em]">End of Document</p>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/services/show.blade.php ENDPATH**/ ?>