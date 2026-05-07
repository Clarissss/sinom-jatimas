<?php $__env->startSection('title', 'Edit Profil - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Edit Profil'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Profil</h3>
        </div>
        
        <div class="p-6">
            <form action="<?php echo e(route('profile.update')); ?>" method="POST" x-data="{ loading: false, preview: null }" enctype="multipart/form-data" @submit="loading = true">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="flex flex-col items-center mb-8">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                            <img x-show="!preview" 
                                 src="<?php echo e(auth()->user()->photo_url); ?>" 
                                 alt="<?php echo e(auth()->user()->name); ?>"
                                 class="w-full h-full object-cover">
                            <img x-show="preview" 
                                 :src="preview" 
                                 alt="Preview"
                                 class="w-full h-full object-cover">
                        </div>
                        <label for="photo-input" 
                               class="absolute bottom-0 right-0 w-10 h-10 bg-primary-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-md hover:bg-primary-700 transition-colors">
                            <i class="fa-solid fa-camera"></i>
                        </label>
                    </div>
                    
                    <?php if(auth()->user()->photo): ?>
                        <div class="mt-4">
                            <button type="button" 
                                    @click.prevent="if(confirm('Yakin ingin menghapus foto profil?')) { document.getElementById('delete-photo-form').submit(); }"
                                    class="text-sm text-red-600 hover:text-red-800 flex items-center transition-colors">
                                <i class="fa-solid fa-trash-can mr-1"></i>
                                Hapus Foto
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                
                <input type="file" 
                       id="photo-input" 
                       name="photo" 
                       accept="image/jpeg,image/png,image/jpg"
                       class="hidden"
                       @change="
                           const file = $event.target.files[0];
                           if (file) {
                               const reader = new FileReader();
                               reader.onload = (e) => { preview = e.target.result; };
                               reader.readAsDataURL(file);
                           }
                       ">

                
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="name"
                                   name="name" 
                                   value="<?php echo e(old('name', auth()->user()->name)); ?>"
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                        </div>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" 
                                   id="email"
                                   name="email" 
                                   value="<?php echo e(old('email', auth()->user()->email)); ?>"
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="email@perusahaan.com"
                                   required>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-phone text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="phone"
                                   name="phone" 
                                   value="<?php echo e(old('phone', auth()->user()->phone)); ?>"
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="081234567890">
                        </div>
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-shield-halved text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="role"
                                   value="<?php echo e(ucfirst(auth()->user()->role)); ?>" 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                                   disabled>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Role tidak dapat diubah</p>
                    </div>
                </div>

                
                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" 
                            :disabled="loading"
                            class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed shadow-sm">
                        <i x-show="loading" class="fa-solid fa-circle-notch fa-spin mr-2" style="display: none;"></i>
                        <span x-text="loading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Ganti Password</h3>
        </div>
        
        <div class="p-6">
            <form action="<?php echo e(route('profile.password')); ?>" method="POST" x-data="{ loading: false }">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="mb-6">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" 
                               id="current_password"
                               name="current_password" 
                               class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Masukkan password saat ini"
                               required>
                        <button type="button" 
                                @click="show = !show" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i x-show="!show" class="fa-regular fa-eye"></i>
                            <i x-show="show" class="fa-regular fa-eye-slash" style="display: none;"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i>
                            <?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-key text-gray-400"></i>
                            </div>
                            <input :type="show ? 'text' : 'password'" 
                                   id="password"
                                   name="password" 
                                   class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <button type="button" 
                                    @click="show = !show" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i x-show="!show" class="fa-regular fa-eye"></i>
                                <i x-show="show" class="fa-regular fa-eye-slash" style="display: none;"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-check-double text-gray-400"></i>
                            </div>
                            <input :type="show ? 'text' : 'password'" 
                                   id="password_confirmation"
                                   name="password_confirmation" 
                                   class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                   placeholder="Ulangi password baru"
                                   required>
                            <button type="button" 
                                    @click="show = !show" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i x-show="!show" class="fa-regular fa-eye"></i>
                                <i x-show="show" class="fa-regular fa-eye-slash" style="display: none;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                
                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" 
                            @click="loading = true"
                            :disabled="loading"
                            class="inline-flex items-center px-6 py-2.5 bg-secondary-600 text-white text-sm font-medium rounded-lg hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed shadow-sm">
                        <i x-show="loading" class="fa-solid fa-circle-notch fa-spin mr-2" style="display: none;"></i>
                        <span x-text="loading ? 'Memproses...' : 'Ganti Password'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php if(auth()->user()->photo): ?>
    <form id="delete-photo-form" action="<?php echo e(route('profile.photo.delete')); ?>" method="POST" class="hidden">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
    </form>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sinom-portal-laravel\resources\views/profile/edit.blade.php ENDPATH**/ ?>