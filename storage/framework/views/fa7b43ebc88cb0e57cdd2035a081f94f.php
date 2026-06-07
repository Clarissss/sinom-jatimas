<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="PT. Sinom Jati Mas Portal - General Contractor & Trading">
    <meta name="theme-color" content="#dc2626">
    <title><?php echo $__env->yieldContent('title', 'PT. Sinom Jati Mas Portal'); ?></title>
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        },
                        secondary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        /* Alpine.js cloak */
        [x-cloak] { display: none !important; }
        
        /* Gradient backgrounds */
        .gradient-bg { 
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%); 
        }
        .gradient-bg-soft { 
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 100%); 
        }
        
        /* Smooth scrolling */
        html { scroll-behavior: smooth; }
        
        /* Focus styles for accessibility */
        *:focus-visible {
            outline: 2px solid #dc2626;
            outline-offset: 2px;
        }
        
        /* Custom scrollbar - Theme colors */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #dc2626, #ea580c);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #b91c1c, #c2410c);
        }
        
        /* Loading spinner */
        .spinner {
            border: 2px solid #f3f4f6;
            border-top: 2px solid #dc2626;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Button loading state */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900" 
      x-data="{ idleTimeout: null }" 
      x-init="
        <?php if(auth()->guard()->check()): ?>
        idleTimeout = setTimeout(() => { 
            alert('Sesi Anda telah berakhir karena tidak ada aktivitas.'); 
            document.getElementById('logout-form').submit(); 
        }, 1800000);
        
        const resetIdleTimeout = () => {
            clearTimeout(idleTimeout);
            idleTimeout = setTimeout(() => { 
                alert('Sesi Anda telah berakhir karena tidak ada aktivitas.'); 
                document.getElementById('logout-form').submit(); 
            }, 1800000);
        };
        
        document.addEventListener('mousemove', resetIdleTimeout);
        document.addEventListener('keypress', resetIdleTimeout);
        document.addEventListener('click', resetIdleTimeout);
        document.addEventListener('scroll', resetIdleTimeout);
        <?php endif; ?>
      ">
    
    
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
        <?php echo csrf_field(); ?>
    </form>

    <?php if(auth()->guard()->check()): ?>
        
        <?php if(auth()->user()->isAdmin()): ?>
            <?php echo $__env->make('layouts.partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('layouts.partials.client-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>

    
    <main class="<?php if(auth()->guard()->check()): ?> ml-64 <?php endif; ?> min-h-screen transition-all duration-300">
        <?php echo $__env->make('layouts.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <div class="p-6 max-w-7xl mx-auto">
            
            <?php if(session('success')): ?>
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     x-init="setTimeout(() => show = false, 5000)" 
                     class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-r shadow-sm relative animate-fade-in" 
                     role="alert"
                     aria-live="polite">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-check text-green-500 mr-2"></i>
                        <span class="font-medium"><?php echo e(session('success')); ?></span>
                    </div>
                    <button @click="show = false" 
                            class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-600 hover:text-green-800 transition-colors"
                            aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     x-init="setTimeout(() => show = false, 5000)" 
                     class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-r shadow-sm relative animate-fade-in" 
                     role="alert"
                     aria-live="polite">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-exclamation text-red-500 mr-2"></i>
                        <span class="font-medium"><?php echo e(session('error')); ?></span>
                    </div>
                    <button @click="show = false" 
                            class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-600 hover:text-red-800 transition-colors"
                            aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            <?php endif; ?>

            
            <?php if($errors->any()): ?>
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="mb-4 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 px-4 py-3 rounded-r shadow-sm relative animate-fade-in" 
                     role="alert">
                    <div class="flex items-start">
                        <i class="fa-solid fa-triangle-exclamation text-yellow-500 mr-2 mt-0.5"></i>
                        <div>
                            <p class="font-medium">Terjadi kesalahan:</p>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" 
                            class="absolute top-0 bottom-0 right-0 px-4 py-3 text-yellow-600 hover:text-yellow-800 transition-colors"
                            aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/layouts/app.blade.php ENDPATH**/ ?>