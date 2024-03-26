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
            'key' => 'alege-locatia',
            'isRequired' => true,
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'selectDefaultText' => 'Selecteaza orasul',
            'allOptions' => [
                'campulung' => 'Câmpulung',
                'bucuresti' => 'Bucuresti',
            ],
            'wireModelName' => 'rawData.rent_date.location',
        ],
        [
            'type' => 'date',
            'key' => 'alege-data',
            'isRequired' => true,
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.pickup_date',
        ],
        [
            'type' => 'time',
            'key' => 'ora-preluarii',
            'step' => '1800',
            'id' => 'time123',
            'isRequired' => true,
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.pickup_time',
        ],
    ],
    'secondColumn' => [
        [
            'type' => $return_to_another_location ?? null ? 'hidden' : 'checkbox',
            'hideLabel' => $return_to_another_location ?? null,
            'key' => 'predarea-in-alta-locatie',
            'divClass' =>
                $return_to_another_location ?? null ? '' : 'flex flex-row-reverse gap-4 items-center justify-end mt-3',
            'emptyLabelClass' => $return_to_another_location ?? null ? '' : 'mb-4',
            'emptyInputClass' => 'mt-2 mb-3',
            'wireModelName' => 'rawData.rent_date.return_to_another_location',
        ],
        [
            'type' => $return_to_another_location ?? null ? 'select' : 'hidden',
            'hideLabel' => $return_to_another_location ?? null ? false : true,
            'key' => 'locatie-predare',
            'showValidationMsg' => false,
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'selectDefaultText' => 'Selecteaza orasul',
            'allOptions' => [
                'campulung' => 'Câmpulung',
                'bucuresti' => 'Bucuresti',
            ],
            'wireModelName' => 'rawData.rent_date.return_location',
        ],
        [
            'type' => 'date',
            'key' => 'data-predare',
            'isRequired' => true,
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.return_date',
        ],
        [
            'type' => 'time',
            'key' => 'ora-predarii',
            'step' => '1800',
            'isRequired' => true,
            'labelClass' => config('constants.common_css.rent_date.label_Class'),
            'validLabelClass' => config('constants.common_css.rent_date.valid_label'),
            'errorLabelClass' => config('constants.common_css.rent_date.error_label'),
            'emptyLabelClass' => config('constants.common_css.rent_date.empty_label'),
            'validInputClass' => config('constants.common_css.rent_date.valid_input'),
            'errorInputClass' => config('constants.common_css.rent_date.error_input'),
            'emptyInputClass' => config('constants.common_css.rent_date.empty_input'),
            'wireModelName' => 'rawData.rent_date.return_time',
        ],
    ],
])

{{-- Section 1 --}}
<section class="mt-4 bg-white">

    <div class="mx-auto max-w-7xl px-4 bg-white flex justify-center">
        <div class="py-9">
            <div class="container relative w-[600px]">

                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 pt-6">Închiriază o mașină ușor și rapid
                    </h1>
                </div>

                <div class="bg-white p-8 rounded-md">
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

                    <!-- Go to Section 1 Btn -->
                    @include('common.generic-btn', [
                        'btn_content' => 'Inchiriază masina',
                        'wire_method' => 'changeSection("1")',
                        'onclick' => 'goTop()',
                        'class' => 'w-full p-2 rounded-md ' . getConstant('modal_generic_colors')['purple'],
                    ])

                    {{-- <pre>
                        @php
                            echo '<br/>Zile: ';
                            print_r($showDateError);
                        @endphp
                    </pre> --}}

                </div>
            </div>
        </div>
    </div>

</section>
