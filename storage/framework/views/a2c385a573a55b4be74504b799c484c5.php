

<?php $__env->startSection('title', 'About Us - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'About PT. Sinom Jati Mas - Vision, mission, and company profile.'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials.public.page-hero', [
        'eyebrow' => 'About Us',
        'title' => $companyProfile?->displayName(),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-base leading-relaxed text-gray-600 sm:text-lg">
                <?php echo e($companyProfile?->about_us ?? 'PT. Sinom Jati Mas operates in General Contractor, Cut and Fill, and General Trading.'); ?>

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
                    <h2 class="text-3xl font-bold md:text-4xl">Vision</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->vision ?? 'To become a sustainable national company that grows rapidly and responsibly.'); ?></p>
                    <h2 class="mt-10 text-3xl font-bold md:text-4xl">Mission</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->mission ?? 'To strengthen competitiveness through excellent service and modern technology on every project.'); ?></p>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/about.blade.php ENDPATH**/ ?>