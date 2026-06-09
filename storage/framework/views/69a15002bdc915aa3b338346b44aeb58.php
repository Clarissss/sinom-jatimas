

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
