<?php $__env->startSection('title', 'Invoice ' . $invoice->invoice_number); ?>
<?php $__env->startSection('page-title', 'Detail Invoice'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto animate-fade-in">
    
    
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <a href="<?php echo e(route('admin.invoices.index')); ?>" class="text-gray-500 hover:text-gray-900 font-medium transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
        <div class="flex space-x-3">
            <?php if($invoice->status !== 'paid'): ?>
                <a href="<?php echo e(route('admin.invoices.edit', $invoice)); ?>" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 shadow-sm transition-all">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.invoices.download', $invoice)); ?>" class="px-5 py-2 bg-[#DD3517] text-white font-bold rounded-xl hover:bg-[#FF812E] shadow-sm transition-all">
                <i class="fa-solid fa-download mr-2"></i> Download PDF
            </a>
        </div>
    </div>

    
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden p-8 sm:p-12">
        
        
        <div class="flex justify-between items-start border-b-2 border-gray-100 pb-8 mb-8">
            <div>
                <h1 class="text-3xl font-black text-[#DD3517] tracking-tight mb-2">INVOICE</h1>
                <p class="text-gray-500 font-medium">No: <strong class="text-gray-900"><?php echo e($invoice->invoice_number); ?></strong></p>
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-<?php echo e($invoice->status_color); ?>-100 text-<?php echo e($invoice->status_color); ?>-700">
                        <?php echo e($invoice->status_label); ?>

                    </span>
                </div>
            </div>
            <div class="text-right">
                <div class="w-16 h-16 bg-[#DD3517] text-white flex items-center justify-center rounded-2xl text-2xl font-black ml-auto mb-3 shadow-lg">S</div>
                <h3 class="font-bold text-gray-900">PT. SINOM JATI MAS</h3>
                <p class="text-xs text-gray-500 mt-1">General Contractor & Trading</p>
            </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10">
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                <p class="text-[10px] font-bold text-[#DD3517] uppercase tracking-wider mb-2">Ditagihkan Kepada:</p>
                <h4 class="font-black text-gray-900 text-lg"><?php echo e($invoice->project->client->name); ?></h4>
                <p class="text-sm text-gray-600 mt-1"><?php echo e($invoice->project->client->email); ?></p>
                <p class="text-sm text-gray-600"><?php echo e($invoice->project->client->phone ?? '-'); ?></p>
            </div>
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                <p class="text-[10px] font-bold text-[#DD3517] uppercase tracking-wider mb-2">Informasi Proyek & Penagihan:</p>
                <table class="w-full text-sm">
                    <tr>
                        <td class="text-gray-500 py-1">Proyek</td>
                        <td class="font-bold text-gray-900 text-right"><?php echo e($invoice->project->name); ?></td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 py-1">Termin</td>
                        <td class="font-bold text-gray-900 text-right"><?php echo e($invoice->termin_percentage); ?>%</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 py-1">Tanggal Terbit</td>
                        <td class="font-bold text-gray-900 text-right"><?php echo e($invoice->created_at->format('d M Y')); ?></td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 py-1">Jatuh Tempo</td>
                        <td class="font-bold text-[#DD3517] text-right"><?php echo e($invoice->due_date ? $invoice->due_date->format('d M Y') : '-'); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        
        <div class="mb-8">
            <h4 class="text-sm font-black text-gray-900 mb-4 uppercase tracking-wider">Rincian Pekerjaan</h4>
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-bold text-gray-700 w-12 text-center">No</th>
                            <th class="px-4 py-3 font-bold text-gray-700">Deskripsi</th>
                            <th class="px-4 py-3 font-bold text-gray-700 text-center w-24">Qty</th>
                            <th class="px-4 py-3 font-bold text-gray-700 text-right w-40">Harga Satuan</th>
                            <th class="px-4 py-3 font-bold text-gray-700 text-right w-48">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-3 text-center text-gray-500"><?php echo e($index + 1); ?></td>
                            <td class="px-4 py-3 font-bold text-gray-900"><?php echo e($item->item_name); ?></td>
                            <td class="px-4 py-3 text-center text-gray-600"><?php echo e(number_format($item->quantity, 1, ',', '')); ?> <?php echo e($item->unit); ?></td>
                            <td class="px-4 py-3 text-right text-gray-600">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                            <td class="px-4 py-3 text-right font-bold text-gray-900">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Item pekerjaan belum diisi.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="flex justify-end">
            <div class="w-full sm:w-1/2 md:w-1/3">
                <div class="flex justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-500 font-bold">Subtotal</span>
                    <span class="font-bold text-gray-900">Rp <?php echo e(number_format($invoice->amount, 0, ',', '.')); ?></span>
                </div>
                <div class="flex justify-between py-4 mt-2 bg-red-50/50 rounded-xl px-4 border border-red-100">
                    <span class="font-black text-gray-900 uppercase">Total Tagihan</span>
                    <span class="font-black text-[#DD3517] text-lg">Rp <?php echo e(number_format($invoice->amount, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/admin/invoices/show.blade.php ENDPATH**/ ?>