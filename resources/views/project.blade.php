@extends('layouts.public')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    #projectMap {
        z-index: 1;
    }

    .leaflet-container {
        border-radius: 24px;
    }
</style>

@section('title', 'Projects - PT. Sinom Jati Mas')
@section('meta_description', 'Portfolio proyek PT. Sinom Jati Mas.')

@section('content')

    <section class="relative overflow-hidden bg-gray-900 pt-32 pb-16 lg:pt-40 lg:pb-20">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/landing/hero-bg.png') }}');"></div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative mx-auto max-w-5xl px-4 text-left sm:px-6 lg:px-8">
            <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-white/80">Our</p>
            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl">Project</h1>
            <p class="mb-3 mt-6 max-w-3xl text-white/90 ">
            Integrated solutions for your construction and trading project needs.
            </p>
        </div>
    </section>


    <!-- INTRO -->
<section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-6 text-center">

        <h2 class="text-4xl font-bold text-gray-900">
            Trusted. Precise. Professional.
        </h2>

        <p class="mt-3 text-2xl text-gray-700">
            Build Better with Sinom Jati Mas
        </p>

        <div class="mt-10">
    <div id="projectMap"
        class="h-[450px] w-full rounded-3xl border border-gray-200 shadow-sm">
    </div>
</div>

    </div>
</section>

    <!-- PROJECT LIST -->
    <section class="bg-gray-50 pb-20">
        <div class="mx-auto max-w-6xl px-6">

            <div class="space-y-8">

                @forelse($projects as $project)

                    @php
                        $photo = $project->progressPhotos->first();
                    @endphp

                    <article
                        class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">

                        <div class="grid md:grid-cols-3">

                            <!-- IMAGE -->
                            <div class="h-64 overflow-hidden">

                                @if($photo && $photo->photo_path)
                                    <img
                                        src="{{ asset('storage/' . $photo->photo_path) }}"
                                        alt="{{ $project->name }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gray-100 text-gray-400">
                                        No Image
                                    </div>
                                @endif

                            </div>

                            <!-- CONTENT -->
                            <div class="p-8 md:col-span-2">

                                <h3 class="text-3xl font-bold text-gray-900">
                                    {{ $project->name }}
                                </h3>

                                <p class="mt-2 text-gray-600">
                                    {{ $project->location ?? '-' }}
                                </p>

                                <div class="mt-5 space-y-3">

                                    <div>
                                        <span class="font-bold">Client :</span>
                                        {{ $project->client?->name ?? '-' }}
                                    </div>

                                    <div>
                                        <span class="font-bold">Year :</span>
                                        {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y') : '-' }}
                                    </div>

                                    <div>
                                        <span class="font-bold">Status :</span>
                                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                    </div>

                                    <div>
                                        <span class="font-bold">Progress :</span>
                                        {{ $project->progress_percentage }}%
                                    </div>

                                </div>

                                @if($project->description)
                                    <div class="mt-5">
                                        <p class="text-gray-600">
                                            {{ $project->description }}
                                        </p>
                                    </div>
                                @endif

                            </div>

                        </div>

                    </article>

                @empty

                    <div
                        class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
                        No projects available.
                    </div>

                @endforelse

            </div>

        </div>
    </section>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const map = L.map('projectMap', {
        scrollWheelZoom: false
    }).setView([-2.5489, 118.0149], 5);

    L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png'
    ).addTo(map);

    const projects = @json($projectsForMap);

    projects.forEach(project => {

        const color =
            project.status === 'completed'
            ? '#10B981'
            : '#FF812E';

        L.circleMarker(
            [project.latitude, project.longitude],
            {
                radius: 10,
                fillColor: color,
                color: '#fff',
                weight: 2,
                fillOpacity: 0.9
            }
        )
        .addTo(map)
        .bindPopup(`
            <div>
                <strong>${project.name}</strong><br>
                ${project.location ?? '-'}<br>
                Progress: ${project.progress_percentage}%
            </div>
        `);
    });

});
</script>
@endsection