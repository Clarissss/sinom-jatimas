

<?php $__env->startSection('title', 'About Us - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'Tentang PT. Sinom Jati Mas - Visi, Misi, dan profil perusahaan.'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials.public.page-hero', [
        'eyebrow' => 'About Us',
        'title' => $companyProfile?->displayName(),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('partials.public.about-intro', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.public.about-vision-mission', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/about.blade.php ENDPATH**/ ?>