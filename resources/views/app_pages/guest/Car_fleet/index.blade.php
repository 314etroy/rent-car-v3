@extends('layouts.app')

@section('page_title')
    {{ __('translations.flota_meta_title') }}
@endsection
@section('description')
    {{ __('translations.flota_meta_description') }}
@endsection


@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    <section class="mt-20 bg-white">
        @include('common.generic-page-header', [
            'imageUrl' => 'assets/img/webp/header-img.webp',
            'redirectUrl' => route('reserve_now'),
            'description' => __('translations.car_fleet'),
        ])
        <div class="mx-auto max-w-7xl bg-white flex justify-center">
            @include('app_pages.guest.Car_fleet.Content.cars')
        </div>
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
