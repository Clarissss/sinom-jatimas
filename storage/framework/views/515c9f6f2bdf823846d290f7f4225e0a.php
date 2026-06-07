<div class="space-y-5">
    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <article class="flex gap-5 rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:gap-6 sm:p-7">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-orange-50 ring-2 ring-orange-200">
                <?php if($service->iconUrl()): ?>
                    <img src="<?php echo e($service->iconUrl()); ?>" alt="<?php echo e($service->name); ?>" class="h-full w-full object-cover">
                <?php else: ?>
                    <i class="fa-solid <?php echo e($service->fallbackIconClass()); ?> text-2xl text-brand"></i>
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
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/service-list.blade.php ENDPATH**/ ?>