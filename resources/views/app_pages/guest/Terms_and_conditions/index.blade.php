@extends('layouts.app')

@section('page_title')
    {{ __('translations.terms_and_conditions') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    <section class="mt-20 bg-[#161321]">
        @include('common.generic-page-header', [
            'imageUrl' => 'assets/img/webp/header-img.webp',
            'redirectUrl' => route('reserve_now'),
            'description' => __('translations.terms_and_conditions'),
        ])
        <div class="mx-auto max-w-7xl bg-[#161321] flex justify-center">
            @include('app_pages.guest.Terms_and_conditions.Contents.content')
        </div>
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
