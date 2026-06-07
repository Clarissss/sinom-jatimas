

<?php $__env->startSection('title', 'Services - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'PT. Sinom Jati Mas services - General Contractor, General Trading, and Cut and Fill.'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials.public.page-hero', [
        'eyebrow' => 'Our Services',
        'title' => 'What We Offer',
        'subtitle' => 'Integrated solutions for your construction and trading project needs.',
        'maxWidth' => 'max-w-5xl',
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <?php echo $__env->make('partials.public.service-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/service.blade.php ENDPATH**/ ?>