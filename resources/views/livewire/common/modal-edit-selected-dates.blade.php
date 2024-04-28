@props([
    'formFields' => [
        [
            'type' => 'text',
            'key' => __('translations.translate_name'),
            'placeholder' => handlePlaceholder(__('translations.translate_name')),
            'isRequired' => true,
            'wireModelName' => 'rawData.form_data.name',
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => __('translations.translate_first_name'),
            'isRequired' => true,
            'placeholder' => handlePlaceholder(__('translations.translate_first_name')),
            'wireModelName' => 'rawData.form_data.first_name',
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => __('translations.translate_company_name'),
            'placeholder' => handlePlaceholder(__('translations.translate_company_name')),
            'wireModelName' => 'rawData.form_data.company_name',
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => __('translations.translate_cui'),
            'placeholder' => handlePlaceholder(__('translations.translate_cui')),
            'wireModelName' => 'rawData.form_data.cui',
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
        ],
        [
            'type' => 'select',
            'key' => 'țară-/-regiune',
            'wireModelName' => 'rawData.form_data.contry_region',
            'isRequired' => true,
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'labelClass' => config('constants.common_css.calendar_modal_form.label_Class'),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_select'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_select'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_select'),
            'selectDefaultText' => __('translations.translate_select_contry_region'),
            'allOptions' => config('constants.all_country_options'),
            'showDefaultOption' => true,
        ],
        [
            'type' => 'text',
            'isRequired' => true,
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'key' => __('translations.translate_complete_address'),
            'placeholder' => handlePlaceholder(__('translations.translate_complete_address')),
            'wireModelName' => 'rawData.form_data.complete_address',
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
        ],
        [
            'type' => 'tel',
            'key' => __('translations.translate_phone'),
            'isRequired' => true,
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'placeholder' => handlePlaceholder(__('translations.translate_phone')),
            'wireModelName' => 'rawData.form_data.phone',
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
        ],
        [
            'type' => 'email',
            'isRequired' => true,
            'isDisabled' => true,
            'key' => __('translations.translate_email'),
            'placeholder' => handlePlaceholder(__('translations.translate_email')),
            'wireModelName' => 'rawData.form_data.email',
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
        ],
        [
            'type' => 'select',
            'key' => 'alege-locația',
            'isRequired' => true,
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'labelClass' => config('constants.common_css.calendar_modal_form.label_Class'),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
            'selectDefaultText' => 'Selectează orașul',
            'allOptions' => [
                'bucuresti' => 'București',
                'brasov' => 'Brașov Aeroport Ghimbav',
                'campulung' => 'Câmpulung',
            ],
            'wireModelName' => 'rawData.form_data.location',
        ],
        [
            'type' => 'time',
            'key' => 'ora-preluării',
            'id' => 'time123',
            'isRequired' => true,
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'labelClass' => config('constants.common_css.calendar_modal_form.label_Class'),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
            'wireModelName' => 'rawData.form_data.pickup_time',
        ],
        [
            'type' => 'time',
            'key' => 'ora-predării',
            'isRequired' => true,
            'isDisabled' => isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()),
            'labelClass' => config('constants.common_css.calendar_modal_form.label_Class'),
            'validLabelClass' => config('constants.common_css.calendar_modal_form.valid_label'),
            'errorLabelClass' => config('constants.common_css.calendar_modal_form.error_label'),
            'emptyLabelClass' => config('constants.common_css.calendar_modal_form.empty_label'),
            'validInputClass' => config('constants.common_css.calendar_modal_form.valid_input'),
            'errorInputClass' => config('constants.common_css.calendar_modal_form.error_input'),
            'emptyInputClass' => config('constants.common_css.calendar_modal_form.empty_input'),
            'wireModelName' => 'rawData.form_data.return_time',
        ],
    ],
])

<div>
    @if ($showComponent)
        <div wire:ignore.self=""
            class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full justify-center items-center flex">
            <div wire:click="$emitSelf('hideEditModalSelectedDates')"
                class="bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40 w-full"></div>

            <div class="relative w-[1024px]">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 z-50">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        wire:click="$emitSelf('hideEditModalSelectedDates')">
                        @include('svg.modal-close-icon')
                    </button>

                    <div class="px-6 py-6 lg:px-8">
                        @if ($showDateError)
                            @include('common.reserve-now-error-msg1')
                        @endif

                        @if ($firstSelectedCard === $lastSelectedCard)
                            <div class="flex justify-between mt-4 w-full ">
                                <h3 class="my-4 w-1/3 text-xl text-center font-medium text-gray-900 dark:text-white">
                                    Dată selectată:
                                    <br>
                                    {{ $firstSelectedCard }}
                                </h3>
                                <h3 class="my-4 w-2/3 text-xl text-center font-bold text-gray-900 dark:text-white">
                                    {{ $selectedCarData['nume'] }}
                                    <br>
                                    {{ $selectedCarData['nr_inmatriculare'] }}
                                </h3>
                            </div>
                        @else
                            <div class="flex justify-between mt-4 w-full ">
                                <h3 class="mb-4 text-m font-medium text-gray-900 dark:text-white">
                                    Început interval:
                                    <br>
                                    {{ $firstSelectedCard }}
                                </h3>
                                <h3 class="mb-4 text-center font-bold text-gray-900 dark:text-white">
                                    {{ $selectedCarData['nume'] }}
                                    <br>
                                    {{ $selectedCarData['nr_inmatriculare'] }}
                                </h3>
                                <h3 class="mb-4 text-m font-medium text-gray-900 dark:text-white">
                                    Sfârșit interval:
                                    <br>
                                    {{ $lastSelectedCard }}
                                </h3>
                            </div>
                        @endif

                        @if (!isDayBeforeToday($pick_up_dateTime ?? currentYearMonthAndDay()))
                            <button type="button" wire:click="handleCheckoutOrderAccordion"
                                class="w-full mt-2 text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none font-medium text-sm px-5 py-2.5 text-center">Anulează
                                comanda</button>

                            @if ($showDeleteBtn ?? true)
                                <div
                                    class="border border-gray-200 dark:border-gray-600 flex items-center justify-between mb-4 p-2 rounded-b">
                                    <button type="button" wire:click="handleCheckoutOrderAccordion"
                                        class="bg-gray-200 border border-gray-200 dark:bg-gray-800 dark:border-gray-600 dark:focus:ring-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-200 dark:text-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-100 focus:z-10 font-medium hover:bg-gray-100 hover:text-blue-700 ms-3 px-5 py-2.5 rounded-lg text-gray-900 text-sm w-1/3"
                                        wire:click="deleteCheckoutOrder">Nu</button>
                                    <button type="button" wire:click="deleteCheckoutOrder"
                                        class="bg-red-700 dark:bg-red-600 dark:focus:ring-red-800 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium hover:bg-red-800 px-5 py-2.5 rounded-lg text-center text-sm text-white w-1/3">Șterge</button>
                                </div>
                            @endif
                        @endif

                        {{-- Code --}}
                        <div class="grid grid-cols-3 gap-5">
                            <div>
                                @foreach ($formFields ?? [] as $index => $value)
                                    <div class="{{ $value['type'] === 'hidden' ? '' : 'mb-4' }}">
                                        @include('common.genericInputFields', $value)
                                    </div>
                                @endforeach
                                @if ($haveAdditionalDriver)
                                    @include('common.genericInputFields', [
                                        'type' => 'search',
                                        'key' => 'Șofer adițional',
                                        'placeholder' => 'Adaugă numele șoferului adițional',
                                        'isDisabled' => isDayBeforeToday(
                                            $pick_up_dateTime ?? currentYearMonthAndDay()),
                                        'wireModelName' => 'rawData.form_data.additional_driver_name',
                                        'validLabelClass' => config(
                                            'constants.common_css.calendar_modal_form.valid_label'),
                                        'errorLabelClass' => config(
                                            'constants.common_css.calendar_modal_form.error_label'),
                                        'emptyLabelClass' => config(
                                            'constants.common_css.calendar_modal_form.empty_label'),
                                        'validInputClass' => config(
                                            'constants.common_css.calendar_modal_form.valid_input'),
                                        'errorInputClass' => config(
                                            'constants.common_css.calendar_modal_form.error_input'),
                                        'emptyInputClass' =>
                                            config('constants.common_css.calendar_modal_form.empty_input') .
                                            ' bg-green-500',
                                    ])
                                @endif
                            </div>

                            <div>
                                <div class="flex flex-col">
                                    <div class="p-2 w-full">
                                        @if ($additionalEquipmentData)
                                            <div class="border-b-2 border-gray-400 mb-1 mt-2 pb-4 w-full">
                                                <div class="flex justify-center mb-1 mt-2 w-full">
                                                    <span class="font-bold text-gray-900 text-center text-m truncate">
                                                        {{ __('translations.additional_services_equipment') }}
                                                    </span>
                                                </div>
                                                <div class="gap-4 grid grid-cols-2">

                                                    @php
                                                        $i = 0;
                                                    @endphp

                                                    @foreach ($additionalEquipmentData ?? [] as $value)
                                                        <div class="flex-col">
                                                            <span
                                                                @if (isOdd($i)) class="flex justify-end" @endif>{{ $value['nume'] }}</span>
                                                            <div
                                                                class="flex items-center @if (isOdd($i)) justify-end @endif">
                                                                <input type="checkbox" disabled
                                                                    wire:model='{{ 'rawData.equipments_data.' . $value['code'] }}'>
                                                                <span
                                                                    class="ml-2">{{ $value['pret'] . '  Lei' }}</span>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach

                                                </div>
                                            </div>
                                        @endif

                                        @if (count($additionalServicesData))
                                            <div class="flex justify-center mb-1 mt-2 w-full">
                                                <span
                                                    class="font-bold text-gray-900 text-center text-m truncate">{{ __('translations.additional_services_section') }}</span>
                                            </div>
                                        @endif

                                        @foreach ($additionalServicesData ?? [] as $value)
                                            <div class="w-full mt-2 mb-1">
                                                <p
                                                    class="dark:text-white font-bold text-gray-900 text-center text-sm truncate">
                                                    {{ $value['nume'] }}
                                                </p>
                                                <div class="flex justify-between">
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($value['services'] ?? [] as $service)
                                                        <div class="flex-col">
                                                            <span
                                                                @if (isOdd($i)) class="flex justify-end" @endif>{{ $service['comment'] }}</span>
                                                            <div
                                                                class="flex items-center @if (isOdd($i)) justify-end @endif">
                                                                <input type="checkbox" disabled
                                                                    wire:model='{{ 'rawData.services_data.' . $value['row_code'] . '.' . $service['code'] . '.' . $i }}'>
                                                                <span
                                                                    class="ml-2">{{ $service['pret'] . '  Lei' }}</span>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <div class="p-2 w-full">
                                    <div class="w-full mt-2 mb-1">
                                        <p class="dark:text-white font-bold text-gray-900 text-left text-sm truncate">
                                            Detalii închiriere:
                                        </p>
                                    </div>
                                    <div class="flow-root border-t-2">
                                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                            <li class="">
                                                <div class="flex items-center">
                                                    <div class="flex-1">
                                                        <p
                                                            class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                                            Preț perioadă
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                        {{ $nrOfDays }} {{ $nrOfDays === 1 ? 'Zi' : 'Zile' }} x
                                                        {{ $selectedCarData['pretZi'] }} Lei / Zi =
                                                        {{ $selectedCarData['pret'] }} Lei
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="flex items-center">
                                                    <div class="flex-1">
                                                        <p
                                                            class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                                            Garanție
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                        {{ $nrOfDays }} {{ $nrOfDays === 1 ? 'Zi' : 'Zile' }} x
                                                        {{ $selectedCarData['garantie'] }} Lei / Zi =
                                                        {{ $nrOfDays * $selectedCarData['garantie'] }} Lei
                                                    </div>
                                                </div>
                                            </li>

                                            @foreach ($rawData['equipments_data'] ?? [] as $key => $value)
                                                @if ($this->additionalEquipmentData && $this->additionalEquipmentData[$key]['pret'])
                                                    <li>
                                                        <div class="flex items-center">
                                                            <div class="flex-1">
                                                                <p
                                                                    class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                                                    {{ $this->additionalEquipmentData[$key]['nume'] }}
                                                                </p>
                                                            </div>
                                                            <div
                                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                                {{ $nrOfDays }}
                                                                {{ $nrOfDays === 1 ? 'Zi' : 'Zile' }} x
                                                                {{ $this->additionalEquipmentData[$key]['pret'] }} Lei / Zi
                                                                =
                                                                {{ $nrOfDays * $this->additionalEquipmentData[$key]['pret'] }}
                                                                Lei
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach

                                            @foreach ($selectedServices ?? [] as $key => $value)
                                                @if ($this->additionalServicesData && $this->additionalServicesData[$key]['services'][$value]['pret'])
                                                    <li>
                                                        <div class="flex items-center">
                                                            <div class="flex-1">
                                                                <p
                                                                    class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                                                    {{ $this->additionalServicesData[$key]['services'][$value]['comment'] }}
                                                                </p>
                                                            </div>
                                                            <div
                                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                                {{ $this->additionalServicesData[$key]['services'][$value]['pret'] }}
                                                                Lei
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach

                                            <li>
                                                <div class="flex items-center">
                                                    <div class="flex-1">
                                                        <p
                                                            class="dark:text-white font-bold text-gray-900 text-left text-sm truncate">
                                                            Total:
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="inline-flex items-center text-base font-bold text-gray-900 dark:text-white">
                                                        {{ (float) $checkoutPrice }} Lei
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (count($rawData['services_data']) === count($additionalServicesData) &&
                                !$showDateError &&
                                !isDayBeforeToday($pick_up_dateTime))
                            <button wire:click="handleCheckoutOrder" id="{{ uniqid() }}"
                                class="w-full mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Rezervă
                                mașina</button>
                        @else
                            <button id="{{ uniqid() }}"
                                class="cursor-not-allowed w-full mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Rezervă
                                mașina</button>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
