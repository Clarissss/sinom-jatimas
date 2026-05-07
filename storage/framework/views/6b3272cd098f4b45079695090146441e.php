<?php $__env->startSection('title', 'Edit Invoice - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('page-title', 'Edit Invoice'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-5xl mx-auto animate-fade-in" 
     x-data='editInvoiceForm(<?php echo json_encode($projects); ?>, <?php echo json_encode($invoice); ?>, <?php echo json_encode($invoice->items); ?>)'>
    
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        
        
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Edit Invoice</h3>
                <p class="text-sm text-gray-500 mt-1 font-medium"><?php echo e($invoice->invoice_number); ?></p>
            </div>
            <span class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center">
                <i class="fa-solid fa-pen-to-square mr-1.5"></i> Mode Edit
            </span>
        </div>
        
        <div class="p-8">
            <form action="<?php echo e(route('admin.invoices.update', $invoice)); ?>" method="POST" @submit="loading = true">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                    
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Klien <span class="text-red-500">*</span></label>
                        <select name="client_id" x-model="selectedClient" @change="selectedProject = ''" 
                                class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-[#DD3517] focus:border-[#DD3517] font-medium text-sm transition-colors" required>
                            <option value="">-- Pilih Klien --</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Proyek <span class="text-red-500">*</span></label>
                        <select name="project_id" x-model="selectedProject" 
                                class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-[#DD3517] focus:border-[#DD3517] font-medium text-sm transition-colors" 
                                :disabled="!selectedClient" required>
                            <option value="">-- Pilih Proyek --</option>
                            <template x-for="project in filteredProjects" :key="project.id">
                                <option :value="project.id.toString()" x-text="project.name" :selected="project.id == selectedProject"></option>
                            </template>
                        </select>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Termin Tagihan <span class="text-red-500">*</span></label>
                        <div class="relative" @click.away="terminOpen = false">
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-chart-pie text-sm"></i>
                                </div>
                                <input type="number" name="termin_percentage" x-model="terminPercentage" @focus="terminOpen = true" 
                                       class="block w-full pl-10 pr-16 py-2.5 bg-gray-50 border-gray-200 rounded-xl focus:ring-[#DD3517] focus:border-[#DD3517] font-medium text-sm transition-colors" required min="1" max="100">
                                <div class="absolute inset-y-0 right-10 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold text-sm">%</span>
                                </div>
                                <button type="button" @click="terminOpen = !terminOpen" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-[#DD3517] border-l border-gray-200 transition-colors">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </button>
                            </div>
                            <div x-show="terminOpen" x-transition class="absolute z-20 w-full mt-1.5 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden" style="display: none;">
                                <ul class="py-1 text-sm font-medium text-gray-700">
                                    <li><button type="button" @click="terminPercentage = 30; terminOpen = false" class="block w-full text-left px-4 py-2.5 hover:bg-[#DD3517] hover:text-white transition-colors">30%</button></li>
                                    <li><button type="button" @click="terminPercentage = 50; terminOpen = false" class="block w-full text-left px-4 py-2.5 hover:bg-[#DD3517] hover:text-white transition-colors">50%</button></li>
                                    <li><button type="button" @click="terminPercentage = 100; terminOpen = false" class="block w-full text-left px-4 py-2.5 hover:bg-[#DD3517] hover:text-white transition-colors">100%</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jatuh Tempo</label>
                        <input type="date" name="due_date" x-model="dueDate" class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-[#DD3517] focus:border-[#DD3517] font-medium text-sm transition-colors text-gray-700">
                    </div>
                </div>

                
                <div class="mb-6">
                    <div class="flex justify-between items-end mb-4">
                        <h4 class="text-sm font-black text-gray-900 border-b-2 border-[#DD3517] pb-1 uppercase tracking-wider">Detail Pekerjaan / Barang</h4>
                        <button type="button" @click="addItem()" class="text-xs bg-gray-900 text-white px-4 py-2 rounded-xl hover:bg-gray-800 transition-all shadow-md">
                            <i class="fa-solid fa-plus mr-1.5"></i> Tambah Baris
                        </button>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-600 uppercase bg-gray-100 border-b border-gray-200 font-bold">
                                <tr>
                                    <th class="px-4 py-4 w-12 text-center">No</th>
                                    <th class="px-4 py-4">Uraian Pekerjaan / Barang</th>
                                    <th class="px-4 py-4 w-28 text-center">Qty</th>
                                    <th class="px-4 py-4 w-32 text-center">Satuan</th>
                                    <th class="px-4 py-4 w-48 text-right">Harga Satuan (Rp)</th>
                                    <th class="px-4 py-4 w-48 text-right">Jumlah (Rp)</th>
                                    <th class="px-4 py-4 w-14 text-center">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 text-center font-bold text-gray-500" x-text="index + 1"></td>
                                        <td class="px-4 py-2">
                                            <input type="text" x-model="item.item_name" :name="'items['+index+'][item_name]'" required 
                                                   class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#DD3517] focus:border-[#DD3517]">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="number" step="0.1" x-model="item.quantity" :name="'items['+index+'][quantity]'" required 
                                                   class="w-full border-gray-200 rounded-lg text-sm text-center focus:ring-[#DD3517] focus:border-[#DD3517]">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="text" x-model="item.unit" :name="'items['+index+'][unit]'" required 
                                                   class="w-full border-gray-200 rounded-lg text-sm text-center focus:ring-[#DD3517] focus:border-[#DD3517]">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="number" x-model="item.price" :name="'items['+index+'][price]'" required 
                                                   class="w-full border-gray-200 rounded-lg text-sm text-right focus:ring-[#DD3517] focus:border-[#DD3517]">
                                        </td>
                                        <td class="px-4 py-3 text-right font-black text-gray-700 bg-gray-50/50">
                                            <span x-text="formatCurrency(item.quantity * item.price)"></span>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="button" @click="removeItem(index)" class="text-gray-400 hover:text-red-500 hover:bg-red-50 w-8 h-8 rounded-lg transition-all">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-100 border-t-2 border-gray-200">
                                    <td colspan="5" class="px-4 py-5 text-right font-black text-gray-900 uppercase tracking-widest text-xs">Total Tagihan Keseluruhan :</td>
                                    <td class="px-4 py-5 text-right font-black text-[#DD3517] text-xl">
                                        Rp <span x-text="formatCurrency(calculateTotal())"></span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                
                <div class="flex justify-end space-x-4 pt-6 mt-6 border-t border-gray-100">
                    <a href="<?php echo e(route('admin.invoices.index')); ?>" class="inline-flex items-center px-6 py-3 border-2 border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                        Batal
                    </a>
                    <button type="submit" :disabled="loading || items.length === 0" class="inline-flex items-center px-8 py-3 bg-[#DD3517] text-white text-sm font-bold rounded-xl hover:bg-[#FF812E] transition-all shadow-md transform hover:-translate-y-1">
                        <i x-show="!loading" class="fa-solid fa-save mr-2"></i>
                        <i x-show="loading" class="fa-solid fa-circle-notch fa-spin mr-2" style="display: none;"></i>
                        <span x-text="loading ? 'Memperbarui...' : 'Update Invoice'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editInvoiceForm(projectsData, invoiceData, itemsData) {
    // KUNCI PERBAIKAN: Konversi ID ke string agar sinkron dengan x-model dropdown
    let currentProjectId = invoiceData.project_id ? invoiceData.project_id.toString() : '';
    let currentClientId = invoiceData.project ? invoiceData.project.client_id.toString() : '';

    return {
        loading: false,
        allProjects: projectsData || [], 
        
        // Inisialisasi Data Form
        selectedClient: currentClientId,
        selectedProject: currentProjectId,
        terminPercentage: invoiceData.termin_percentage || 100,
        terminOpen: false,
        dueDate: invoiceData.due_date ? invoiceData.due_date.split('T')[0] : '',
        
        // Memuat item pekerjaan dari database
        items: itemsData.length > 0 ? itemsData.map(i => ({
            item_name: i.item_name,
            quantity: parseFloat(i.quantity),
            unit: i.unit,
            price: parseFloat(i.price)
        })) : [{ item_name: '', quantity: 1, unit: '', price: 0 }],
        
        // Filter proyek otomatis berdasarkan klien
        get filteredProjects() {
            if (!this.selectedClient) return [];
            return this.allProjects.filter(project => {
                // Gunakan == agar perbandingan string/int tidak masalah
                return project.client_id == this.selectedClient || project.user_id == this.selectedClient;
            });
        },
        
        addItem() {
            this.items.push({ item_name: '', quantity: 1, unit: '', price: 0 });
        },
        
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            } else {
                alert("Minimal harus ada 1 baris pekerjaan!");
            }
        },
        
        calculateTotal() {
            return this.items.reduce((total, item) => {
                return total + (parseFloat(item.quantity || 0) * parseFloat(item.price || 0));
            }, 0);
        },
        
        formatCurrency(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/invoices/edit.blade.php ENDPATH**/ ?>