<section class="w-full overflow-hidden {{ $ctaClass ?? '' }}">
    <div class="relative w-full">
        <img
            src="{{ asset('images/landing/proyek-1.png') }}"
            alt=""
            class="w-full object-cover object-center"
            style="max-height: 20rem;"
        >
        <div class="absolute inset-0 bg-black/55"></div>
        <div class="absolute inset-0 flex items-center justify-center px-6">
            <div class="text-center">
                <p class="text-2xl font-bold leading-tight text-white sm:text-3xl tracking-tight">Trusted. Precise. Professional.</p>
                <p class="mt-2 text-base text-white/90 sm:text-lg">
                    Build Better with {{ $companyProfile?->company_name ?? 'PT. Sinom Jati Mas' }}
                </p>
            </div>
        </div>
    </div>
</section>
