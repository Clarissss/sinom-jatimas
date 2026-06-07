@extends('layouts.public')

@section('title', 'About Us - PT. Sinom Jati Mas')
@section('meta_description', 'Tentang PT. Sinom Jati Mas - Visi, Misi, dan profil perusahaan.')

@section('content')
    @include('partials.public.page-hero', [
        'eyebrow' => 'About Us',
        'title' => $companyProfile?->displayName(),
    ])

    @include('partials.public.about-intro')
    @include('partials.public.about-vision-mission')
@endsection
