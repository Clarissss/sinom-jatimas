<section class="bg-white py-16 lg:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @include('partials.public.section-heading', [
            'eyebrow' => 'Trusted By',
            'title' => 'Our Partners',
        ])

        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @forelse($partners->take(6) as $partner)
                <div class="flex flex-col items-center gap-4 text-center">
                    @if(!empty($partner->logo))
                        <img
                            src="{{ asset('storage/' . $partner->logo) }}"
                            alt="{{ $partner->name }}"
                            class="h-60 w-full rounded-2xl bg-gray-50 object-contain p-4 shadow-md transition duration-500 hover:scale-[1.02]"
                        >
                    @else
                        <div class="flex h-60 w-full items-center justify-center rounded-2xl bg-gray-50 text-brand shadow-md">
                            <i class="fa-solid fa-building text-5xl" aria-hidden="true"></i>
                        </div>
                    @endif
                    <p class="text-lg font-semibold text-gray-900">{{ $partner->name }}</p>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Partner data is not available yet.</p>
            @endforelse
        </div>
    </div>
</section>
