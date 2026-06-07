

<?php $__env->startSection('title', 'PT. Sinom Jati Mas - General Contractor & Trading'); ?>
<?php $__env->startSection('meta_description', 'PT. Sinom Jati Mas - General Contractor & General Trading. Trusted, professional construction solutions.'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials.public.home-hero', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.public.company-intro-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section id="projects" class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <?php echo $__env->make('partials.public.section-heading', [
                'eyebrow' => 'Our Projects',
                'title' => 'Project Gallery',
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('partials.public.project-carousel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </section>

    <?php echo $__env->make('partials.public.partners-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/landing.blade.php ENDPATH**/ ?>