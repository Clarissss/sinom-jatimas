

<?php $__env->startSection('title', 'Projects - PT. Sinom Jati Mas'); ?>
<?php $__env->startSection('meta_description', 'Portfolio proyek PT. Sinom Jati Mas.'); ?>

<?php $__env->startSection('content'); ?>

    <!-- HERO -->
    <section class="relative overflow-hidden bg-gray-900 pt-32 pb-20">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image:url('<?php echo e(asset('images/landing/hero-bg.png')); ?>')">
        </div>

        <div class="absolute inset-0 bg-black/60"></div>

        <div class="relative mx-auto max-w-7xl px-6">
            <h1 class="text-5xl font-bold text-white">
                Project
            </h1>
        </div>
    </section>

    <!-- INTRO -->
<section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-6 text-center">

        <h2 class="text-4xl font-bold text-gray-900">
            Trusted. Precise. Professional.
        </h2>

        <p class="mt-3 text-2xl text-gray-700">
            Build Better with Sinom Jati Mas
        </p>

        <div class="mt-10 flex justify-center">
            <img
                src="<?php echo e(asset('images/landing/peta.png')); ?>"
                alt="Peta Indonesia"
                class="w-full max-w-4xl object-contain">
        </div>

    </div>
</section>

    <!-- PROJECT LIST -->
    <section class="bg-gray-50 pb-20">
        <div class="mx-auto max-w-6xl px-6">

            <div class="space-y-8">

                <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $photo = $project->progressPhotos->first();
                    ?>

                    <article
                        class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">

                        <div class="grid md:grid-cols-3">

                            <!-- IMAGE -->
                            <div class="h-64 overflow-hidden">

                                <?php if($photo && $photo->photo_path): ?>
                                    <img
                                        src="<?php echo e(asset('storage/' . $photo->photo_path)); ?>"
                                        alt="<?php echo e($project->name); ?>"
                                        class="h-full w-full object-cover">
                                <?php else: ?>
                                    <div class="flex h-full items-center justify-center bg-gray-100 text-gray-400">
                                        No Image
                                    </div>
                                <?php endif; ?>

                            </div>

                            <!-- CONTENT -->
                            <div class="p-8 md:col-span-2">

                                <h3 class="text-3xl font-bold text-gray-900">
                                    <?php echo e($project->name); ?>

                                </h3>

                                <p class="mt-2 text-gray-600">
                                    <?php echo e($project->location ?? '-'); ?>

                                </p>

                                <div class="mt-5 space-y-3">

                                    <div>
                                        <span class="font-bold">Client :</span>
                                        <?php echo e($project->client?->name ?? '-'); ?>

                                    </div>

                                    <div>
                                        <span class="font-bold">Year :</span>
                                        <?php echo e($project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y') : '-'); ?>

                                    </div>

                                    <div>
                                        <span class="font-bold">Status :</span>
                                        <?php echo e(ucfirst(str_replace('_', ' ', $project->status))); ?>

                                    </div>

                                    <div>
                                        <span class="font-bold">Progress :</span>
                                        <?php echo e($project->progress_percentage); ?>%
                                    </div>

                                </div>

                                <?php if($project->description): ?>
                                    <div class="mt-5">
                                        <p class="text-gray-600">
                                            <?php echo e($project->description); ?>

                                        </p>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                    </article>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <div
                        class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
                        No projects available.
                    </div>

                <?php endif; ?>

            </div>

        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/project.blade.php ENDPATH**/ ?>