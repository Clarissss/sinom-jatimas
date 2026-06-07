@extends('layouts.public')

@section('title', 'Services - PT. Sinom Jati Mas')
@section('meta_description', 'PT. Sinom Jati Mas services - General Contractor, General Trading, and Cut and Fill.')

@section('content')
    @include('partials.public.page-hero', [
        'eyebrow' => 'Our Services',
        'title' => 'What We Offer',
        'subtitle' => 'Integrated solutions for your construction and trading project needs.',
        'maxWidth' => 'max-w-5xl',
    ])

    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @include('partials.public.service-list')
        </div>
    </section>
@endsection
