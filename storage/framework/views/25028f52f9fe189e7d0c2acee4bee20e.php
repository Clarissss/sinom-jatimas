

<?php $__env->startSection('title', 'Contact Us - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'Hubungi PT. Sinom Jati Mas.'); ?>

<?php $__env->startSection('content'); ?>

<section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e(asset('images/landing/hero-bg.png')); ?>');"></div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative mx-auto max-w-5xl px-4 text-left sm:px-6 lg:px-8">
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">Our</p>
            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">Contact</h1>
            <p class="mb-3 mt-6 max-w-3xl text-white/90 ">
            Integrated solutions for your construction and trading project needs.
            </p>
        </div>
    </section>

<!-- CONTACT -->

<section class="bg-white py-16 lg:py-20">
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-12 lg:grid-cols-2">

        <!-- LEFT -->
        <div class="flex flex-col ">

            <h2 class="text-3xl font-bold text-gray-900 lg:text-4xl">
                <?php echo e($companyProfile?->company_name ?? 'PT. Sinom Jati Mas'); ?>

            </h2>

            <p class="mt-4 text-lg text-gray-600">
                Solusi untuk semua kebutuhan konstruksi.
            </p>

            <p class="text-lg text-gray-600">
                Hubungi kami sekarang untuk konsultasi gratis.
            </p>

            <!-- PHONE -->
            <div class="mt-10 flex items-center gap-4">

                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-100">
                    <i class="fa-solid fa-phone text-xl text-orange-600"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="text-lg font-semibold text-gray-900">
                        <?php echo e($companyProfile?->phone ?? '0877-7130-0570'); ?>

                    </p>
                </div>

            </div>

            <!-- EMAIL -->
            <div class="mt-6 flex items-center gap-4">

                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-100">
                    <i class="fa-solid fa-envelope text-xl text-orange-600"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-lg font-semibold text-gray-900">
                        <?php echo e($companyProfile?->email ?? 'sinomjatimas@gmail.com'); ?>

                    </p>
                </div>

            </div>

            <!-- ADDRESS -->
            <div class="mt-6 flex items-start gap-4">

                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-orange-100">
                    <i class="fa-solid fa-location-dot text-xl text-orange-600"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="text-lg font-semibold leading-relaxed text-gray-900">
                        <?php echo e($companyProfile?->address); ?>

                    </p>
                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div>

            <img
    src="<?php echo e(asset('images/landing/proyek-1.png')); ?>"
    alt="PT Sinom Jati Mas"
    class="mb-6 h-[150px] w-full rounded-2xl object-cover shadow-lg">

            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-900">
                    Office Location
                </h3>

                <p class="text-sm text-gray-500">
                    Find us easily through Google Maps
                </p>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-lg">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.426635023571!2d106.0071572!3d-5.935780099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e419145381aa9dd%3A0xdb4a394d5dcd3e2b!2slink%20sukarela!5e0!3m2!1sid!2sid!4v1780852704384!5m2!1sid!2sid"
                    width="100%"
                    height="380"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

            </div>

            <div class="mt-4">
                <a
                    href="https://maps.app.goo.gl/BBnoijDVWpCKRbtz7?g_st=ic"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-orange-600">

                    <i class="fa-solid fa-location-arrow mr-2"></i>
                    Open in Google Maps

                </a>
            </div>

        </div>

    </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/contact.blade.php ENDPATH**/ ?>