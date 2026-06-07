<section class="bg-white py-14 lg:py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <h2 class="mb-8 text-2xl font-bold text-gray-900 sm:mb-10 sm:text-3xl">Building a Vision into Reality</h2>

        <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,260px)_1fr] lg:gap-10">
            <img
                src="<?php echo e($companyProfile?->aboutImageUrl('about_image_1', 'images/landing/about-intro.jpg')); ?>"
                alt="Construction at <?php echo e($companyProfile?->displayName()); ?>"
                class="mx-auto w-full max-w-[220px] rounded-2xl object-cover shadow-md sm:max-w-[240px] lg:mx-0 lg:max-w-[260px] lg:min-h-[320px]"
            >
            <div class="text-left text-sm leading-relaxed text-gray-500 sm:text-base">
                <p><?php echo nl2br(e($companyProfile?->about_us ?? 'PT. Sinom Jati Mas bergerak di bidang General Contractor, Cut and Fill, serta General Trading. Kami berkomitmen memberikan solusi konstruksi terpercaya, tepat waktu, dan berkualitas untuk mitra bisnis di seluruh Indonesia.')); ?></p>
            </div>
        </div>

        <div class="mx-auto mt-14 max-w-4xl border-t border-gray-100 pt-10">
            <?php echo $__env->make('partials.public.company-stats', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/about-intro.blade.php ENDPATH**/ ?>