

<?php $__env->startSection('title', 'About Us - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'Tentang PT. Sinom Jati Mas - Visi, Misi, dan profil perusahaan.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .about-stack img {
        border-radius: 1.25rem;
        border: 3px solid rgba(0, 0, 0, 0.25);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }
    .about-stack .stack-1 { width: 220px; height: 280px; object-fit: cover; }
    .about-stack .stack-2 { width: 240px; height: 300px; object-fit: cover; margin-left: 3.5rem; margin-top: -3rem; }
    .about-stack .stack-3 { width: 260px; height: 320px; object-fit: cover; margin-left: 7rem; margin-top: -3rem; }
    .dot-grid { display: grid; grid-template-columns: repeat(6, 6px); gap: 6px; }
    .dot-grid span { width: 6px; height: 6px; border-radius: 9999px; background: rgba(255, 255, 255, 0.85); }
    @media (max-width: 1023px) {
        .about-stack { display: flex; flex-direction: column; gap: 1rem; align-items: center; }
        .about-stack .stack-1, .about-stack .stack-2, .about-stack .stack-3 {
            width: 100%; max-width: 280px; height: 200px; margin-left: 0; margin-top: 0;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e(asset('images/landing/hero-bg.png')); ?>');"></div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">Tentang Kami</p>
            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl"><?php echo e($companyProfile?->company_name ?? 'PT. Sinom Jati Mas'); ?></h1>
        </div>
    </section>

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-base leading-relaxed text-gray-600 sm:text-lg">
                <?php echo e($companyProfile?->about_us ?? 'PT. Sinom Jati Mas bergerak di bidang General Contractor, Cut and Fill, serta General Trading.'); ?>

            </p>
            <div class="mt-10 grid gap-8 sm:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                    <p class="text-3xl font-bold text-brand"><?php echo e($yearsOfExperience); ?>+</p>
                    <p class="mt-1 text-sm font-medium text-gray-600">Years of Experience</p>
                </div>
                <?php echo $__env->make('partials.public.project-stat-card', ['variant' => 'about'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </section>

    <section class="mb-12 overflow-visible bg-brand py-16 pb-28 text-white lg:mb-16 lg:py-24 lg:pb-36">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-16 lg:grid-cols-2 lg:gap-20">
                <div class="relative order-2 mt-12 lg:order-1 lg:mt-0">
                    <div class="dot-grid absolute -left-2 top-0 hidden lg:grid">
                        <?php for($i = 0; $i < 18; $i++): ?><span></span><?php endfor; ?>
                    </div>
                    <div class="about-stack relative mx-auto max-w-md lg:mx-0">
                        <?php
                            $aboutImages = [$companyProfile?->about_image_1, $companyProfile?->about_image_2, $companyProfile?->about_image_3];
                            $aboutDefaults = [asset('images/landing/hero-bg.png'), asset('images/landing/proyek-1.png'), asset('images/landing/hero-bg.png')];
                        ?>
                        <?php $__currentLoopData = $aboutImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imagePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img
                                src="<?php echo e($imagePath && $companyProfile ? $companyProfile->imageUrl($imagePath) : $aboutDefaults[$index]); ?>"
                                alt="About <?php echo e($index + 1); ?>"
                                class="stack-<?php echo e($index + 1); ?>"
                            >
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="dot-grid absolute bottom-0 right-4 hidden lg:grid">
                        <?php for($i = 0; $i < 21; $i++): ?><span></span><?php endfor; ?>
                    </div>
                </div>
                <div class="order-1 lg:order-2 lg:pb-4">
                    <h2 class="text-3xl font-bold md:text-4xl">Visi</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->vision ?? 'Menjadi perusahaan nasional yang berkelanjutan dan berkembang pesat.'); ?></p>
                    <h2 class="mt-10 text-3xl font-bold md:text-4xl">Misi</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->mission ?? 'Meningkatkan daya saing perusahaan melalui pelayanan prima dan teknologi mutakhir.'); ?></p>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/about.blade.php ENDPATH**/ ?>