<?php
    $active = $active ?? '';
    $navItem = function (string $page, string $label, string $href) use ($active) {
        $isActive = $active === $page;
        $base = 'nav-link rounded-full px-3 py-1.5 text-sm font-medium transition';
        $classes = $isActive
            ? $base . ' bg-white/20 text-white shadow-inner'
            : $base . ' text-white/90 hover:bg-white/20 hover:text-white';
        return '<a href="' . e($href) . '" class="' . $classes . '">' . e($label) . '</a>';
    };
?>

<header id="header" class="fixed inset-x-0 top-4 z-50 px-3 transition-all duration-300 sm:px-6">
    <div id="nav-bar" class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between rounded-2xl border-0 bg-white/10 px-4 backdrop-blur-xl transition-all duration-300 sm:px-6 lg:px-8">
        <a href="<?php echo e(route('landing')); ?>" class="flex items-center gap-3">
            <?php if(!empty($companyProfile?->logo)): ?>
                <img src="<?php echo e($companyProfile->imageUrl($companyProfile->logo)); ?>" alt="Logo" class="h-10 w-10 rounded-xl object-contain bg-white/90 p-1">
            <?php else: ?>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand to-secondary-500 shadow-md">
                    <i class="fa-solid fa-building text-white text-xl"></i>
                </div>
            <?php endif; ?>
            <span id="nav-brand" class="text-sm font-bold tracking-wide text-white drop-shadow-sm sm:text-base"><?php echo e($companyProfile?->company_name ?? 'PT. SINOM JATI MAS'); ?></span>
        </a>

        <nav id="nav-links" class="hidden items-center gap-7 md:flex">
            <?php echo $navItem('home', 'Home', route('landing')); ?>

            <?php echo $navItem('about', 'About Us', route('about')); ?>

            <?php echo $navItem('service', 'Services', route('service')); ?>

            <?php echo $navItem('project', 'Project', route('landing') . '#projects'); ?>

            <?php echo $navItem('contact', 'Contact Us', route('landing') . '#contact'); ?>

        </nav>

        <div id="nav-actions" class="hidden items-center gap-3 md:flex">
            <a href="<?php echo e(route('login')); ?>" class="nav-btn-login rounded-full border border-white/35 bg-white/10 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/20">Login</a>
            <a href="<?php echo e(route('register')); ?>" class="rounded-full bg-gradient-to-r from-brand to-secondary-500 px-4 py-2 text-sm font-semibold text-white shadow-md transition hover:scale-[1.03]">Register</a>
        </div>

        <button id="menu-toggle" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/30 bg-white/10 text-white transition hover:bg-white/20 md:hidden" type="button" aria-label="Toggle menu" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div id="mobile-menu" class="mx-auto mt-3 hidden w-full max-w-7xl rounded-2xl border border-white/25 bg-gray-900/70 px-4 py-4 backdrop-blur-xl md:hidden">
        <div class="space-y-2">
            <a href="<?php echo e(route('landing')); ?>" class="block rounded-lg px-3 py-2 text-sm font-medium <?php echo e($active === 'home' ? 'bg-white/20 text-white' : 'text-white/90 hover:bg-white/10'); ?>">Home</a>
            <a href="<?php echo e(route('about')); ?>" class="block rounded-lg px-3 py-2 text-sm font-medium <?php echo e($active === 'about' ? 'bg-white/20 text-white' : 'text-white/90 hover:bg-white/10'); ?>">About Us</a>
            <a href="<?php echo e(route('service')); ?>" class="block rounded-lg px-3 py-2 text-sm font-medium <?php echo e($active === 'service' ? 'bg-white/20 text-white' : 'text-white/90 hover:bg-white/10'); ?>">Services</a>
            <a href="<?php echo e(route('landing')); ?>#projects" class="block rounded-lg px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10">Project</a>
            <a href="<?php echo e(route('landing')); ?>#contact" class="block rounded-lg px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10">Contact Us</a>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-2">
            <a href="<?php echo e(route('login')); ?>" class="rounded-full border border-white/30 bg-white/10 px-3 py-2 text-center text-sm font-medium text-white">Login</a>
            <a href="<?php echo e(route('register')); ?>" class="rounded-full bg-gradient-to-r from-brand to-secondary-500 px-3 py-2 text-center text-sm font-semibold text-white">Register</a>
        </div>
    </div>
</header>
<?php /**PATH C:\KULIAH\SEMESTER 8\Sistem Informasi Perusahaan\Project\sinom-jatimas\resources\views/partials/public/navbar.blade.php ENDPATH**/ ?>