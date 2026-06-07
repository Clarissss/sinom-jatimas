<section class="bg-white py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <?php echo $__env->make('partials.public.section-heading', [
            'eyebrow' => 'Trusted By',
            'title' => 'Our Partners',
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $partners->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex flex-col items-center gap-4 text-center">
                    <?php if(!empty($partner->logo)): ?>
                        <img
                            src="<?php echo e(asset('storage/' . $partner->logo)); ?>"
                            alt="<?php echo e($partner->name); ?>"
                            class="h-60 w-full rounded-2xl bg-gray-50 object-contain p-4 shadow-md transition duration-500 hover:scale-[1.02]"
                        >
                    <?php else: ?>
                        <div class="flex h-60 w-full items-center justify-center rounded-2xl bg-gray-50 text-brand shadow-md">
                            <i class="fa-solid fa-building text-5xl" aria-hidden="true"></i>
                        </div>
                    <?php endif; ?>
                    <p class="text-lg font-semibold text-gray-900"><?php echo e($partner->name); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="col-span-full text-center text-gray-500">Partner data is not available yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/partners-section.blade.php ENDPATH**/ ?>