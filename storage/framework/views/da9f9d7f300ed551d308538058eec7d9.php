

<?php $__env->startSection('title', 'Services - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'PT. Sinom Jati Mas services - General Contractor, General Trading, and Cut and Fill.'); ?>

<?php $__env->startSection('content'); ?>
    <section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e(asset('images/landing/hero-bg.png')); ?>');"></div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">Our Services</p>
            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">What We Offer</h1>
            <p class="mx-auto mt-6 max-w-3xl text-base text-white/90 sm:text-lg">
                Integrated solutions for your construction and trading project needs.
            </p>
        </div>
    </section>

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-5">
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $serviceSlug = \Illuminate\Support\Str::slug($service->name);
                        $iconClass = 'fa-screwdriver-wrench';
                        if (str_contains($serviceSlug, 'contractor')) {
                            $iconClass = 'fa-road';
                        } elseif (str_contains($serviceSlug, 'trading')) {
                            $iconClass = 'fa-house-chimney';
                        } elseif (str_contains($serviceSlug, 'cut') || str_contains($serviceSlug, 'fill')) {
                            $iconClass = 'fa-mountain';
                        }
                    ?>
                    <article class="flex gap-5 rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:gap-6 sm:p-7">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-orange-50 ring-2 ring-orange-200">
                            <?php if(!empty($service->icon)): ?>
                                <img src="<?php echo e(asset('storage/' . $service->icon)); ?>" alt="<?php echo e($service->name); ?>" class="h-full w-full object-cover">
                            <?php else: ?>
                                <i class="fa-solid <?php echo e($iconClass); ?> text-2xl text-brand"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 sm:text-2xl"><?php echo e($service->name); ?></h3>
                            <p class="mt-3 text-sm leading-relaxed text-gray-600 sm:text-base"><?php echo e($service->description); ?></p>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <article class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-8 text-center text-gray-500">
                        No services available yet.
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/service.blade.php ENDPATH**/ ?>