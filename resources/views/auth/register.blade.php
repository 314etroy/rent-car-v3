@extends('layouts.app')

@section('page_title')
    {{ __('translations.translate_register') }}
@endsection

@push('css')
    {{-- Zona pentru css-urile folosite la nivel de pagina --}}
@endpush

@section('content')
    <h1 class="mb-5 mt-2 text-center uppercase">Înregistrează-ți contul Starent</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label :required="true" for="name" :value="__('translations.translate_name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                :placeholder="handlePlaceholder(__('translations.translate_name'))" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- De aici incolo --}}

        <div class="mt-4">
            <x-input-label :required="true" for="first_name" :value="__('translations.translate_first_name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_first_name'))"
                name="first_name" :value="old('first_name')" required autofocus />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="company_name" :value="__('translations.translate_company_name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_company_name'))"
                name="company_name" :value="old('company_name')" required autofocus />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="cui" :value="__('translations.translate_cui')" />
            <x-text-input id="cui" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_cui'))" name="cui" :value="old('cui')" required
                autofocus />
            <x-input-error :messages="$errors->get('cui')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label :required="true" for="contry_region" :value="__('translations.translate_contry_region')" />
            <select id="contry_region" name="contry_region"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required autofocus>
                <option disabled selected>{{ __('translations.translate_select_contry_region') }}</option>
                @foreach (config('constants.all_country_options') ?? [] as $key => $value)
                    <option value="{{ $key }}">
                        {{ $value }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('contry_region')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label :required="true" for="complete_address" :value="__('translations.translate_complete_address')" />
            <x-text-input id="complete_address" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_complete_address'))" name="complete_address"
                :value="old('complete_address')" required autofocus />
            <x-input-error :messages="$errors->get('complete_address')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label :required="true" for="phone" :value="__('translations.translate_phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_phone'))" name="phone" :value="old('phone')" required
                autofocus />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        {{-- De aici incolo --}}

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label :required="true" for="email" :value="__('translations.translate_email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" :placeholder="handlePlaceholder(__('translations.translate_email'))" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label :required="true" for="password" :value="__('translations.translate_password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" :placeholder="handlePlaceholder(__('translations.translate_password'))" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label :required="true" for="password_confirmation" :value="__('translations.translate_confirmPassword')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" :placeholder="handlePlaceholder(__('translations.translate_password'))" name="password_confirmation"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('translations.translate_allreadyRegistered') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('translations.translate_register') }}
            </x-primary-button>
        </div>
    </form>
@endsection

@push('js')
    {{-- Zona pentru js-urile folosite la nivel de pagina --}}
@endpush
