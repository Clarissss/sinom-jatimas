<section class="relative z-10 -mt-10 pb-6 sm:-mt-12">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-10 shadow-xl sm:px-12 sm:py-14">
            <div class="text-center">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl md:text-4xl">
                    {{ $companyProfile?->displayName() }}
                </h2>
                <p class="mx-auto mt-6 max-w-3xl text-base leading-relaxed text-gray-600 sm:text-lg">
                    {{ $companyProfile?->about_us ?? 'PT. Sinom Jati Mas operates in General Contractor, Cut and Fill, and General Trading.' }}
                </p>
                <a href="{{ route('about') }}" class="mt-8 inline-flex items-center justify-center rounded-full bg-gradient-to-r from-brand to-secondary-500 px-8 py-3.5 text-sm font-semibold text-white shadow-md transition hover:scale-[1.02] hover:shadow-lg">
                    About Us
                    <i class="fa-solid fa-angle-right ml-2 text-sm"></i>
                </a>
            </div>
            <div class="mt-10 border-t border-gray-100 pt-10">
                @include('partials.public.company-stats')
            </div>
        </div>
    </div>
</section>
