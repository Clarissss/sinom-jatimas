<section id="home" class="relative min-h-[92vh] overflow-hidden bg-gray-900">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/landing/hero-bg.png') }}');"></div>
    <div class="absolute inset-0 bg-black/55"></div>

    <div class="relative mx-auto flex min-h-[92vh] max-w-7xl items-end px-4 pb-24 pt-36 sm:items-center sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <div class="flex flex-col gap-4 sm:flex-row">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-3.5 font-semibold text-brand shadow-lg transition hover:bg-gray-100">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>
                    Portal Access
                </a>
                <a href="{{ route('service') }}" class="inline-flex items-center justify-center rounded-lg border-2 border-white px-8 py-3.5 font-semibold text-white transition hover:bg-white hover:text-brand">
                    Our Services
                </a>
            </div>
        </div>
    </div>
</section>
