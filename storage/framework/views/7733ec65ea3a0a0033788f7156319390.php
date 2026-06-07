<?php
    $stackImages = [
        ['field' => 'about_image_1', 'fallback' => 'images/landing/about-1.jpg', 'class' => 'about-img-1'],
        ['field' => 'about_image_2', 'fallback' => 'images/landing/about-2.jpg', 'class' => 'about-img-2'],
        ['field' => 'about_image_3', 'fallback' => 'images/landing/about-3.jpg', 'class' => 'about-img-3'],
    ];
?>

<?php if (! $__env->hasRenderedOnce('5fc17eee-726a-4714-943d-b923afbc5551')): $__env->markAsRenderedOnce('5fc17eee-726a-4714-943d-b923afbc5551'); ?>
    <?php $__env->startPush('styles'); ?>
    <style>
        .about-gallery {
            position: relative;
            width: 356px;
            max-width: 100%;
            height: 328px;
            margin-inline: auto;
        }
        .about-gallery img {
            position: absolute;
            display: block;
            width: 118px;
            height: 168px;
            object-fit: cover;
            border-radius: 1.25rem;
            border: 3px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.22);
        }
        /* Gambar 1: kiri atas */
        .about-gallery .about-img-1 {
            top: 0;
            left: 0;
        }
        /* Gambar 2: kanan & turun setengah tinggi gambar 1 */
        .about-gallery .about-img-2 {
            top: 80px;
            left: 120px;
        }
        /* Gambar 3: kanan & turun setengah tinggi gambar 2 */
        .about-gallery .about-img-3 {
            top: 160px;
            left: 238px;
        }
        .dot-grid {
            display: grid;
            gap: 7px;
        }
        .dot-grid--cols-5 {
            grid-template-columns: repeat(5, 7px);
        }
        .dot-grid span {
            width: 7px;
            height: 7px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.9);
        }
        @media (min-width: 1024px) {
            .about-gallery {
                max-width: 422px;
                height: 392px;
                margin-inline: 0;
            }
            .about-gallery img {
                width: 138px;
                height: 196px;
                border-radius: 1.5rem;
            }
            .about-gallery .about-img-2 {
                top: 98px;
                left: 142px;
            }
            .about-gallery .about-img-3 {
                top: 196px;
                left: 284px;
            }
        }
        @media (max-width: 1023px) {
            .about-gallery {
                transform: scale(0.88);
                transform-origin: top center;
            }
        }
        @media (max-width: 400px) {
            .about-gallery {
                transform: scale(0.78);
            }
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<section class="mb-8 overflow-visible bg-brand py-12 pb-16 text-white lg:mb-12 lg:py-16 lg:pb-20">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-12">
            <div class="relative order-2 mt-8 lg:order-1 lg:mt-0">
                <div class="dot-grid dot-grid--cols-5 absolute right-0 top-2 hidden lg:grid">
                    <?php for($i = 0; $i < 20; $i++): ?><span></span><?php endfor; ?>
                </div>

                <div class="about-gallery relative mx-auto lg:mx-0">
                    <?php $__currentLoopData = $stackImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img
                            src="<?php echo e($companyProfile?->aboutImageUrl($image['field'], $image['fallback'])); ?>"
                            alt="About <?php echo e($index + 1); ?>"
                            class="<?php echo e($image['class']); ?>"
                        >
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="dot-grid dot-grid--cols-5 absolute bottom-2 left-0 hidden lg:grid">
                    <?php for($i = 0; $i < 15; $i++): ?><span></span><?php endfor; ?>
                </div>
            </div>

            <div class="order-1 lg:order-2">
                <h2 class="text-2xl font-bold md:text-3xl">Visi</h2>
                <hr class="my-4 border-white/80">
                <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->vision ?? 'Menjadi perusahaan nasional yang berkelanjutan dan berkembang pesat.'); ?></p>
                <h2 class="mt-8 text-2xl font-bold md:text-3xl">Misi</h2>
                <hr class="my-4 border-white/80">
                <p class="text-base leading-relaxed text-white/95 sm:text-lg"><?php echo e($companyProfile?->mission ?? 'Meningkatkan daya saing perusahaan melalui pelayanan prima dan teknologi mutakhir.'); ?></p>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/about-vision-mission.blade.php ENDPATH**/ ?>