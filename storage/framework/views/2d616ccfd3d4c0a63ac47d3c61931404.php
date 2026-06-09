<footer id="contact" class="bg-gray-900 py-12 text-white lg:py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="max-w-md">
            <h4 class="mb-4 text-lg font-semibold">Contact</h4>
            <ul class="space-y-3 text-gray-400">
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-location-dot mt-0.5 shrink-0 text-brand-light"></i>
                    <span><?php echo e($companyProfile?->address ?? 'Link. Sukarela RT/RW 006/001, Kel. Mekarsari Kec. Pulomerak'); ?></span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fa-regular fa-envelope shrink-0 text-brand-light"></i>
                    <a href="mailto:<?php echo e($companyProfile?->email ?? 'sinomjatimas@gmail.com'); ?>" class="hover:text-white"><?php echo e($companyProfile?->email ?? 'sinomjatimas@gmail.com'); ?></a>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fa-brands fa-whatsapp shrink-0 text-brand-light"></i>
                    <a href="https://wa.me/<?php echo e(preg_replace('/\D+/', '', $companyProfile?->phone ?? '087771300570')); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-white"><?php echo e($companyProfile?->phone ?? '0877-7130-0570'); ?></a>
                </li>
            </ul>
        </div>
        <div class="mt-10 border-t border-gray-800 pt-8 text-center">
            <p class="text-gray-500">&copy; <?php echo e(date('Y')); ?> PT. Sinom Jati Mas. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/partials/public/footer.blade.php ENDPATH**/ ?>