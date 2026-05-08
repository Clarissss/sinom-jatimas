

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto space-y-6 animate-fade-in">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Profil Perusahaan</h2>
            <p class="text-sm text-gray-500 tracking-tight">Kelola Identitas PT. Sinom Jati Mas.</p>
        </div>
    </div>

    <form action="<?php echo e(route('admin.company-profile.update', 1)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm text-center">
                    <label class="block text-xs font-black text-gray-400 uppercase mb-4">Logo Perusahaan</label>
                    <div class="mb-4 flex justify-center">
                        <img src="<?php echo e($profile->logo ? asset('storage/'.$profile->logo) : 'https://ui-avatars.com/api/?name=SJM'); ?>" 
                             class="w-32 h-32 object-contain rounded-2xl border-2 border-dashed border-gray-100 p-2">
                    </div>
                    <input type="file" name="logo" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-[#DD3517] hover:file:bg-red-100">
                </div>

                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm space-y-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-1">Email</label>
                        <input type="email" name="email" value="<?php echo e($profile->email); ?>" class="w-full border-gray-100 rounded-xl text-sm focus:ring-[#DD3517]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-1">Telepon</label>
                        <input type="text" name="phone" value="<?php echo e($profile->phone); ?>" class="w-full border-gray-100 rounded-xl text-sm focus:ring-[#DD3517]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-1">Alamat</label>
                        <textarea name="address" rows="3" class="w-full border-gray-100 rounded-xl text-sm focus:ring-[#DD3517]"><?php echo e($profile->address); ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm space-y-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Nama Perusahaan</label>
                        <input type="text" name="company_name" value="<?php echo e($profile->company_name ?? 'PT. SINOM JATI MAS'); ?>" class="w-full border-gray-100 rounded-xl font-black text-gray-900 focus:ring-[#DD3517]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Tentang Perusahaan</label>
                        <textarea name="about_us" rows="5" class="w-full border-gray-100 rounded-xl text-sm focus:ring-[#DD3517]"><?php echo e($profile->about_us); ?></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Visi</label>
                            <textarea name="vision" rows="4" class="w-full border-gray-100 rounded-xl text-sm focus:ring-[#DD3517]"><?php echo e($profile->vision); ?></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Misi</label>
                            <textarea name="mission" rows="4" class="w-full border-gray-100 rounded-xl text-sm focus:ring-[#DD3517]"><?php echo e($profile->mission); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-[#DD3517] text-white font-black rounded-2xl shadow-lg hover:bg-[#FF812E] transition-all transform hover:scale-[1.01] active:scale-95 uppercase tracking-widest">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIP\sinom-jatimas\resources\views/admin/company-profile/index.blade.php ENDPATH**/ ?>