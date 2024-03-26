@extends('layouts.app')

@section('page_title')
    {{ __('translations.faqs') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    <section class="faq-section">
        @include('common.generic-page-header', [
            'imageUrl' => 'assets/img/webp/faq.webp',
            'redirectUrl' => route('reserve_now'),
            'description' => __('translations.faqs'),
        ])
        @include('app_pages.guest.Faqs.Contents.content')
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
