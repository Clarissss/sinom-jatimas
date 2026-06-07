<div class="grid gap-10 sm:grid-cols-2 sm:gap-8">
    <div class="flex flex-col items-center text-center">
        <p class="text-3xl font-bold tabular-nums text-brand"><?php echo e($yearsOfExperience); ?><span class="text-secondary-500">+</span></p>
        <p class="mt-1 text-sm font-medium text-gray-600">Years of Experience</p>
    </div>
    <?php echo $__env->make('partials.public.project-stat-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/company-stats.blade.php ENDPATH**/ ?>