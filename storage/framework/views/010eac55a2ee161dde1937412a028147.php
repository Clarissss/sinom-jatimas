<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT. Sinom Jati Mas - General Contractor & General Trading. Solusi konstruksi terpercaya dan profesional.">
    <meta name="theme-color" content="#dc2626">
    <title>PT. Sinom Jati Mas - General Contractor & Trading</title>
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d' },
                        secondary: { 50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74', 400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c', 800: '#9a3412', 900: '#7c2d12' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        .gradient-text {
            background: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    <!-- Header -->
    <header class="bg-white shadow-sm fixed w-full z-50 transition-all duration-300" id="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-secondary-500 rounded-lg flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-building text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900 tracking-tight">PT. SINOM JATI MAS</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-gray-900 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-gray-100">
                        Login
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="bg-gradient-to-r from-primary-600 to-secondary-500 text-white px-5 py-2.5 rounded-lg font-medium hover:shadow-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-sm">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 bg-gradient-to-br from-gray-900 via-primary-800 to-secondary-600 overflow-hidden">
        <div class="absolute inset-0 hero-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-4xl mx-auto animate-fade-in">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm mb-8">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    General Contractor & Trading Terpercaya
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight animate-slide-up">
                    Solusi Konstruksi <br>
                    <span class="text-secondary-400">Terpercaya & Profesional</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed animate-slide-up" style="animation-delay: 0.1s;">
                    PT. Sinom Jati Mas merupakan perusahaan General Contractor & General Trading 
                    yang berkomitmen memberikan kualitas terbaik untuk setiap proyek.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up" style="animation-delay: 0.2s;">
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center bg-white text-primary-700 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                        <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>
                        Akses Portal Klien
                    </a>
                    <a href="#layanan" class="inline-flex items-center justify-center border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-primary-700 transition-all">
                        <i class="fa-solid fa-circle-info mr-2"></i>
                        Layanan Kami
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-gray-50 to-transparent"></div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-20 lg:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Layanan Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">Solusi Lengkap untuk Proyek Anda</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Kami menyediakan berbagai layanan konstruksi dan perdagangan untuk memenuhi kebutuhan proyek Anda</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-primary-500/30">
                        <i class="fa-solid fa-building text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">General Contractor</h3>
                    <p class="text-gray-600 leading-relaxed">Jasa kontraktor umum untuk berbagai proyek konstruksi sipil, jalan, dan infrastruktur dengan standar kualitas tinggi.</p>
                </div>
                
                <!-- Service 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-secondary-500/30">
                        <i class="fa-solid fa-industry text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Build Steel Structure</h3>
                    <p class="text-gray-600 leading-relaxed">Pembuatan dan pemasangan struktur baja untuk bangunan industrial dan komersial dengan presisi tinggi.</p>
                </div>
                
                <!-- Service 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-green-500/30">
                        <i class="fa-solid fa-boxes-stacked text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">General Trading</h3>
                    <p class="text-gray-600 leading-relaxed">Pengadaan material konstruksi, komponen baja, dan alat berat berkualitas untuk mendukung proyek Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portal Features -->
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Portal Klien</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-6">Pantau Proyek Anda Secara Real-time</h2>
                    <p class="text-gray-600 mb-8 text-lg leading-relaxed">Dapatkan transparansi penuh dalam setiap tahap pengerjaan melalui portal khusus kami. Akses informasi proyek kapan saja, di mana saja.</p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start group">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mt-0.5 mr-3 group-hover:bg-green-200 transition-colors">
                                <i class="fa-solid fa-check text-green-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Monitoring progress proyek 0-100%</span>
                        </li>
                        <li class="flex items-start group">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mt-0.5 mr-3 group-hover:bg-green-200 transition-colors">
                                <i class="fa-solid fa-check text-green-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Dokumentasi visual (Before, Progress, After)</span>
                        </li>
                        <li class="flex items-start group">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mt-0.5 mr-3 group-hover:bg-green-200 transition-colors">
                                <i class="fa-solid fa-check text-green-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Live chat langsung dengan tim proyek</span>
                        </li>
                        <li class="flex items-start group">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mt-0.5 mr-3 group-hover:bg-green-200 transition-colors">
                                <i class="fa-solid fa-check text-green-600 text-sm"></i>
                            </div>
                            <span class="text-gray-700">Akses dokumen proyek & invoice</span>
                        </li>
                    </ul>
                    
                    <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center mt-8 bg-gradient-to-r from-primary-600 to-secondary-500 text-white px-8 py-3.5 rounded-lg font-semibold hover:shadow-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-md">
                        <i class="fa-solid fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </a>
                </div>
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl p-6 lg:p-8">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-gray-900 flex items-center">
                                <i class="fa-solid fa-chart-simple text-primary-600 mr-2"></i>
                                Progress Proyek
                            </h3>
                            <span class="text-primary-600 font-bold text-lg">75%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-8">
                            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-3 rounded-full shadow-sm" style="width: 75%"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="bg-gray-200 rounded-lg p-3 mb-2">
                                    <i class="fa-regular fa-image text-gray-400 text-2xl"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-600">Before</span>
                            </div>
                            <div class="text-center p-4 bg-primary-50 rounded-lg border-2 border-primary-200">
                                <div class="bg-primary-100 rounded-lg p-3 mb-2">
                                    <i class="fa-regular fa-image text-primary-600 text-2xl"></i>
                                </div>
                                <span class="text-xs font-medium text-primary-700">Progress</span>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="bg-gray-200 rounded-lg p-3 mb-2">
                                    <i class="fa-regular fa-image text-gray-400 text-2xl"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-600">After</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-building text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold">PT. SINOM JATI MAS</h3>
                    </div>
                    <p class="text-gray-400 leading-relaxed">General Contractor & General Trading dengan komitmen kuat terhadap kualitas dan profesionalisme kerja.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fa-solid fa-location-dot text-primary-400 flex-shrink-0 mt-0.5 mr-3"></i>
                            <span>Link. Sukarela RT/RW 006/001<br>Kel. Mekarsari Kec. Pulomerak</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fa-regular fa-envelope text-primary-400 flex-shrink-0 mr-3"></i>
                            <a href="mailto:sinomjatimas@gmail.com" class="hover:text-white transition-colors">sinomjatimas@gmail.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fa-brands fa-whatsapp text-primary-400 flex-shrink-0 mr-3"></i>
                            <a href="https://wa.me/6287771300570" target="_blank" class="hover:text-white transition-colors">0877-7130-0570</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Link Cepat</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="<?php echo e(route('login')); ?>" class="text-gray-400 hover:text-white transition-colors flex items-center">
                                <i class="fa-solid fa-arrow-right-to-bracket mr-2 text-sm"></i>
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('register')); ?>" class="text-gray-400 hover:text-white transition-colors flex items-center">
                                <i class="fa-solid fa-user-plus mr-2 text-sm"></i>
                                Daftar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-10 pt-8 text-center">
                <p class="text-gray-500">&copy; <?php echo e(date('Y')); ?> PT. Sinom Jati Mas. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/landing.blade.php ENDPATH**/ ?>