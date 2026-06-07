<?php if (! $__env->hasRenderedOnce('1bf25b43-2499-4d3d-b99b-94e96bec5c51')): $__env->markAsRenderedOnce('1bf25b43-2499-4d3d-b99b-94e96bec5c51'); ?>
    <?php $__env->startPush('styles'); ?>
    <style>
        .project-stat-card {
            transition: border-color 0.35s ease, box-shadow 0.35s ease, background-color 0.35s ease;
        }
        .project-stat-card.is-open {
            border-color: rgba(211, 63, 35, 0.28);
            box-shadow: 0 8px 24px -8px rgba(211, 63, 35, 0.22);
        }
        .project-stat-toggle {
            transition: transform 0.25s ease;
        }
        .project-stat-card.is-open .project-stat-toggle {
            transform: scale(0.98);
        }
        .project-stat-chevron {
            transition: transform 0.4s cubic-bezier(0.34, 1.4, 0.64, 1), color 0.3s ease;
        }
        .project-stat-card.is-open .project-stat-chevron {
            transform: rotate(180deg);
            color: #D33F23;
        }
        .project-stat-panel {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.45s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
        }
        .project-stat-card.is-open .project-stat-panel {
            grid-template-rows: 1fr;
        }
        .project-stat-panel-inner {
            overflow: hidden;
            min-height: 0;
        }
        .project-stat-breakdown-content {
            opacity: 0;
            transform: translateY(-10px);
            transition:
                opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.45s cubic-bezier(0.34, 1.2, 0.64, 1);
        }
        .project-stat-card.is-open .project-stat-breakdown-content {
            opacity: 1;
            transform: translateY(0);
        }
        .project-stat-row {
            opacity: 0;
            transform: translateX(-6px);
            transition:
                opacity 0.3s ease,
                transform 0.35s cubic-bezier(0.34, 1.2, 0.64, 1);
        }
        .project-stat-card.is-open .project-stat-row {
            opacity: 1;
            transform: translateX(0);
        }
        .project-stat-card.is-open .project-stat-row:first-of-type {
            transition-delay: 0.12s;
        }
        .project-stat-card.is-open .project-stat-row:last-of-type {
            transition-delay: 0.2s;
        }
        .project-stat-hint {
            transition: opacity 0.25s ease, max-height 0.3s ease, margin 0.3s ease;
            max-height: 1.5rem;
            overflow: hidden;
        }
        .project-stat-card.is-open .project-stat-hint {
            opacity: 0;
            max-height: 0;
            margin-top: 0 !important;
        }
        @media (prefers-reduced-motion: reduce) {
            .project-stat-panel,
            .project-stat-breakdown-content,
            .project-stat-row,
            .project-stat-chevron,
            .project-stat-card,
            .project-stat-hint {
                transition: none !important;
            }
            .project-stat-breakdown-content,
            .project-stat-row {
                opacity: 1;
                transform: none;
            }
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<div class="project-stat-card flex w-full flex-col items-center rounded-xl text-center">
    <button
        type="button"
        class="project-stat-toggle group flex w-full flex-col items-center rounded-xl border border-transparent px-4 py-3 transition-colors duration-300 hover:border-brand/20 hover:bg-brand/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40"
        aria-expanded="false"
    >
        <p class="text-3xl font-bold tabular-nums text-brand transition-transform duration-300 group-active:scale-95"><?php echo e($totalProjects); ?></p>
        <p class="mt-1 text-sm font-medium text-gray-600">Total Project</p>
        <p class="project-stat-hint mt-1 flex items-center gap-1 text-xs text-gray-400">
            <span class="opacity-70 sm:opacity-0 sm:transition-opacity sm:duration-300 sm:group-hover:opacity-100">Click for details</span>
            <i class="fa-solid fa-chevron-down project-stat-chevron text-[10px] sm:opacity-70 sm:group-hover:opacity-100" aria-hidden="true"></i>
        </p>
    </button>

    <div class="project-stat-panel w-full max-w-xs" role="region" aria-label="Total project breakdown" aria-hidden="true">
        <div class="project-stat-panel-inner">
            <div class="project-stat-breakdown-content pt-1">
                <div class="space-y-2.5 rounded-lg border border-gray-100 bg-white px-4 py-3.5 text-left text-sm shadow-sm">
                    <div class="project-stat-row flex items-center justify-between gap-4">
                        <span class="flex items-center gap-2 text-gray-600">
                            <span class="h-2 w-2 shrink-0 rounded-full bg-secondary-500 ring-2 ring-secondary-200"></span>
                            In Progress
                        </span>
                        <span class="font-bold tabular-nums text-brand"><?php echo e($projectsOngoing); ?></span>
                    </div>
                    <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
                    <div class="project-stat-row flex items-center justify-between gap-4">
                        <span class="flex items-center gap-2 text-gray-600">
                            <span class="h-2 w-2 shrink-0 rounded-full bg-brand ring-2 ring-brand/20"></span>
                            Completed
                        </span>
                        <span class="font-bold tabular-nums text-brand"><?php echo e($projectsCompleted); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/project-stat-card.blade.php ENDPATH**/ ?>