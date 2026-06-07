<?php if($projects->isNotEmpty()): ?>
    <div id="project-carousel" class="relative px-10 md:px-12">
        <div class="overflow-hidden">
            <div id="project-carousel-track" class="flex items-start transition-transform duration-500 ease-out">
                <?php $__currentLoopData = $projects->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $projectImage = $project->progressPhotos->first()?->photo_path;
                        $fallbackImage = asset('images/landing/hero-bg.png');
                    ?>
                    <div class="project-carousel-slide w-full shrink-0 px-2 md:w-1/2 lg:w-1/3">
                        <article class="group flex w-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-md transition-shadow duration-300 hover:shadow-lg">
                            <div class="relative aspect-[5/3] shrink-0 overflow-hidden bg-gray-100">
                                <img
                                    src="<?php echo e($projectImage ? asset('storage/' . $projectImage) : $fallbackImage); ?>"
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

<?php if (! $__env->hasRenderedOnce('7b2ce68d-f269-4edc-80e4-043e280e073d')): $__env->markAsRenderedOnce('7b2ce68d-f269-4edc-80e4-043e280e073d'); ?>
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

                track.style.transform = 'translateX(-' + ((currentIndex * 100) / perView) + '%)';

                dotsContainer.querySelectorAll('button').forEach(function (dot, i) {
                    dot.classList.toggle('bg-brand', i === currentIndex);
                    dot.classList.toggle('bg-gray-300', i !== currentIndex);
                });

                prevBtn.classList.toggle('opacity-40', currentIndex === 0);
                nextBtn.classList.toggle('opacity-40', currentIndex >= max);
            }

            function buildDots() {
                dotsContainer.innerHTML = '';
                const total = maxIndex() + 1;
                for (let i = 0; i < total; i++) {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'h-2.5 w-2.5 rounded-full bg-gray-300 transition';
                    dot.setAttribute('aria-label', 'Slide ' + (i + 1));
                    dot.addEventListener('click', function () {
                        currentIndex = i;
                        updateCarousel();
                    });
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
<?php endif; ?>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/project-carousel.blade.php ENDPATH**/ ?>