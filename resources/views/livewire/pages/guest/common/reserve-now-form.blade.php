@php
    [
        'rent_date' => [
            'return_to_another_location' => $return_to_another_location,
        ],
    ] = $rawData;
@endphp

@props([
    'firstColumn' => [
        [
            'type' => 'select',
            'key' => 'alege-locația',
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'selectDefaultText' => 'Selecteaza orasul',
            'allOptions' => [
                'bucuresti' => 'București',
                'brasov' => 'Brașov Aeroport Ghimbav',
                'campulung' => 'Câmpulung',
            ],
            'wireModelName' => 'rawData.rent_date.location',
            'isRequired' => true,
        ],
        [
            'type' => 'date',
            'key' => 'alege-dată',
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.pickup_date',
            'isRequired' => true,
        ],
        [
            'type' => 'time',
            'key' => 'ora-ridicării',
            'step' => '1800',
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.pickup_time',
            'isRequired' => true,
        ],
    ],
    'secondColumn' => [
        [
            'type' => $return_to_another_location ?? null ? 'hidden' : 'checkbox',
            'hideLabel' => $return_to_another_location ?? null,
            'key' => 'predarea-în-altă-locație',
            'divClass' =>
                $return_to_another_location ?? null ? '' : 'flex flex-row-reverse gap-4 items-center justify-end mt-3',
            'emptyLabelClass' => $return_to_another_location ?? null ? '' : 'mb-4',
            'emptyInputClass' => 'mt-2 mb-3',
            'wireModelName' => 'rawData.rent_date.return_to_another_location',
        ],
        [
            'type' => $return_to_another_location ?? null ? 'select' : 'hidden',
            'hideLabel' => $return_to_another_location ?? null ? false : true,
            'key' => 'locație-predare',
            'showValidationMsg' => false,
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'selectDefaultText' => 'Selectează orașul',
            'allOptions' => [
                'bucuresti' => 'București',
                'brasov' => 'Brașov Aeroport Ghimbav',
                'campulung' => 'Câmpulung',
            ],
            'wireModelName' => 'rawData.rent_date.return_location',
        ],
        [
            'type' => 'date',
            'key' => 'dată-predare',
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.return_date',
            'isRequired' => true,
        ],
        [
            'type' => 'time',
            'key' => 'ora-predării',
            'step' => '1800',
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.return_time',
            'isRequired' => true,
        ],
    ],
])

{{-- Reserve-now-Form --}}
<section>

    <div class="bg-white p-8 rounded-md">
        
        {{-- @dd($rawData['rent_date']['pickup_date']) --}}
        @if ($showDateError)
            @include('common.reserve-now-error-msg1')
        @endif
        <div class="gap-4 grid grid-cols-2">
            <!-- First Column -->
            <div>
                @foreach ($firstColumn ?? [] as $value)
                    <div class="mb-4">
                        @include('common.genericInputFields', $value)
                    </div>
                @endforeach
            </div>

            <!-- Second Column -->
            <div class="{{ $return_to_another_location ?? null ? '' : 'mt-[26px]' }}">
                @foreach ($secondColumn ?? [] as $index => $value)
                    <div class="{{ $value['type'] === 'hidden' ? '' : 'mb-4' }}">
                        @include('common.genericInputFields', $value)
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Go to Reserve-now-Form Btn -->
        @include('common.generic-btn', [
            'btn_content' => 'Închiriază mașina',
            'wire_method' => 'changeSection("1")',
            'class' => 'w-full p-2 rounded-md ' . getConstant('modal_generic_colors')['purple'],
        ])

    </div>

</section>
