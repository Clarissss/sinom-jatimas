@extends('layouts.public')

@section('title', 'About Us - PT. Sinom Jati Mas')
@section('meta_description', 'About PT. Sinom Jati Mas - Vision, mission, and company profile.')

@push('styles')
<style>
    .about-stack img {
        border-radius: 1.25rem;
        border: 3px solid rgba(0, 0, 0, 0.25);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }
    .about-stack .stack-1 { width: 220px; height: 280px; object-fit: cover; }
    .about-stack .stack-2 { width: 240px; height: 300px; object-fit: cover; margin-left: 3.5rem; margin-top: -3rem; }
    .about-stack .stack-3 { width: 260px; height: 320px; object-fit: cover; margin-left: 7rem; margin-top: -3rem; }
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

@section('content')
    <section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/landing/hero-bg.png') }}');"></div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">Tentang Kami</p>
            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">{{ $companyProfile?->company_name ?? 'PT. Sinom Jati Mas' }}</h1>
        </div>
    </section>

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-base leading-relaxed text-gray-600 sm:text-lg">
                {{ $companyProfile?->about_us ?? 'PT. Sinom Jati Mas operates in General Contractor, Cut and Fill, and General Trading.' }}
            </p>
            <div class="mt-10 grid gap-8 sm:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                    <p class="text-3xl font-bold text-brand">{{ $yearsOfExperience }}+</p>
                    <p class="mt-1 text-sm font-medium text-gray-600">Years of Experience</p>
                </div>
                @include('partials.public.project-stat-card', ['variant' => 'about'])
            </div>
        </div>
    </section>

    <section class="mb-12 overflow-visible bg-brand py-16 pb-28 text-white lg:mb-16 lg:py-24 lg:pb-36">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-16 lg:grid-cols-2 lg:gap-20">
                <div class="relative order-2 mt-12 lg:order-1 lg:mt-0">
                    <div class="dot-grid absolute -left-2 top-0 hidden lg:grid">
                        @for($i = 0; $i < 18; $i++)<span></span>@endfor
                    </div>
                    <div class="about-stack relative mx-auto max-w-md lg:mx-0">
                        @php
                            $aboutImages = [$companyProfile?->about_image_1, $companyProfile?->about_image_2, $companyProfile?->about_image_3];
                            $aboutDefaults = [asset('images/landing/hero-bg.png'), asset('images/landing/proyek-1.png'), asset('images/landing/hero-bg.png')];
                        @endphp
                        @foreach($aboutImages as $index => $imagePath)
                            <img
                                src="{{ $imagePath && $companyProfile ? $companyProfile->imageUrl($imagePath) : $aboutDefaults[$index] }}"
                                alt="About {{ $index + 1 }}"
                                class="stack-{{ $index + 1 }}"
                            >
                        @endforeach
                    </div>
                    <div class="dot-grid absolute bottom-0 right-4 hidden lg:grid">
                        @for($i = 0; $i < 21; $i++)<span></span>@endfor
                    </div>
                </div>
                <div class="order-1 lg:order-2 lg:pb-4">
                    <h2 class="text-3xl font-bold md:text-4xl">Vision</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg">{{ $companyProfile?->vision ?? 'To become a sustainable national company that grows rapidly and responsibly.' }}</p>
                    <h2 class="mt-10 text-3xl font-bold md:text-4xl">Mission</h2>
                    <hr class="my-4 border-white/80">
                    <p class="text-base leading-relaxed text-white/95 sm:text-lg">{{ $companyProfile?->mission ?? 'To strengthen competitiveness through excellent service and modern technology on every project.' }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
