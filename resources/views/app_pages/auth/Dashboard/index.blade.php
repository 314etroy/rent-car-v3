@extends('layouts.app')

@section('page_title')
    {{ __('translations.dashboard') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    <section class="mt-20 mb-2 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100 my-4">
                @if (isAdmin())
                    @livewire('pages.auth.additional-service-table', key(uniqid()))
                    @livewire('pages.auth.additional-equipment-table', key(uniqid()))
                    @livewire('pages.auth.car-specifications-table', key(uniqid()))
                @else
                    @livewire('pages.guest.dashboard', key(uniqid()))
                @endif
            </div>
        </div>
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
