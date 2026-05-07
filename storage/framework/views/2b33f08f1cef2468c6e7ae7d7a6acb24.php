<?php $__env->startSection('title', 'Reset Password - PT. Sinom Jati Mas'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Latar Belakang Luar Card */
    .bg-main-wrapper {
        background-color: #f8fafc;
        background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
        background-size: 32px 32px;
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
        z-index: 0;
    }
</style>


<canvas id="particle-canvas"></canvas>


<div class="min-h-screen w-full flex items-center justify-center bg-transparent p-4 sm:p-8 relative z-10 pointer-events-none">
    
    
    <div class="flex w-full max-w-5xl bg-white rounded-[2rem] shadow-2xl shadow-gray-300/80 overflow-hidden min-h-[600px] border border-gray-100 pointer-events-auto relative">
        
        
        <div class="hidden lg:flex w-1/2 relative flex-col justify-center px-12 py-16 bg-gray-900">
            <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=2071&auto=format&fit=crop" 
                 alt="Keamanan Sistem" 
                 class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay hover:scale-105 transition-transform duration-[15s] ease-out">
            
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>

            <div class="relative z-10 w-full">
                <div class="w-16 h-16 bg-[#DD3517] rounded-2xl flex items-center justify-center shadow-lg shadow-[#DD3517]/30 mb-8">
                    <i class="fa-solid fa-shield-halved text-white text-3xl"></i>
                </div>
                
                
                <h1 class="text-4xl font-black text-white leading-tight mb-4 min-h-[90px]">
                    <span id="type-line-1"></span><span id="cursor1" class="cursor-blink"></span><br>
                    <span id="type-line-2" class="text-[#DD3517]"></span><span id="cursor2" class="cursor-blink" style="display:none;"></span>
                </h1>
                
                <p class="text-gray-300 text-base font-medium leading-relaxed mb-8 opacity-0 transition-opacity duration-1000" id="fade-text">
                    Kami memprioritaskan keamanan data Anda. Ikuti prosedur pemulihan akun untuk kembali ke dalam sistem dengan aman.
                </p>
                
                <div class="inline-flex items-center space-x-3 bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/20 opacity-0 transition-opacity duration-1000" id="fade-badge">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>
                    <span class="text-sm font-bold text-white tracking-wide">Protokol Keamanan Aktif</span>
                </div>
            </div>
        </div>

        
        <div class="w-full lg:w-1/2 flex items-center justify-center relative bg-white bg-grid-pattern overflow-y-auto px-6 py-12 lg:px-12">
            
            <div class="w-full max-w-md relative z-10">
                
                
                <div class="lg:hidden flex items-center space-x-4 mb-10">
                    <div class="w-12 h-12 bg-[#DD3517] rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-building text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-900 tracking-tight">SINOM JATI MAS</h2>
                        <p class="text-[11px] text-gray-500 uppercase font-bold tracking-widest">Pemulihan Akun</p>
                    </div>
                </div>

                
                <div class="mb-8 lg:mt-0 mt-4">
                    <h2 class="text-3xl font-black text-gray-900 mb-2">Pulihkan Akun</h2>
                    <p class="text-gray-500 font-medium text-sm leading-relaxed">Masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>
                </div>

                
                <?php if(session('status')): ?>
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3.5 rounded-2xl flex items-start text-sm font-medium shadow-sm animate-fade-in-up">
                        <i class="fa-solid fa-circle-check mt-0.5 mr-3 text-green-500"></i>
                        <span><?php echo e(session('status')); ?></span>
                    </div>
                <?php endif; ?>

                
                <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-6" x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                    <?php echo csrf_field(); ?>
                    
                    
                    <div class="input-group group">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2 transition-colors">Alamat Email Terdaftar</label>
                        <div class="relative flex items-center">
                            <div class="icon-wrapper absolute left-1.5 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 bg-gray-50 transition-all duration-300">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </div>
                            <input id="email" name="email" type="email" required autofocus
                                   class="block w-full pl-14 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#DD3517]/20 focus:border-[#DD3517] transition-all font-medium <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('email')); ?>" placeholder="admin@sinomjatimas.com">
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-500 font-medium flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> <?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <button type="submit" :disabled="loading" 
                            class="relative w-full overflow-hidden flex justify-center items-center py-4 px-4 rounded-2xl text-sm font-bold text-white bg-gray-900 hover:bg-gray-800 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl group mt-8">
                        
                        <div class="absolute inset-0 w-0 bg-[#DD3517] transition-all duration-500 ease-out group-hover:w-full z-0"></div>
                        
                        <div class="relative z-10 flex items-center">
                            <i x-show="loading" class="fa-solid fa-circle-notch fa-spin mr-2" style="display: none;"></i>
                            <span x-text="loading ? 'Mengirim Tautan...' : 'Kirim Tautan Pemulihan'"></span>
                            <i x-show="!loading" class="fa-regular fa-paper-plane ml-2 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1"></i>
                        </div>
                    </button>
                </form>

                
                <div class="mt-10 text-center border-t border-gray-100 pt-6">
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-[#DD3517] transition-colors group">
                        <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                        Kembali ke halaman Login
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==========================================
        // 1. TYPEWRITER ANIMATION (Penyesuaian Teks)
        // ==========================================
        const line1 = "Akses Terlindungi,";
        const line2 = "Keamanan Terjamin.";
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>