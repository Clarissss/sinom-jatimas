<section class="w-full overflow-hidden <?php echo e($ctaClass ?? ''); ?>">
    <div class="relative w-full">
        <img
            src="<?php echo e(asset('images/landing/proyek-1.png')); ?>"
            alt=""
            class="w-full object-cover object-center"
            style="max-height: 20rem;"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent"></div>
        <div class="absolute bottom-0 left-0 max-w-xl px-6 pb-6 pt-16 text-left sm:px-10 sm:pb-8 lg:px-16">
            <p class="text-lg font-bold leading-tight text-white sm:text-xl">Trusted. Precise. Professional.</p>
            <p class="mt-1 text-sm text-white/90 sm:text-base">
                Build Better with <?php echo e($companyProfile?->company_name ?? 'PT. Sinom Jati Mas'); ?>

            </p>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/cta-banner.blade.php ENDPATH**/ ?>