@php
    $maxWidth = $maxWidth ?? 'max-w-7xl';
    $overlay = $overlay ?? 'bg-black/60';
@endphp

<section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/landing/hero-bg.png') }}');"></div>
    <div class="absolute inset-0 {{ $overlay }}"></div>
    <div class="relative mx-auto {{ $maxWidth }} px-4 text-center sm:px-6 lg:px-8">
        @if(!empty($eyebrow))
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">{{ $eyebrow }}</p>
        @endif
        <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">{{ $title }}</h1>
        @if(!empty($subtitle))
            <p class="mx-auto mt-6 max-w-3xl text-base text-white/90 sm:text-lg">{{ $subtitle }}</p>
        @endif
    </div>
</section>
