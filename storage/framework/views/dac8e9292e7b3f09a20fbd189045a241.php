<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const navBar = document.getElementById('nav-bar');
    const navBrand = document.getElementById('nav-brand');
    const navLinks = document.querySelectorAll('.nav-link');
    const navBtnLogin = document.querySelector('.nav-btn-login');
    const menuToggleBtn = document.getElementById('menu-toggle');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', String(!expanded));
        });
    }

    function setNavbarScrolled(scrolled) {
        if (!navBar) return;

        if (scrolled) {
            navBar.classList.remove('border-0', 'bg-white/10');
            navBar.classList.add('border', 'border-gray-200', 'bg-white/95', 'shadow-lg');
            navBrand?.classList.remove('text-white', 'drop-shadow-sm');
            navBrand?.classList.add('text-gray-900');
            navLinks.forEach(link => {
                link.classList.remove('text-white/90', 'text-white', 'bg-white/20', 'shadow-inner');
                link.classList.add('text-gray-700');
            });
            if (navBtnLogin) {
                navBtnLogin.classList.remove('border-white/35', 'bg-white/10', 'text-white');
                navBtnLogin.classList.add('border-gray-300', 'bg-gray-50', 'text-gray-800');
            }
            menuToggleBtn?.classList.remove('border-white/30', 'bg-white/10', 'text-white');
            menuToggleBtn?.classList.add('border-gray-300', 'bg-gray-50', 'text-gray-800');
        } else {
            navBar.classList.add('border-0', 'bg-white/10');
            navBar.classList.remove('border', 'border-gray-200', 'bg-white/95', 'shadow-lg');
            navBrand?.classList.add('text-white', 'drop-shadow-sm');
            navBrand?.classList.remove('text-gray-900');
            navLinks.forEach(link => {
                link.classList.remove('text-gray-700');
                if (link.classList.contains('bg-white/20')) {
                    link.classList.add('text-white');
                } else {
                    link.classList.add('text-white/90');
                }
            });
            if (navBtnLogin) {
                navBtnLogin.classList.add('border-white/35', 'bg-white/10', 'text-white');
                navBtnLogin.classList.remove('border-gray-300', 'bg-gray-50', 'text-gray-800');
            }
            menuToggleBtn?.classList.add('border-white/30', 'bg-white/10', 'text-white');
            menuToggleBtn?.classList.remove('border-gray-300', 'bg-gray-50', 'text-gray-800');
        }
    }

    window.addEventListener('scroll', () => setNavbarScrolled(window.scrollY > 24));
    setNavbarScrolled(window.scrollY > 24);

    document.querySelectorAll('.project-stat-card').forEach(function (card) {
        const toggle = card.querySelector('.project-stat-toggle');
        const panel = card.querySelector('.project-stat-panel');
        if (!toggle || !panel) return;

        toggle.addEventListener('click', function () {
            const isOpen = card.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(isOpen));
            panel.setAttribute('aria-hidden', String(!isOpen));
        });
    });
</script>
<?php /**PATH C:\Users\HP\sinojatimas\sinom-jatimas\resources\views/partials/public/scripts.blade.php ENDPATH**/ ?>