

<?php $__env->startSection('title', 'PT. Sinom Jati Mas - General Contractor & Trading'); ?>
<?php $__env->startSection('meta_description', 'PT. Sinom Jati Mas - General Contractor & General Trading. Trusted, professional construction solutions.'); ?>

<?php $__env->startSection('content'); ?>
    <section id="home" class="relative min-h-[92vh] overflow-hidden bg-gray-900">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e(asset('images/landing/hero-bg.png')); ?>');"></div>
        <div class="absolute inset-0 bg-black/55"></div>

        <div class="relative mx-auto flex min-h-[92vh] max-w-7xl items-end px-4 pb-24 pt-36 sm:items-center sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-3.5 font-semibold text-brand shadow-lg transition hover:bg-gray-100">
                        <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>
                        Portal Access
                    </a>
                    <a href="<?php echo e(route('service')); ?>" class="inline-flex items-center justify-center rounded-lg border-2 border-white px-8 py-3.5 font-semibold text-white transition hover:bg-white hover:text-brand">
                        Our Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 -mt-10 pb-6 sm:-mt-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-gray-200 bg-white px-6 py-10 shadow-xl sm:px-12 sm:py-14">
                <div class="text-center">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl md:text-4xl">
                        <?php echo e($companyProfile?->company_name ?? 'PT. Sinom Jati Mas'); ?>

                    </h2>
                    <p class="mx-auto mt-6 max-w-3xl text-base leading-relaxed text-gray-600 sm:text-lg">
                        <?php echo e($companyProfile?->about_us ?? 'PT. Sinom Jati Mas operates in General Contractor, Cut and Fill, and General Trading.'); ?>

                    </p>
                    <a href="<?php echo e(route('about')); ?>" class="mt-8 inline-flex items-center justify-center rounded-full bg-gradient-to-r from-brand to-secondary-500 px-8 py-3.5 text-sm font-semibold text-white shadow-md transition hover:scale-[1.02] hover:shadow-lg">
                        About Us
                        <i class="fa-solid fa-angle-right ml-2 text-sm"></i>
                    </a>
                </div>
                <div class="mt-10 grid gap-10 border-t border-gray-100 pt-10 sm:grid-cols-2 sm:gap-8">
                    <div class="flex flex-col items-center text-center">
                        <p class="text-3xl font-bold tabular-nums text-brand"><?php echo e($yearsOfExperience); ?><span class="text-secondary-500">+</span></p>
                        <p class="mt-1 text-sm font-medium text-gray-600">Years of Experience</p>
                    </div>
                    <?php echo $__env->make('partials.public.project-stat-card', ['variant' => 'landing'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </section>

    <section id="projects" class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <span class="text-sm font-semibold uppercase tracking-wider text-brand">Our Projects</span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Project Gallery</h2>
            </div>

            <?php if($projects->isNotEmpty()): ?>
                <div id="project-carousel" class="relative px-10 md:px-12">
                    <div class="overflow-hidden">
                        <div id="project-carousel-track" class="flex items-start transition-transform duration-500 ease-out">
                            <?php $__currentLoopData = $projects->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $projectImage = $project->progressPhotos->first()?->photo_path; ?>
                                <div class="project-carousel-slide w-full shrink-0 px-2 md:w-1/2 lg:w-1/3">
                                    <article class="group flex w-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-md transition-shadow duration-300 hover:shadow-lg">
                                        <div class="relative aspect-[5/3] shrink-0 overflow-hidden bg-gray-100">
                                            <img
                                                src="<?php echo e($projectImage ? asset('storage/' . $projectImage) : asset('images/landing/hero-bg.png')); ?>"
                                                alt="<?php echo e($project->name); ?>"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            >
                                        </div>
                                        <div class="flex flex-col gap-2 p-4">
                                            <h3 class="line-clamp-2 text-base font-semibold leading-snug text-gray-900"><?php echo e($project->name); ?></h3>
                                            <p class="line-clamp-2 text-sm leading-relaxed text-gray-600">
                                                <?php echo e(\Illuminate\Support\Str::limit($project->description ?: ($project->location ?? 'Sinom Jati Mas construction project'), 90)); ?>

                                            </p>
                                            <?php if($project->location): ?>
                                                <p class="pt-1 text-xs font-medium text-brand">
                                                    <i class="fa-solid fa-location-dot mr-1"></i><?php echo e($project->location); ?>

                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <button type="button" id="project-carousel-prev" class="absolute left-0 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-700 shadow-md transition hover:bg-gray-50" aria-label="Previous project">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" id="project-carousel-next" class="absolute right-0 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-700 shadow-md transition hover:bg-gray-50" aria-label="Next project">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <div id="project-carousel-dots" class="mt-8 flex justify-center gap-2"></div>
                </div>
            <?php else: ?>
                <article class="rounded-2xl border border-dashed border-gray-200 bg-white p-7 text-center text-gray-500">
                    No projects available yet.
                </article>
            <?php endif; ?>
        </div>
    </section>

    <section class="bg-white py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <span class="text-sm font-semibold uppercase tracking-wider text-brand">Trusted By</span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 md:text-4xl">Our Partners</h2>
            </div>
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $partners->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex flex-col items-center gap-4 text-center">
                        <?php if(!empty($partner->logo)): ?>
                            <img
                                src="<?php echo e(asset('storage/' . $partner->logo)); ?>"
                                alt="<?php echo e($partner->name); ?>"
                                class="h-60 w-full rounded-2xl bg-gray-50 object-contain p-4 shadow-md transition duration-500 hover:scale-[1.02]"
                            >
                        <?php else: ?>
                            <div class="flex h-60 w-full items-center justify-center rounded-2xl bg-gray-50 shadow-md text-brand">
                                <i class="fa-solid fa-building text-5xl" aria-hidden="true"></i>
                            </div>
                        <?php endif; ?>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($partner->name); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="col-span-full text-center text-gray-500">Partner data is not available yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    (function () {
        const carousel = document.getElementById('project-carousel');
        if (!carousel) return;

        const track = document.getElementById('project-carousel-track');
        const slides = Array.from(track.querySelectorAll('.project-carousel-slide'));
        const prevBtn = document.getElementById('project-carousel-prev');
        const nextBtn = document.getElementById('project-carousel-next');
        const dotsContainer = document.getElementById('project-carousel-dots');
        let currentIndex = 0;

        function slidesPerView() {
            if (window.innerWidth >= 1024) return 3;
            if (window.innerWidth >= 768) return 2;
            return 1;
        }

        function maxIndex() {
            return Math.max(0, slides.length - slidesPerView());
        }

        function updateCarousel() {
            const perView = slidesPerView();
            const max = maxIndex();
            if (currentIndex > max) currentIndex = max;

            const offset = (currentIndex * 100) / perView;
            track.style.transform = 'translateX(-' + offset + '%)';

            dotsContainer.querySelectorAll('button').forEach(function (dot, i) {
                dot.classList.toggle('bg-brand', i === currentIndex);
                dot.classList.toggle('bg-gray-300', i !== currentIndex);
            });

            prevBtn.classList.toggle('opacity-40', currentIndex === 0);
            nextBtn.classList.toggle('opacity-40', currentIndex >= max);
        }

        function buildDots() {
            dotsContainer.innerHTML = '';
            var total = maxIndex() + 1;
            for (var i = 0; i < total; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'h-2.5 w-2.5 rounded-full bg-gray-300 transition';
                dot.setAttribute('aria-label', 'Slide ' + (i + 1));
                (function (index) {
                    dot.addEventListener('click', function () {
                        currentIndex = index;
                        updateCarousel();
                    });
                })(i);
                dotsContainer.appendChild(dot);
            }
        }

        prevBtn.addEventListener('click', function () {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        nextBtn.addEventListener('click', function () {
            if (currentIndex < maxIndex()) {
                currentIndex++;
                updateCarousel();
            }
        });

        window.addEventListener('resize', function () {
            buildDots();
            updateCarousel();
        });

        buildDots();
        updateCarousel();
    })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/landing.blade.php ENDPATH**/ ?>