@extends('layouts.public')

@section('title', 'PT. Sinom Jati Mas - General Contractor & Trading')
@section('meta_description', 'PT. Sinom Jati Mas - General Contractor & General Trading. Trusted, professional construction solutions.')

@section('content')
    @include('partials.public.home-hero')
    @include('partials.public.company-intro-card')

    <section id="projects" class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @include('partials.public.section-heading', [
                'eyebrow' => 'Our Projects',
                'title' => 'Project Gallery',
            ])
            @include('partials.public.project-carousel')
        </div>
    </section>

    @include('partials.public.partners-section')
@endsection
