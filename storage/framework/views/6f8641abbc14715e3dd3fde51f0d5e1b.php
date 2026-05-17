<?php $__env->startSection('title', 'Profile Settings - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in" x-data="{ loading: false, preview: null }">
    
    
    <div class="px-2">
        <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase">Pengaturan Akun</h2>
        <p class="text-sm text-gray-500 font-medium">Kelola informasi identitas dan keamanan kata sandi Anda.</p>
    </div>

    
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 md:p-12">
            <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" @submit="loading = true">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                
                <div class="flex flex-col md:flex-row gap-12">
                    
                    <div class="flex flex-col items-center space-y-4">
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-[2rem] overflow-hidden bg-gray-50 border-4 border-white shadow-md">
                                <img x-show="!preview" src="<?php echo e(auth()->user()->photo_url); ?>" class="w-full h-full object-cover">
                                <img x-show="preview" :src="preview" class="w-full h-full object-cover">
                            </div>
                            <label for="photo-input" class="absolute -bottom-2 -right-2 w-10 h-10 bg-gray-900 text-white rounded-xl flex items-center justify-center cursor-pointer hover:bg-[#DD3517] transition-all shadow-lg">
                                <i class="fa-solid fa-camera text-xs"></i>
                            </label>
                        </div>
                        <input type="file" id="photo-input" name="photo" class="hidden" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { preview = e.target.result; }; reader.readAsDataURL(file); }">
                    </div>

                    
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" class="w-full bg-transparent border-0 border-b border-gray-200 py-2 font-bold text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat Email</label>
                            <input type="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" class="w-full bg-transparent border-0 border-b border-gray-200 py-2 font-bold text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nomor Telepon</label>
                            <input type="text" name="phone" value="<?php echo e(old('phone', auth()->user()->phone)); ?>" class="w-full bg-transparent border-0 border-b border-gray-200 py-2 font-bold text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Hak Akses</label>
                            <div class="py-2 font-black text-[#DD3517] uppercase tracking-tighter"><?php echo e(auth()->user()->role); ?></div>
                        </div>
                        
                        <div class="md:col-span-2 pt-4">
                            <button type="submit" :disabled="loading" class="px-8 py-3 bg-gray-900 text-white font-black rounded-xl text-[10px] uppercase tracking-widest hover:bg-[#DD3517] transition-all shadow-lg active:scale-95">
                                <span x-text="loading ? 'Menyimpan...' : 'Update Profil'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex items-center space-x-4 mb-8">
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-[#DD3517]">
                    <i class="fa-solid fa-lock text-sm"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Ganti Password</h3>
            </div>

            <form action="<?php echo e(route('profile.password')); ?>" method="POST" @submit="loading = true" class="space-y-8">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full bg-transparent border-0 border-b border-gray-200 py-2 font-bold text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Password Baru</label>
                        <input type="password" name="password" class="w-full bg-transparent border-0 border-b border-gray-200 py-2 font-bold text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ulangi Password</label>
                        <input type="password" name="password_confirmation" class="w-full bg-transparent border-0 border-b border-gray-200 py-2 font-bold text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all" required>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-3 bg-[#DD3517] text-white font-black rounded-xl text-[10px] uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg active:scale-95">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php if(auth()->user()->photo): ?>
<form id="delete-photo-form" action="<?php echo e(route('profile.photo.delete')); ?>" method="POST" class="hidden"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?></form>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/profile/edit.blade.php ENDPATH**/ ?>