<?php $__env->startSection('title', 'Tambah Laporan Harian - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Tambah Laporan Harian'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-control { 
        border-radius: 0.5rem !important; 
        padding: 0.6rem 0.75rem !important; 
        border-color: #d1d5db !important; 
    }
    .ts-wrapper.focus .ts-control { 
        border-color: #DD3517 !important; 
        box-shadow: 0 0 0 2px rgba(221, 53, 23, 0.1) !important; 
    }
    .ts-dropdown .active { 
        background-color: rgba(221, 53, 23, 0.05) !important; 
        color: #DD3517 !important; 
    }
</style>

<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Form Laporan Harian</h3>
        </div>
        
        <div class="p-6">
            <form action="<?php echo e(route('admin.daily-reports.store')); ?>" method="POST" enctype="multipart/form-data" 
                  x-data='{ 
                      loading: false,
                      imagePreviews: [],
                      selectedClient: "<?php echo e(old("client_id")); ?>",
                      allProjects: <?php echo json_encode($projects, 15, 512) ?>,
                      
                      clientSelect: null,
                      projectSelect: null,

                      init() {
                          this.clientSelect = new TomSelect(this.$refs.client_select, {
                              render: {
                                  option: (data, escape) => `<div><span class="mr-2 text-gray-400"><i class="fas fa-user-tie w-4"></i></span>${escape(data.text)}</div>`,
                                  item: (data, escape) => `<div><span class="mr-2 text-[#DD3517]"><i class="fas fa-user-tie w-4"></i></span>${escape(data.text)}</div>`
                              },
                              onChange: (val) => { 
                                  this.selectedClient = val;
                                  this.updateProjects();
                              }
                          });

                          this.projectSelect = new TomSelect(this.$refs.project_select, {
                              render: {
                                  option: (data, escape) => `<div><span class="mr-2 text-gray-400"><i class="fas fa-building w-4"></i></span>${escape(data.text)}</div>`,
                                  item: (data, escape) => `<div><span class="mr-2 text-[#DD3517]"><i class="fas fa-building w-4"></i></span>${escape(data.text)}</div>`
                              },
                              onChange: (val) => { this.selectedProject = val; }
                          });

                          this.updateProjects();
                      },

                      updateProjects() {
                          if (!this.projectSelect) return;
                          this.projectSelect.clear();
                          this.projectSelect.clearOptions();
                          
                          if (this.selectedClient) {
                              const filtered = this.allProjects.filter(p => p.client_id == this.selectedClient);
                              const options = filtered.map(p => ({ value: p.id, text: p.name }));
                              this.projectSelect.addOptions(options);
                              this.projectSelect.enable();
                          } else {
                              this.projectSelect.disable();
                          }
                      },

                      handleFiles(files) {
                          for (let i = 0; i < files.length; i++) {
                              const file = files[i];
                              if (file && file.type.startsWith("image/")) {
                                  const reader = new FileReader();
                                  reader.onload = (e) => {
                                      this.imagePreviews.push({
                                          id: Date.now() + i,
                                          src: e.target.result,
                                          name: file.name
                                      });
                                  };
                                  reader.readAsDataURL(file);
                              }
                          }
                      },

                      removePreview(index) {
                          this.imagePreviews.splice(index, 1);
                          const dataTransfer = new DataTransfer();
                          const input = this.$refs.photoInput;
                          
                          Array.from(input.files)
                              .filter((_, i) => i !== index)
                              .forEach(file => dataTransfer.items.add(file));
                          
                          input.files = dataTransfer.files;
                      }
                  }' 
                  @submit="loading = true">
                <?php echo csrf_field(); ?>
                
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Klien <span class="text-red-500">*</span></label>
                        <select x-ref="client_select" name="client_id" placeholder="Cari klien..." required>
                            <option value="">Pilih Klien</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Proyek <span class="text-red-500">*</span></label>
                        <select x-ref="project_select" name="project_id" placeholder="Cari proyek..." required>
                            <option value="">Pilih Proyek</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Laporan <span class="text-red-500">*</span></label>
                    <input type="date" name="report_date" value="<?php echo e(old('report_date', date('Y-m-d'))); ?>" 
                           class="w-full border-gray-300 rounded-lg focus:ring-[#DD3517] focus:border-[#DD3517]" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Cuaca</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <?php $__currentLoopData = ['sunny' => 'Cerah', 'cloudy' => 'Berawan', 'rainy' => 'Hujan', 'storm' => 'Badai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="weather_condition" value="<?php echo e($val); ?>" class="peer hidden" <?php echo e($loop->first ? 'checked' : ''); ?>>
                            <div class="text-center p-2 border rounded-lg peer-checked:border-[#DD3517] peer-checked:bg-orange-50 peer-checked:text-[#DD3517] hover:bg-gray-50 transition-all">
                                <span class="text-xs font-medium"><?php echo e($label); ?></span>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Foto (Bisa Pilih Banyak)</label>
                    <div @click="$refs.photoInput.click()" 
                         class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#DD3517] hover:bg-orange-50/30 transition-all cursor-pointer group relative mb-4">
                        
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 group-hover:text-[#DD3517] mb-3 transition-colors"></i>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="font-medium text-[#DD3517] group-hover:text-[#FF812E]">Klik untuk upload</span>
                                <p class="pl-1 text-gray-500">atau select banyak file</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG (Maks. 2MB per foto)</p>
                        </div>

                        
                        <input type="file" x-ref="photoInput" name="photos[]" class="hidden" accept="image/*" multiple
                               @change="handleFiles($event.target.files)">
                    </div>

                    
                    <template x-if="imagePreviews.length > 0">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <template x-for="(img, index) in imagePreviews" :key="img.id">
                                <div class="relative group aspect-square rounded-lg overflow-hidden border shadow-sm bg-white">
                                    <img :src="img.src" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button type="button" @click.stop="removePreview(index)" 
                                                class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600 shadow-lg transform scale-90 group-hover:scale-100 transition-transform">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Aktivitas <span class="text-red-500">*</span></label>
                    <textarea name="activity_description" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-[#DD3517] focus:border-[#DD3517]" placeholder="Jelaskan progres hari ini..." required><?php echo e(old('activity_description')); ?></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="<?php echo e(route('admin.daily-reports.index')); ?>" class="px-6 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" :disabled="loading" class="bg-[#DD3517] text-white px-6 py-2.5 rounded-lg hover:bg-[#FF812E] text-sm font-medium shadow-md transition-all inline-flex items-center">
                        <i x-show="loading" class="fas fa-spinner fa-spin mr-2"></i>
                        <span x-text="loading ? 'Menyimpan...' : 'Simpan Laporan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/daily-reports/create.blade.php ENDPATH**/ ?>