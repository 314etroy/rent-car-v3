@extends('layouts.app')

@section('page_title')
    {{ __('translations.reserveACar') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
@endpush

@section('content')
    <section class="mt-20 mb-2 bg-white">
        <div class="text-gray-900 dark:text-gray-100 my-4">
            @if (isAdmin())
                @livewire('components.calendar')
                @livewire('common.modal-form-type')
                @livewire('common.modal-task-data')
            @endif
        </div>
    </section>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
    <script src="{{ asset('assets/js/wireClickAway.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}" type="module"></script>
@endpush
