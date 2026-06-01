@extends('layouts.public')

@section('title', 'Services - PT. Sinom Jati Mas')
@section('meta_description', 'PT. Sinom Jati Mas services - General Contractor, General Trading, and Cut and Fill.')

@section('content')
    <section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/landing/hero-bg.png') }}');"></div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">Our Services</p>
            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">What We Offer</h1>
            <p class="mx-auto mt-6 max-w-3xl text-base text-white/90 sm:text-lg">
                Integrated solutions for your construction and trading project needs.
            </p>
        </div>
    </section>

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-5">
                @forelse($services as $service)
                    @php
                        $serviceSlug = \Illuminate\Support\Str::slug($service->name);
                        $iconClass = 'fa-screwdriver-wrench';
                        if (str_contains($serviceSlug, 'contractor')) {
                            $iconClass = 'fa-road';
                        } elseif (str_contains($serviceSlug, 'trading')) {
                            $iconClass = 'fa-house-chimney';
                        } elseif (str_contains($serviceSlug, 'cut') || str_contains($serviceSlug, 'fill')) {
                            $iconClass = 'fa-mountain';
                        }
                    @endphp
                    <article class="flex gap-5 rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:gap-6 sm:p-7">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-orange-50 ring-2 ring-orange-200">
                            @if(!empty($service->icon))
                                <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }}" class="h-full w-full object-cover">
                            @else
                                <i class="fa-solid {{ $iconClass }} text-2xl text-brand"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $service->name }}</h3>
                            <p class="mt-3 text-sm leading-relaxed text-gray-600 sm:text-base">{{ $service->description }}</p>
                        </div>
                    </article>
                @empty
                    <article class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-8 text-center text-gray-500">
                        No services available yet.
                    </article>
                @endforelse
            </div>
        </div>
    </section>
@endsection
