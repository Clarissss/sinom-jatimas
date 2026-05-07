<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-800 tracking-tight">
                    <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                </h1>
            </div>
            
            
            <div class="flex items-center space-x-4">
                <?php if(auth()->guard()->check()): ?>
                    <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 focus:outline-none rounded-lg p-2 hover:bg-gray-100 transition-colors"
                                aria-expanded="false"
                                aria-haspopup="true"
                                :aria-expanded="open.toString()">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-gray-900"><?php echo e(auth()->user()->name); ?></p>
                                <p class="text-xs text-gray-500 capitalize"><?php echo e(auth()->user()->role); ?></p>
                            </div>
                            <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-primary-200 shadow-md"
                                 aria-hidden="true">
                                <img src="<?php echo e(auth()->user()->photo_url); ?>" 
                                     alt="<?php echo e(auth()->user()->name); ?>"
                                     class="w-full h-full object-cover">
                            </div>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-sm transition-transform" 
                               :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-100"
                             style="display: none;"
                             role="menu"
                             aria-orientation="vertical"
                             aria-labelledby="user-menu">
                            
                            
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full overflow-hidden border border-gray-200">
                                        <img src="<?php echo e(auth()->user()->photo_url); ?>" 
                                             alt="<?php echo e(auth()->user()->name); ?>"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate"><?php echo e(auth()->user()->name); ?></p>
                                        <p class="text-xs text-gray-500 truncate"><?php echo e(auth()->user()->email); ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <a href="<?php echo e(route('profile.edit')); ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary-600 transition-colors"
                               role="menuitem">
                                <i class="fa-regular fa-user w-4 mr-3 text-gray-400"></i>
                                Profil
                            </a>
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <button onclick="document.getElementById('logout-form').submit()" 
                                    class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                    role="menuitem">
                                <i class="fa-solid fa-arrow-right-from-bracket w-4 mr-3"></i>
                                Keluar
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/layouts/partials/navbar.blade.php ENDPATH**/ ?>