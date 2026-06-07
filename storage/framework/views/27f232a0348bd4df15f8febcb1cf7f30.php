<?php
    $maxWidth = $maxWidth ?? 'max-w-7xl';
    $overlay = $overlay ?? 'bg-black/60';
?>

<section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e(asset('images/landing/hero-bg.png')); ?>');"></div>
    <div class="absolute inset-0 <?php echo e($overlay); ?>"></div>
    <div class="relative mx-auto <?php echo e($maxWidth); ?> px-4 text-center sm:px-6 lg:px-8">
        <?php if(!empty($eyebrow)): ?>
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80"><?php echo e($eyebrow); ?></p>
        <?php endif; ?>
        <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl"><?php echo e($title); ?></h1>
        <?php if(!empty($subtitle)): ?>
            <p class="mx-auto mt-6 max-w-3xl text-base text-white/90 sm:text-lg"><?php echo e($subtitle); ?></p>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/page-hero.blade.php ENDPATH**/ ?>