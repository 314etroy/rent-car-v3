@extends('layouts.app')

@section('page_title')
    {{ __('translations.home_meta_title') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
    <link rel="stylesheet" href="{{ asset('assets/css/aos.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flowbite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
    <!-- hero section -->
    @include('app_pages.guest.Home.Content.hero')

    <!-- service -->
    @include('app_pages.guest.Home.Content.info')

    <!-- about -->
    @include('app_pages.guest.Home.Content.about')

    <!-- Portfolio -->
    @include('app_pages.guest.Home.Content.portofoliuAuto')

    <!-- News -->
    @include('app_pages.guest.Home.Content.testimoniale')

@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
