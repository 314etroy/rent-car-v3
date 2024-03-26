@extends('layouts.app')

@section('page_title')
    {{ __('translations.reserve_now') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    @livewire('pages.guest.rent-car', key(uniqid()))
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
