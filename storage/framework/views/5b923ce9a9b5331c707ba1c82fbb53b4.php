

<?php $__env->startSection('title', 'About Us - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'Tentang PT. Sinom Jati Mas - Visi, Misi, dan profil perusahaan.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .about-stack img {
        display: block;
        border-radius: 1.5rem;
        border: 3px solid rgba(0, 0, 0, 0.2);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.22);
        overflow: hidden;
    }
    .about-stack .stack-1 { width: 190px; height: 250px; object-fit: cover; border-radius: 1.5rem; }
    .about-stack .stack-2 { width: 210px; height: 270px; object-fit: cover; margin-left: 3rem; margin-top: -2.5rem; border-radius: 1.5rem; }
    .about-stack .stack-3 { width: 230px; height: 290px; object-fit: cover; margin-left: 6rem; margin-top: -2.5rem; border-radius: 1.5rem; }
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
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">About Us</p>
            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl"><?php echo e($companyProfile?->company_name ?? 'PT. Sinom Jati Mas'); ?></h1>
        </div>
    </section>

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 sm:mb-10 sm:text-3xl">Building a Vision into Reality</h2>
            <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,260px)_1fr] lg:gap-10">
                <img
                    src="<?php echo e($companyProfile?->about_image_1 ? $companyProfile->imageUrl($companyProfile->about_image_1) : asset('images/landing/about-intro.jpg')); ?>"
                    alt="Construction at <?php echo e($companyProfile?->company_name ?? 'PT. Sinom Jati Mas'); ?>"
                    class="mx-auto w-full max-w-[220px] rounded-2xl object-cover shadow-md sm:max-w-[240px] lg:mx-0 lg:max-w-[260px] lg:min-h-[320px]"
                >
                <div class="text-left text-sm leading-relaxed text-gray-500 sm:text-base">
                    <p><?php echo nl2br(e($companyProfile?->about_us ?? 'PT. Sinom Jati Mas bergerak di bidang General Contractor, Cut and Fill, serta General Trading. Kami berkomitmen memberikan solusi konstruksi terpercaya, tepat waktu, dan berkualitas untuk mitra bisnis di seluruh Indonesia.')); ?></p>
                </div>
            </div>

            <div class="mx-auto mt-14 max-w-4xl border-t border-gray-100 pt-10">
                <div class="grid gap-10 sm:grid-cols-2 sm:gap-8">
                    <div class="flex flex-col items-center text-center">
                        <p class="text-3xl font-bold tabular-nums text-brand"><?php echo e($yearsOfExperience); ?><span class="text-secondary-500">+</span></p>
                        <p class="mt-1 text-sm font-medium text-gray-600">Years of Experience</p>
                    </div>
                    <?php echo $__env->make('partials.public.project-stat-card', ['variant' => 'landing'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-8 overflow-visible bg-brand py-12 pb-16 text-white lg:mb-12 lg:py-16 lg:pb-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-12">
                <div class="relative order-2 mt-8 lg:order-1 lg:mt-0">
                    <div class="dot-grid absolute -left-2 top-0 hidden lg:grid">
                        <?php for($i = 0; $i < 18; $i++): ?><span></span><?php endfor; ?>
                    </div>
                    <div class="about-stack relative mx-auto max-w-sm lg:mx-0">
                        <?php
                            $aboutImages = [$companyProfile?->about_image_1, $companyProfile?->about_image_2, $companyProfile?->about_image_3];
                            $aboutDefaults = [
                                asset('images/landing/about-1.jpg'),
                                asset('images/landing/about-2.jpg'),
                                asset('images/landing/about-3.jpg'),
                            ];
                        ?>
                        <?php $__currentLoopData = $aboutImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imagePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img
                                src="<?php echo e($imagePath && $companyProfile ? $companyProfile->imageUrl($imagePath) : $aboutDefaults[$index]); ?>"
                                alt="About <?php echo e($index + 1); ?>"
                                class="stack-<?php echo e($index + 1); ?> rounded-2xl"
                            >
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="dot-grid absolute bottom-0 right-4 hidden lg:grid">
                        <?php for($i = 0; $i < 21; $i++): ?><span></span><?php endfor; ?>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="text-2xl font-bold md:text-3xl">Visi</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->vision ?? 'Menjadi perusahaan nasional yang berkelanjutan dan berkembang pesat.'); ?></p>
                    <h2 class="mt-8 text-2xl font-bold md:text-3xl">Misi</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->mission ?? 'Meningkatkan daya saing perusahaan melalui pelayanan prima dan teknologi mutakhir.'); ?></p>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/about.blade.php ENDPATH**/ ?>