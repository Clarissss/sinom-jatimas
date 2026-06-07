@php
    $stackImages = [
        ['field' => 'about_image_1', 'fallback' => 'images/landing/about-1.jpg', 'class' => 'stack-1'],
        ['field' => 'about_image_2', 'fallback' => 'images/landing/about-2.jpg', 'class' => 'stack-2'],
        ['field' => 'about_image_3', 'fallback' => 'images/landing/about-3.jpg', 'class' => 'stack-3'],
    ];
@endphp

@once
    @push('styles')
    <style>
        .about-stack img {
            display: block;
            border-radius: 1.5rem;
            border: 3px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.22);
            overflow: hidden;
        }
        .about-stack .stack-1 { width: 190px; height: 250px; object-fit: cover; border-radius: 1.5rem; }
        .about-stack .stack-2 { width: 210px; height: 270px; object-fit: cover; margin-left: 3rem; margin-top: -2.5rem; border-radius: 1.5rem; }
        .about-stack .stack-3 { width: 230px; height: 290px; object-fit: cover; margin-left: 6rem; margin-top: -2.5rem; border-radius: 1.5rem; }
        .dot-grid { display: grid; grid-template-columns: repeat(6, 6px); gap: 6px; }
        .dot-grid span { width: 6px; height: 6px; border-radius: 9999px; background: rgba(255, 255, 255, 0.85); }
        @media (max-width: 1023px) {
            .about-stack { display: flex; flex-direction: column; gap: 1rem; align-items: center; }
            .about-stack .stack-1, .about-stack .stack-2, .about-stack .stack-3 {
                width: 100%; max-width: 280px; height: 200px; margin-left: 0; margin-top: 0;
            }
        }
    </style>
    @endpush
@endonce

<section class="mb-8 overflow-visible bg-brand py-12 pb-16 text-white lg:mb-12 lg:py-16 lg:pb-20">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-12">
            <div class="relative order-2 mt-8 lg:order-1 lg:mt-0">
                <div class="dot-grid absolute -left-2 top-0 hidden lg:grid">
                    @for($i = 0; $i < 18; $i++)<span></span>@endfor
                </div>
                <div class="about-stack relative mx-auto max-w-sm lg:mx-0">
                    @foreach($stackImages as $index => $image)
                        <img
                            src="{{ $companyProfile?->aboutImageUrl($image['field'], $image['fallback']) }}"
                            alt="About {{ $index + 1 }}"
                            class="{{ $image['class'] }} rounded-2xl"
                        >
                    @endforeach
                </div>
                <div class="dot-grid absolute bottom-0 right-4 hidden lg:grid">
                    @for($i = 0; $i < 21; $i++)<span></span>@endfor
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="text-2xl font-bold md:text-3xl">Visi</h2>
                <hr class="my-4 border-white/80">
                <p class="text-base leading-relaxed text-white/95 sm:text-lg">{{ $companyProfile?->vision ?? 'Menjadi perusahaan nasional yang berkelanjutan dan berkembang pesat.' }}</p>
                <h2 class="mt-8 text-2xl font-bold md:text-3xl">Misi</h2>
                <hr class="my-4 border-white/80">
                <p class="text-base leading-relaxed text-white/95 sm:text-lg">{{ $companyProfile?->mission ?? 'Meningkatkan daya saing perusahaan melalui pelayanan prima dan teknologi mutakhir.' }}</p>
            </div>
        </div>
    </div>
</section>
