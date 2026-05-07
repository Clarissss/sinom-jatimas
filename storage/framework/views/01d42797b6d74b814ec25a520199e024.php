<?php $__env->startSection('title', 'Tambah Laporan Harian - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Tambah Laporan Harian'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    /* Styling Tom Select agar sesuai branding Sinom Jati Mas */
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
                      imagePreview: null,
                      selectedClient: "<?php echo e(old("client_id")); ?>",
                      allProjects: <?php echo json_encode($projects, 15, 512) ?>,
                      
                      clientSelect: null,
                      projectSelect: null,

                      init() {
                          // Dropdown Klien dengan Ikon & Search
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

                          // Dropdown Proyek dengan Ikon & Search
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Foto</label>
                    <div @click="$refs.photoInput.click()" 
                         class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#DD3517] hover:bg-orange-50/30 transition-all cursor-pointer group relative">
                        
                        <div class="space-y-1 text-center">
                            <template x-if="imagePreview">
                                <div class="relative inline-block">
                                    <img :src="imagePreview" class="mx-auto h-40 w-auto rounded-lg object-cover border shadow-sm">
                                    <button type="button" @click.stop="imagePreview = null; $refs.photoInput.value = ''" 
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 shadow-lg">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            </template>

                            <template x-if="!imagePreview">
                                <div>
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 group-hover:text-[#DD3517] mb-3 transition-colors"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span class="font-medium text-[#DD3517] group-hover:text-[#FF812E]">Klik untuk upload</span>
                                        <p class="pl-1 text-gray-500">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG (Maks. 2MB)</p>
                                </div>
                            </template>
                        </div>

                        <input type="file" x-ref="photoInput" name="photo" class="hidden" accept="image/*"
                               @change="
                                    const file = $event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => { imagePreview = e.target.result; };
                                        reader.readAsDataURL(file);
                                    }
                               ">
                    </div>
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