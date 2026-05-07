<?php $__env->startSection('title', 'Register - PT. Sinom Jati Mas'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Reset Background Luar */
    .bg-main-wrapper {
        background-color: #f8fafc; /* Warna dasar abu-abu sangat muda */
    }

    /* Pattern Kertas Arsitektur (Dalam Form) */
    .bg-grid-pattern {
        background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px),
                          linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
        background-size: 24px 24px;
    }

    /* Input Focus Styling */
    .input-group:focus-within label { color: #DD3517; }
    .input-group:focus-within .icon-wrapper {
        color: #DD3517;
        background-color: #fff1eb;
    }

    /* Cursor Animasi Mengetik */
    .cursor-blink {
        display: inline-block;
        width: 3px;
        height: 1.1em;
        background-color: #DD3517;
        vertical-align: text-bottom;
        margin-left: 2px;
        animation: blink 1s step-end infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }
    
    /* Canvas Layer untuk Efek Partikel */
    #particle-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0; /* Berada paling belakang */
    }
</style>


<canvas id="particle-canvas"></canvas>


<div class="min-h-screen w-full flex items-center justify-center bg-transparent p-4 sm:p-8 relative z-10 pointer-events-none">
    
    
    <div class="flex w-full max-w-5xl bg-white rounded-[2rem] shadow-2xl shadow-gray-300/80 overflow-hidden min-h-[650px] border border-gray-100 pointer-events-auto relative">
        
        
        <div class="hidden lg:flex w-1/2 relative flex-col justify-center px-12 py-16 bg-gray-900">
            <img src="https://images.unsplash.com/photo-1541888086425-d81bb19240f5?q=80&w=2070&auto=format&fit=crop" 
                 alt="Konstruksi Profesional" 
                 class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay hover:scale-105 transition-transform duration-[15s] ease-out">
            
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>

            <div class="relative z-10 w-full">
                <div class="w-16 h-16 bg-[#DD3517] rounded-2xl flex items-center justify-center shadow-lg shadow-[#DD3517]/30 mb-8">
                    <i class="fa-solid fa-handshake text-white text-3xl"></i>
                </div>
                
                
                <h1 class="text-4xl font-black text-white leading-tight mb-4 min-h-[90px]">
                    <span id="type-line-1"></span><span id="cursor1" class="cursor-blink"></span><br>
                    <span id="type-line-2" class="text-[#DD3517]"></span><span id="cursor2" class="cursor-blink" style="display:none;"></span>
                </h1>
                
                <p class="text-gray-300 text-base font-medium leading-relaxed mb-8 opacity-0 transition-opacity duration-1000" id="fade-text">
                    Bergabunglah bersama kami sebagai mitra proyek terpercaya. Kami menghadirkan transparansi dan kualitas di setiap tahap pembangunan.
                </p>
                
                <div class="inline-flex items-center space-x-3 bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/20 opacity-0 transition-opacity duration-1000" id="fade-badge">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>
                    <span class="text-sm font-bold text-white tracking-wide">Pendaftaran Klien Resmi</span>
                </div>
            </div>
        </div>

        
        <div class="w-full lg:w-1/2 flex items-center justify-center relative bg-white bg-grid-pattern overflow-y-auto px-6 py-10 lg:px-12">
            
            <div class="w-full max-w-md relative z-10">
                
                
                <div class="lg:hidden flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-[#DD3517] rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-building text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-900 tracking-tight">SINOM JATI MAS</h2>
                        <p class="text-[11px] text-gray-500 uppercase font-bold tracking-widest">Portal Registrasi</p>
                    </div>
                </div>

                
                <div class="mb-8 lg:mt-0 mt-2">
                    <h2 class="text-3xl font-black text-gray-900 mb-2">Daftar Akun</h2>
                    <p class="text-gray-500 font-medium text-sm">Lengkapi data di bawah untuk membuat profil klien Anda.</p>
                </div>

                
                <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5" x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                    <?php echo csrf_field(); ?>
                    
                    
                    <div class="input-group group">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1.5 transition-colors">Nama Lengkap / Perusahaan</label>
                        <div class="relative flex items-center">
                            <div class="icon-wrapper absolute left-1.5 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 bg-gray-50 transition-all duration-300">
                                <i class="fa-regular fa-user text-sm"></i>
                            </div>
                            <input id="name" name="name" type="text" required autocomplete="name"
                                   class="block w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#DD3517]/20 focus:border-[#DD3517] transition-all font-medium <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('name')); ?>" placeholder="PT Sumber Berkah">
                        </div>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-500 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> <?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="input-group group">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5 transition-colors">Alamat Email</label>
                        <div class="relative flex items-center">
                            <div class="icon-wrapper absolute left-1.5 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 bg-gray-50 transition-all duration-300">
                                <i class="fa-solid fa-at text-sm"></i>
                            </div>
                            <input id="email" name="email" type="email" required autocomplete="email"
                                   class="block w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#DD3517]/20 focus:border-[#DD3517] transition-all font-medium <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('email')); ?>" placeholder="kontak@perusahaan.com">
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-500 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> <?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="input-group group">
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-1.5 transition-colors">Nomor Telepon / HP</label>
                        <div class="relative flex items-center">
                            <div class="icon-wrapper absolute left-1.5 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 bg-gray-50 transition-all duration-300">
                                <i class="fa-solid fa-phone text-sm"></i>
                            </div>
                            <input id="phone" name="phone" type="text" required
                                   class="block w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#DD3517]/20 focus:border-[#DD3517] transition-all font-medium <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('phone')); ?>" placeholder="08123456789">
                        </div>
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-sm text-red-500 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> <?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <div class="input-group group" x-data="{ show: false }">
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5 transition-colors">Kata Sandi</label>
                            <div class="relative flex items-center">
                                <div class="icon-wrapper absolute left-1.5 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 bg-gray-50 transition-all duration-300">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input id="password" name="password" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                                       class="block w-full pl-14 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#DD3517]/20 focus:border-[#DD3517] transition-all font-medium <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="••••••••">
                                <button type="button" @click="show = !show" class="absolute right-2 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-all">
                                    <i x-show="!show" class="fa-regular fa-eye"></i>
                                    <i x-show="show" class="fa-regular fa-eye-slash" style="display: none;"></i>
                                </button>
                            </div>
                        </div>

                        
                        <div class="input-group group" x-data="{ show: false }">
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1.5 transition-colors">Ulangi Sandi</label>
                            <div class="relative flex items-center">
                                <div class="icon-wrapper absolute left-1.5 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 bg-gray-50 transition-all duration-300">
                                    <i class="fa-solid fa-check-double text-sm"></i>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                                       class="block w-full pl-14 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#DD3517]/20 focus:border-[#DD3517] transition-all font-medium"
                                       placeholder="••••••••">
                                <button type="button" @click="show = !show" class="absolute right-2 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-all">
                                    <i x-show="!show" class="fa-regular fa-eye"></i>
                                    <i x-show="show" class="fa-regular fa-eye-slash" style="display: none;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-500 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> <?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    
                    <button type="submit" :disabled="loading" 
                            class="relative w-full overflow-hidden flex justify-center items-center py-4 px-4 rounded-2xl text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl group mt-6">
                        
                        <div class="absolute inset-0 w-0 bg-[#DD3517] transition-all duration-500 ease-out group-hover:w-full z-0"></div>
                        
                        <div class="relative z-10 flex items-center">
                            <i x-show="loading" class="fa-solid fa-circle-notch fa-spin mr-2" style="display: none;"></i>
                            <span x-text="loading ? 'Memproses Pendaftaran...' : 'Daftarkan Perusahaan'"></span>
                            <i x-show="!loading" class="fa-solid fa-user-check ml-2 transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </button>
                </form>

                
                <div class="mt-8 text-center border-t border-gray-100 pt-6">
                    <p class="text-sm text-gray-500 font-medium">
                        Sudah memiliki akun? 
                        <a href="<?php echo e(route('login')); ?>" class="font-bold text-[#DD3517] hover:opacity-80 transition-opacity ml-1">
                            Masuk di sini
                        </a>
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ==========================================
        // 1. TYPEWRITER ANIMATION
        // ==========================================
        const line1 = "Mari Bangun Relasi,";
        const line2 = "Wujudkan Mahakarya.";
        const typeSpeed = 70;
        const deleteSpeed = 30;
        const delayBetween = 3000;
        
        const el1 = document.getElementById("type-line-1");
        const el2 = document.getElementById("type-line-2");
        const cursor1 = document.getElementById("cursor1");
        const cursor2 = document.getElementById("cursor2");
        let isFirstCycle = true;

        const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

        async function typeWriterLoop() {
            while(true) {
                cursor1.style.display = 'inline-block';
                cursor2.style.display = 'none';
                for(let i = 0; i <= line1.length; i++) {
                    el1.innerHTML = line1.substring(0, i);
                    await sleep(typeSpeed);
                }

                cursor1.style.display = 'none';
                cursor2.style.display = 'inline-block';
                for(let i = 0; i <= line2.length; i++) {
                    el2.innerHTML = line2.substring(0, i);
                    await sleep(typeSpeed);
                }

                if(isFirstCycle) {
                    document.getElementById("fade-text").classList.remove('opacity-0');
                    document.getElementById("fade-badge").classList.remove('opacity-0');
                    isFirstCycle = false;
                }

                await sleep(delayBetween);

                for(let i = line2.length; i >= 0; i--) {
                    el2.innerHTML = line2.substring(0, i);
                    await sleep(deleteSpeed);
                }

                cursor1.style.display = 'inline-block';
                cursor2.style.display = 'none';
                for(let i = line1.length; i >= 0; i--) {
                    el1.innerHTML = line1.substring(0, i);
                    await sleep(deleteSpeed);
                }

                await sleep(500);
            }
        }
        
        setTimeout(typeWriterLoop, 500);

        // ==========================================
        // 2. PARTICLE NETWORK ANIMATION (SOLID)
        // ==========================================
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particlesArray;

        window.addEventListener('resize', function() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            init();
        });

        class Particle {
            constructor(x, y, directionX, directionY, size, color) {
                this.x = x;
                this.y = y;
                this.directionX = directionX;
                this.directionY = directionY;
                this.size = size;
                this.color = color;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
                ctx.fillStyle = this.color;
                ctx.fill();
            }
            update() {
                if (this.x > canvas.width || this.x < 0) this.directionX = -this.directionX;
                if (this.y > canvas.height || this.y < 0) this.directionY = -this.directionY;

                this.x += this.directionX;
                this.y += this.directionY;
                this.draw();
            }
        }

        function init() {
            particlesArray = [];
            let numberOfParticles = (canvas.height * canvas.width) / 12000;
            for (let i = 0; i < numberOfParticles; i++) {
                let size = (Math.random() * 2) + 1;
                let x = (Math.random() * ((innerWidth - size * 2) - (size * 2)) + size * 2);
                let y = (Math.random() * ((innerHeight - size * 2) - (size * 2)) + size * 2);
                let directionX = (Math.random() * 1) - 0.5; 
                let directionY = (Math.random() * 1) - 0.5; 
                let color = '#cbd5e1'; 

                particlesArray.push(new Particle(x, y, directionX, directionY, size, color));
            }
        }

        function connect() {
            let opacityValue = 1;
            for (let a = 0; a < particlesArray.length; a++) {
                for (let b = a; b < particlesArray.length; b++) {
                    let distance = ((particlesArray[a].x - particlesArray[b].x) * (particlesArray[a].x - particlesArray[b].x))
                                 + ((particlesArray[a].y - particlesArray[b].y) * (particlesArray[a].y - particlesArray[b].y));
                    
                    if (distance < (canvas.width/7) * (canvas.height/7)) {
                        opacityValue = 1 - (distance/20000);
                        ctx.strokeStyle = 'rgba(221, 53, 23,' + opacityValue + ')';
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
                        ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
                        ctx.stroke();
                    }
                }
            }
        }

        function animate() {
            requestAnimationFrame(animate);
            ctx.clearRect(0, 0, innerWidth, innerHeight);
            
            for (let i = 0; i < particlesArray.length; i++) {
                particlesArray[i].update();
            }
            connect();
        }

        init();
        animate();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/auth/register.blade.php ENDPATH**/ ?>