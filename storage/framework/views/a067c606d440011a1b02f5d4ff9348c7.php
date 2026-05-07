<?php $__env->startSection('title', 'Tambah Layanan - PT. Sinom Jati Mas'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in" x-data="{ photoPreview: null }">
    
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <nav class="flex text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-[#DD3517] transition-colors">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="<?php echo e(route('admin.services.index')); ?>" class="hover:text-[#DD3517] transition-colors">Layanan</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Tambah</span>
            </nav>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Layanan</h2>
            <p class="text-sm text-gray-500 font-medium tracking-tight">Menambahkan kategori jasa konstruksi baru ke dalam katalog sistem.</p>
        </div>
        
        
        </a>
    </div>

    
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-50 overflow-hidden">
        <form action="<?php echo e(route('admin.services.store')); ?>" method="POST" enctype="multipart/form-data" class="p-8 md:p-12 space-y-10">
            <?php echo csrf_field(); ?>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                
                <div class="lg:col-span-4 space-y-8">
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Visual Identitas</label>
                        <div class="relative group">
                            <div class="aspect-square w-full rounded-[2rem] bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-[#DD3517]/30">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-center p-6">
                                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 text-gray-300">
                                            <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                        </div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Upload Ikon / Foto</p>
                                    </div>
                                </template>
                                
                                
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm cursor-pointer" @click="$refs.iconInput.click()">
                                    <span class="px-6 py-2 bg-white text-gray-900 text-[10px] font-black uppercase rounded-xl shadow-xl">
                                        Pilih Berkas
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <input type="file" name="icon" x-ref="iconInput" class="hidden" accept="image/*"
                               @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }" required>
                        
                        <p class="text-[9px] text-gray-400 font-medium leading-relaxed italic text-center">Rekomendasi ukuran 500x500px dengan format PNG Transparan atau JPG.</p>
                    </div>

                    
                    <div class="hidden md:block p-6 border border-dashed border-gray-100 rounded-[1.5rem]">
                        <p class="text-[10px] text-gray-300 font-bold uppercase leading-relaxed text-center tracking-widest">
                            Informasi layanan akan otomatis dipublikasikan setelah penyimpanan berhasil.
                        </p>
                    </div>
                </div>

                
                <div class="lg:col-span-8 space-y-10">
                    
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Judul Layanan</label>
                        <input type="text" name="name" 
                               class="w-full bg-white border-0 border-b-2 border-gray-100 py-4 px-0 text-2xl font-black text-gray-900 focus:ring-0 focus:border-[#DD3517] transition-all placeholder:text-gray-200" 
                               placeholder="Masukkan Nama Jasa..." required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Deskripsi Pekerjaan</label>
                        <div class="relative">
                            <textarea name="description" rows="10" 
                                      class="w-full bg-gray-50 border-0 rounded-[2rem] p-8 text-sm text-gray-600 focus:ring-2 focus:ring-[#DD3517]/10 focus:bg-white transition-all shadow-inner leading-relaxed" 
                                      placeholder="Jelaskan cakupan pekerjaan secara mendalam..." required></textarea>
                            <div class="absolute bottom-6 right-8 text-[10px] font-black text-gray-300 uppercase tracking-widest">Sinom Jati Mas Docs</div>
                        </div>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="pt-10 border-t border-gray-50 flex flex-col md:flex-row gap-4">
                <button type="submit" 
                        class="flex-1 py-5 bg-gray-900 text-white font-black rounded-[1.5rem] shadow-[0_15px_30px_rgba(0,0,0,0.15)] hover:bg-[#DD3517] transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-[0.2em] text-sm">
                    Konfirmasi & Simpan Layanan
                </button>
                <a href="<?php echo e(route('admin.services.index')); ?>" 
                   class="px-12 py-5 bg-gray-100 text-gray-400 font-black rounded-[1.5rem] hover:bg-gray-200 transition-all text-sm uppercase tracking-widest text-center">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/services/create.blade.php ENDPATH**/ ?>