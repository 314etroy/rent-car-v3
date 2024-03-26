<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('translations.translate_profileInformation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('translations.translate_updateAccountNameAndEmail') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label :required="true" for="name" :value="__('translations.translate_name')" />
            <x-text-input id="name" name="name" type="text" :placeholder="handlePlaceholder(__('translations.translate_name'))" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- De aici incolo --}}

        <div>
            <x-input-label :required="true" for="first_name" :value="__('translations.translate_first_name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_first_name'))" name="first_name" :value="old('first_name', $user->first_name)"
                required autofocus />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="company_name" :value="__('translations.translate_company_name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_company_name'))" name="company_name"
                :value="old('company_name', $user->company_name)" autofocus />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="cui" :value="__('translations.translate_cui')" />
            <x-text-input id="cui" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_cui'))" name="cui" :value="old('cui', $user->cui)"
                autofocus />
            <x-input-error :messages="$errors->get('cui')" class="mt-2" />
        </div>

        <div>
            <x-input-label :required="true" for="contry_region" :value="__('translations.translate_contry_region')" />
            <select id="contry_region" name="contry_region"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required autofocus>
                <option disabled selected>{{ __('translations.translate_select_contry_region') }}</option>
                @foreach (config('constants.all_country_options') ?? [] as $key => $value)
                    <option value="{{ $key }}" {{ $key === $user->contry_region ? 'selected' : null }}>
                        {{ $value }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('contry_region')" class="mt-2" />
        </div>

        <div>
            <x-input-label :required="true" for="complete_address" :value="__('translations.translate_complete_address')" />
            <x-text-input id="complete_address" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_complete_address'))" name="complete_address"
                :value="old('complete_address', $user->complete_address)" required autofocus />
            <x-input-error :messages="$errors->get('complete_address')" class="mt-2" />
        </div>

        <div>
            <x-input-label :required="true" for="phone" :value="__('translations.translate_phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" :placeholder="handlePlaceholder(__('translations.translate_phone'))" name="phone" :value="old('phone', $user->phone)"
                required autofocus />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        {{-- De aici incolo --}}

        <div>
            <x-input-label :required="true" for="email" :value="__('translations.translate_email')" />
            <x-text-input id="email" name="email" type="email" :placeholder="handlePlaceholder(__('translations.translate_email'))" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('translations.translate_emailIsUnverified') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('translations.translate_resendVerificationEmail') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('translations.translate_newVerificationLinkHasBeenSent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('translations.translate_save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('translations.translate_saved') }}</p>
            @endif
        </div>
    </form>
</section>
