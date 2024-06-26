@extends('layouts.app')

@section('page_title')
    {{ __('translations.privacy_notice') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    <section class="mt-20 bg-white">
        @include('common.generic-page-header', [
            'imageUrl' => 'assets/img/webp/header-img.webp',
            'redirectUrl' => route('reserve_now'),
            'description' =>  __('translations.privacy_notice'),
        ])
        <div class="mx-auto max-w-7xl bg-white flex justify-center">
            @include('common.inWork')
            {{-- @include('app_pages.guest.About_us.Contents.content') --}}
        </div>
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
