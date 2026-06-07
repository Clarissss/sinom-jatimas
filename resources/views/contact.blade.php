@extends('layouts.public')

@section('title', 'Contact Us - PT. Sinom Jati Mas')
@section('meta_description', 'Hubungi PT. Sinom Jati Mas.')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-gray-900 pt-32 pb-20">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image:url('{{ asset('images/landing/hero-bg.png') }}')">
    </div>

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative mx-auto max-w-7xl px-6">
        <h1 class="text-4xl font-bold text-white md:text-5xl">
            Contact Us
        </h1>
    </div>
</section>

<!-- CONTACT -->
<section class="bg-white py-16 lg:py-20">
    <div class="mx-auto max-w-7xl px-6">

        <div class="grid gap-12 lg:grid-cols-2">

            <!-- LEFT -->
            <div class="flex flex-col justify-center">

                <h2 class="text-3xl font-bold text-gray-900 lg:text-4xl">
                    {{ $companyProfile?->company_name ?? 'PT. Sinom Jati Mas' }}
                </h2>

                <p class="mt-4 text-lg text-gray-600">
                    Solusi untuk semua kebutuhan konstruksi.
                </p>

                <p class="text-lg text-gray-600">
                    Hubungi kami sekarang untuk konsultasi.
                </p>

                <!-- PHONE -->
                <div class="mt-10 flex items-center gap-4">

                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-100">
                        <i class="fa-solid fa-phone text-xl text-orange-600"></i>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $companyProfile?->phone ?? '0877-7130-0570' }}
                        </p>
                    </div>

                </div>

                <!-- EMAIL -->
                <div class="mt-6 flex items-center gap-4">

                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-100">
                        <i class="fa-solid fa-envelope text-xl text-orange-600"></i>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $companyProfile?->email ?? 'sinomjatimas@gmail.com' }}
                        </p>
                    </div>

                </div>

                <!-- ADDRESS -->
                <div class="mt-6 flex items-start gap-4">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-orange-100">
                        <i class="fa-solid fa-location-dot text-xl text-orange-600"></i>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-lg font-semibold leading-relaxed text-gray-900">
                            {{ $companyProfile?->address }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div>

                <img
                    src="{{ asset('images/landing/proyek-2.png') }}"
                    alt="PT Sinom Jati Mas"
                    class="mb-6 h-64 w-full rounded-2xl object-cover shadow-lg">

                <div class="mb-3">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Office Location
                    </h3>

                    <p class="text-sm text-gray-500">
                        Click map to open Google Maps
                    </p>
                </div>

                <a
                    href="https://maps.app.goo.gl/BBnoijDVWpCKRbtz7?g_st=ic"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="block overflow-hidden rounded-2xl border border-gray-200 shadow-lg">

                    <div id="contactMap" class="h-[350px] w-full"></div>

                </a>

            </div>

        </div>

    </div>
</section>

@endsection

@push('styles')
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const lat = -5.9399;
    const lng = 106.0117;

    const map = L.map('contactMap', {
        scrollWheelZoom: false
    }).setView([lat, lng], 16);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; OpenStreetMap'
        }
    ).addTo(map);

    L.marker([lat, lng])
        .addTo(map)
        .bindPopup(`
            <strong>PT. Sinom Jati Mas</strong><br>
            Link. Sukarela RT/RW 006/001<br>
            Kel. Mekarsari, Kec. Pulomerak
        `)
        .openPopup();

    setTimeout(() => {
        map.invalidateSize();
    }, 500);

});
</script>
@endpush