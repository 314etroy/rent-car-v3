@props([
    'right_inputs' => [
        [
            'type' => 'text',
            'key' => __('translations.translate_name'),
            'placeholder' => handlePlaceholder(__('translations.translate_name')),
            'isRequired' => true,
            'wireModelName' => 'rawData.check_out.name',
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => __('translations.translate_first_name'),
            'isRequired' => true,
            'placeholder' => handlePlaceholder(__('translations.translate_first_name')),
            'wireModelName' => 'rawData.check_out.first_name',
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => __('translations.translate_company_name'),
            'placeholder' => handlePlaceholder(__('translations.translate_company_name')),
            'wireModelName' => 'rawData.check_out.company_name',
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => __('translations.translate_cui'),
            'placeholder' => handlePlaceholder(__('translations.translate_cui')),
            'wireModelName' => 'rawData.check_out.cui',
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'select',
            'key' => 'tara-/-regiune',
            'wireModelName' => 'rawData.check_out.contry_region',
            'isRequired' => true,
            'labelClass' => config('constants.common_css.check_out.label_Class'),
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_select'),
            'errorInputClass' => config('constants.common_css.check_out.error_select'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_select'),
            'selectDefaultText' => __('translations.translate_select_contry_region'),
            'allOptions' => config('constants.all_country_options'),
            'showDefaultOption' => true,
        ],
        // [
        //     'type' => 'select',
        //     'key' => 'Judet',
        //     'labelClass' => config('constants.common_css.check_out.label_Class'),
        //     'validLabelClass' => config('constants.common_css.check_out.valid_label'),
        //     'errorLabelClass' => config('constants.common_css.check_out.error_label'),
        //     'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
        //     'validInputClass' => config('constants.common_css.check_out.valid_select'),
        //     'errorInputClass' => config('constants.common_css.check_out.error_select'),
        //     'emptyInputClass' => config('constants.common_css.check_out.empty_select'),
        //     'selectDefaultText' => 'Selecteaza Judet',
        //     'allOptions' => config('constants.all_county_options'),
        //     'wireModelName' => 'rawData.check_out.judet',
        //     'showDefaultOption' => true,
        // ],
        [
            'type' => 'text',
            'isRequired' => true,
            'key' => __('translations.translate_complete_address'),
            'placeholder' => handlePlaceholder(__('translations.translate_complete_address')),
            'wireModelName' => 'rawData.check_out.complete_address',
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'tel',
            'key' => __('translations.translate_phone'),
            'isRequired' => true,
            'placeholder' => handlePlaceholder(__('translations.translate_phone')),
            'wireModelName' => 'rawData.check_out.phone',
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'email',
            'isRequired' => true,
            'key' => __('translations.translate_email'),
            'placeholder' => handlePlaceholder(__('translations.translate_email')),
            'wireModelName' => 'rawData.check_out.email',
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'checkbox',
            'key' => 'am-deja-cont',
            'labelText' => 'Am deja cont',
            'labelText' => '<span class="edit-terms">Am deja cont (<a href="' . route('login') . '" class="mx-1 text-blue-700 font-bold hover:underline">veți fi redirecționat către pagina de autentificare</a>)</span>',
            'divClass' => 'flex flex-row-reverse gap-4 items-center justify-end',
            'wireModelName' => 'rawData.check_out.have_account',
            'display' => !Auth::check(),
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_checkbox'),
            'errorInputClass' => config('constants.common_css.check_out.error_checkbox'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_checkbox'),
        ],
        [
            'type' => 'password',
            'key' => __('translations.translate_password'),
            'placeholder' => handlePlaceholder(__('translations.translate_password')),
            'wireModelName' => 'rawData.check_out.password',
            'isRequired' => true,
            'display' => !Auth::check() && !$rawData['check_out']['have_account'],
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'password',
            'key' => __('translations.translate_confirmPassword'),
            'placeholder' => handlePlaceholder(__('translations.translate_password')),
            'wireModelName' => 'rawData.check_out.confirm_password',
            'isRequired' => true,
            'display' => !Auth::check() && !$rawData['check_out']['have_account'],
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_input'),
            'errorInputClass' => config('constants.common_css.check_out.error_input'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_input'),
        ],
        [
            'type' => 'checkbox',
            'key' => 'termeni-si-conditii',
            'labelText' => 'Sunt de acord cu termenii si conditiile website-ului si politica GDPR',
            'labelText' => '<span class="edit-terms">Sunt de acord cu <a href="' . route('terms_and_conditions') . '" class="mx-1 text-blue-700 font-bold" target="_blank">termenii si conditiile</a> website-ului si <a href="' . route('gdpr') . '" class="mx-1 text-blue-700 font-bold" target="_blank">politica GDPR</a></span>',
            'divClass' => 'flex flex-row-reverse gap-4 items-center justify-end',
            'wireModelName' => 'rawData.check_out.terms',
            'isRequired' => true,
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_checkbox'),
            'errorInputClass' => config('constants.common_css.check_out.error_checkbox'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_checkbox'),
        ],
        [
            'type' => 'checkbox',
            'key' => 'politica-de-procesare',
            'labelText' => '<span class="edit-policy">Sunt de acord cu <a href="' . route('cancellation_policy') . '" class="mx-1 text-blue-700 font-bold" target="_blank">politica de închiriere</a> a autovehiculului Starent.</span>',
            'divClass' => 'flex flex-row-reverse gap-4 items-center justify-end',
            'wireModelName' => 'rawData.check_out.policy',
            'isRequired' => true,
            'validLabelClass' => config('constants.common_css.check_out.valid_label'),
            'errorLabelClass' => config('constants.common_css.check_out.error_label'),
            'emptyLabelClass' => config('constants.common_css.check_out.empty_label'),
            'validInputClass' => config('constants.common_css.check_out.valid_checkbox'),
            'errorInputClass' => config('constants.common_css.check_out.error_checkbox'),
            'emptyInputClass' => config('constants.common_css.check_out.empty_checkbox'),
        ],
    ],
])

{{-- Section 4 --}}
<section class="mt-4">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 bg-white pb-6 flex justify-center">
        <div class="container relative">

            <div class="text-center py-11">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                    {{ __('translations.additional_services_complete_order') }}</h1>
            </div>

            <div class="grid grid-cols-2">
                <div class="col-span-1 left-checkout">
                    @if ($buyOptions[$selectedCar['code']] ?? null)
                        <img class="w-full h-[250px] rounded-lg object-cover object-center flex-shrink-0"
                            src="{{ Storage::url('public/images/cars/' . $selectedCar['path']) }}"
                            alt="{{ $selectedCar['name'] }}" />
                    @endif

                    <span class="font-bold ">Perioada:
                        {{ $rawData['rent_date']['pickup_date'] . ' ' . $rawData['rent_date']['pickup_time'] }} ~
                        {{ $rawData['rent_date']['return_date'] . ' ' . $rawData['rent_date']['return_time'] }}
                        ({{ $nrZileDeInchiriere !== 1 ? $nrZileDeInchiriere . ' zile' : $nrZileDeInchiriere . ' zi' }})
                    </span>
                    
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left">{{ __('translations.additional_services_description') }}</th>
                                <th class="text-left">{{ __('translations.additional_services_price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buyOptions ?? [] as $key => $value)
                                @if (isset($value['showPriceDetails']) && $value['showPriceDetails'])
                                    <tr>
                                        <td class="py-2">
                                            {{ $value['nume'] }}
                                            <br>
                                            {{ $nrZileDeInchiriere }}
                                            {{ $nrZileDeInchiriere === 1 ? 'Zi' : 'Zile' }} x
                                            {{ $value['pret'] }} Lei / Zi
                                        </td>
                                        <td>{{ (float) $value['pret'] }} Lei</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="py-2">{{ $value['nume'] }}</td>
                                        <td class="py-2">{{ $value['pret'] }} Lei</td>
                                    </tr>
                                @endif
                            @endforeach

                            <tr>
                                <td class="py-2 font-bold">{{ __('translations.additional_services_t_price') }}:</td>
                                <td class="py-2 font-bold">{{ $checkoutPrice }} Lei</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-span-1 right-checkout">

                    <!-- Input fields -->
                    @foreach ($right_inputs ?? [] as $value)
                        @include('common.genericInputFields', $value)
                    @endforeach

                    <!-- Go to Section 4 Btn !Auth::check() -->
                    @include('common.generic-btn', [
                        'btn_content' => 'Continuați cu plata',
                        'wire_method' => 'changeSection("4")',
                        'onclick' => 'goTop()',
                        'class' =>
                            (!Auth::check() && !$rawData['check_out']['have_account']) || Auth::check()
                                ? 'w-full p-2 mt-4 rounded-md ' . getConstant('modal_generic_colors')['purple']
                                : 'w-full p-2 mt-4 rounded-md cursor-not-allowed ' .
                                    getConstant('modal_generic_colors')['purple'],
                    ])

                </div>
            </div>
        </div>
    </div>

</section>
