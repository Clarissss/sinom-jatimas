<?php $__env->startSection('title', 'Upload Dokumen - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Upload Dokumen'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Form Upload Dokumen</h3>
        </div>
        
        <div class="p-6">
            <form action="<?php echo e(route('admin.documents.store')); ?>" method="POST" enctype="multipart/form-data" x-data="{ loading: false, fileName: '' }" @submit="loading = true">
                <?php echo csrf_field(); ?>
                
                <div class="mb-6">
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Proyek <span class="text-red-500">*</span>
                    </label>
                    <select id="project_id"
                            name="project_id" 
                            class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 <?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required>
                        <option value="">Pilih Proyek</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Dokumen</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <select id="type"
                                name="type" 
                                class="block w-full pl-10 pr-3 py-2.5 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="contract">Kontrak Kerja</option>
                            <option value="technical_drawing">Gambar Teknis</option>
                            <option value="bast">BAST</option>
                            <option value="material_report">Laporan Material</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        File <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors cursor-pointer"
                             onclick="document.getElementById('file').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none">
                                        <span x-text="fileName || 'Upload file'"></span>
                                        <input id="file" 
                                               name="file" 
                                               type="file" 
                                               class="sr-only" 
                                               accept=".pdf,.jpg,.png,.docx,.xlsx"
                                               @change="fileName = $event.target.files[0].name"
                                               required>
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">PDF, JPG, PNG, DOCX, XLSX up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="<?php echo e(route('admin.documents.index')); ?>" 
                       class="inline-flex items-center px-6 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            :disabled="loading"
                            class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed shadow-sm">
                        <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? 'Mengupload...' : 'Upload'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/documents/create.blade.php ENDPATH**/ ?>