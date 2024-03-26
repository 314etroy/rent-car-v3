@extends('layouts.app')

@section('page_title')
    {{ __('translations.airport_transfer') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    <section class="mt-20 bg-white">
        @include('common.generic-page-header', [
            'imageUrl' => 'assets/img/webp/header-img.webp',
            'redirectUrl' => route('reserve_now'),
            'description' => __('translations.airport_transfer'),
        ])
        <div class="mx-auto max-w-7xl bg-white flex justify-center">
            @include('common.inWork')
        </div>
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
