<section class="w-full overflow-hidden {{ $ctaClass ?? '' }}">
    <a href="{{ route('login') }}" class="block">
        <img
            src="{{ asset('images/landing/proyek-1.png') }}"
            alt="Trusted. Precise. Professional. Build Better with {{ $companyProfile?->company_name ?? 'PT. Sinom Jati Mas' }}"
            class="h-auto w-full object-cover object-center"
        >
    </a>
</section>
