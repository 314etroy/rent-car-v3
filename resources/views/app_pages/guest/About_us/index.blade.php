@extends('layouts.app')

@section('page_title')
    {{ __('translations.about_meta_title') }}
@endsection

@section('description')
    {{ __('translations.about_meta_description') }}
@endsection

@push('css')
@endpush

@section('content')
    <section class="mt-20 bg-white">
        @include('common.generic-page-header', [
            'imageUrl' => 'assets/img/webp/inchiriere.webp',
            'redirectUrl' => route('reserve_now'),
            'description' => __('translations.about_us'),
        ])
        <div class="mx-auto max-w-7xl bg-white justify-center">
            @include('app_pages.guest.About_us.Contents.content')
        </div>
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
