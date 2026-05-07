<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-primary-800 to-primary-900 text-white z-40 overflow-y-auto" aria-label="Client sidebar">
    
    <div class="p-6">
        <a href="<?php echo e(route('client.dashboard')); ?>" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                <i class="fa-solid fa-building text-primary-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold tracking-tight">SINOM JATI MAS</h2>
                <p class="text-xs text-primary-200">Client Portal</p>
            </div>
        </a>
    </div>
    
    
    <nav class="mt-6 px-4 space-y-1" aria-label="Client navigation">
        
        <a href="<?php echo e(route('client.dashboard')); ?>" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('client.dashboard') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm'); ?>"
           aria-current="<?php echo e(request()->routeIs('client.dashboard') ? 'page' : 'false'); ?>">
            <i class="fa-solid fa-house w-5 text-center"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        
        
        <a href="<?php echo e(route('client.documents.index')); ?>" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('client.documents.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm'); ?>"
           aria-current="<?php echo e(request()->routeIs('client.documents.*') ? 'page' : 'false'); ?>">
            <i class="fa-solid fa-file-lines w-5 text-center"></i>
            <span class="font-medium">Dokumen</span>
        </a>
        
        
        <a href="<?php echo e(route('client.invoices.index')); ?>" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('client.invoices.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm'); ?>"
           aria-current="<?php echo e(request()->routeIs('client.invoices.*') ? 'page' : 'false'); ?>">
            <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i>
            <span class="font-medium">Invoice</span>
        </a>
        
        
        <a href="<?php echo e(route('client.daily-reports.index')); ?>" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('client.daily-reports.*') ? 'bg-primary-700 text-white shadow-md' : 'text-primary-100 hover:bg-primary-700 hover:text-white hover:shadow-sm'); ?>"
           aria-current="<?php echo e(request()->routeIs('client.daily-reports.*') ? 'page' : 'false'); ?>">
            <i class="fa-solid fa-clipboard-list w-5 text-center"></i>
            <span class="font-medium">Laporan Harian</span>
        </a>
    </nav>
    
    
    <div class="absolute bottom-0 left-0 right-0 p-4">
        <div class="bg-primary-800/80 backdrop-blur-sm rounded-lg p-3 border border-primary-700">
            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-400 flex-shrink-0">
                    <img src="<?php echo e(auth()->user()->photo_url); ?>" 
                         alt="<?php echo e(auth()->user()->name); ?>"
                         class="w-full h-full object-cover">
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-white truncate"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-xs text-primary-200 truncate"><?php echo e(auth()->user()->email); ?></p>
                </div>
                <i class="fa-solid fa-gear text-primary-300 group-hover:text-white transition-colors"></i>
            </a>
        </div>
    </div>
</aside>
<?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/layouts/partials/client-sidebar.blade.php ENDPATH**/ ?>