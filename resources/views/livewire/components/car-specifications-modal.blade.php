@props([
    'inputs' => [
        [
            'type' => 'checkbox',
            'key' => 'Display',
            'labelText' => 'Se afisează pentru utilizatori',
            'divClass' => 'flex flex-row-reverse gap-4 items-center justify-end mb-2',
            'wireModelName' => 'modalProps.rowData.display',
            'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
            'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
            'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
            'validInputClass' => config('constants.common_css.modal_inputs.valid_checkbox'),
            'errorInputClass' => config('constants.common_css.modal_inputs.error_checkbox'),
            'emptyInputClass' => config('constants.common_css.modal_inputs.empty_checkbox'),
        ],
        [
            'type' => 'text',
            'isRequired' => true,
            'key' => 'Nume mașină',
            'placeholder' => 'Adaugă nume mașină',
            'wireModelName' => 'modalProps.rowData.nume',
            'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
            'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
            'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
            'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
            'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
            'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
        ],
        [
            'type' => 'text',
            'isRequired' => true,
            'key' => 'Număr înmatriculare',
            'placeholder' => 'Adaugă număr înmatriculare',
            'wireModelName' => 'modalProps.rowData.nr_inmatriculare',
            'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
            'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
            'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
            'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
            'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
            'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
        ],
        // [
        //     'type' => 'text',
        //     'isRequired' => true,
        //     'key' => 'Culoare',
        //     'placeholder' => 'Adaugă culoare',
        //     'wireModelName' => 'modalProps.rowData.culoare',
        //     'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
        //     'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
        //     'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
        //     'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
        //     'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
        //     'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
        // ],
        [
            'type' => 'number',
            'isRequired' => true,
            'key' => 'Garanție',
            'placeholder' => 'Adaugă garanție',
            'wireModelName' => 'modalProps.rowData.garantie',
            'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
            'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
            'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
            'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
            'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
            'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
        ],
        [
            'type' => 'file',
            'isRequired' => true,
            'key' => 'Image',
            'placeholder' => 'Adaugă imagine',
            'wireModelName' => 'modalProps.rowData.image',
            'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
            'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
            'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
            'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
            'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
            'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
        ],
    ],
])

<div>
    <x-generic-modal>
        <x-slot name="modalHeader">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                @switch($modalProps['operation'])
                    @case('add')
                        {{ __('translations.add_car') }}
                    @break

                    @case('edit')
                        {{ __('translations.edit_car') }}
                    @break

                    @case('delete')
                        {{ __('translations.delete_car') }}
                    @break
                @endswitch

                <span> {{ $modalProps['operation'] !== 'add' ? $modalProps['rowId'] : null }}</span>
            </h3>
        </x-slot>

        <x-slot name="modalBody">
            <div class="p-6">

                @switch($modalProps['operation'])
                    @case('add')
                    @case('edit')
                        @if ($pretPerioadaErrorMsg)
                            @include('common.generic-btn', [
                                'btn_content' => 'Minim o intrare de Preț și Perioadă!',
                                'class' => 'w-full mb-4 ' . getConstant('modal_generic_colors')['red'],
                            ])
                        @endif

                        @forelse ($inputs ?? [] as $key => $value)
                            @include('common.genericInputFields', $value)
                        @empty
                            <span>{{ __('translations.modal_no_fields_msg') }}</span>
                        @endforelse
                    
                        @if ($isValidPhoto && !$temporaryPhoto)
                            <div class="h-[200px] flex justify-center my-4">
                                <img src="{{ Storage::url($storagePhotoLocation) }}">
                            </div>
                        @endif

                        @if ($temporaryPhoto && !$errors->has('modalProps.rowData.image'))
                            <div class="h-[200px] flex justify-center my-4">
                                <img src="{{ $temporaryPhoto->temporaryUrl() }}">
                            </div>
                        @endif

                        <div class="w-full">
                            <div x-init="console.log('I\'m being initialized!', opened_tab)" x-data="{ opened_tab: null }" class="flex flex-col">
                                <div class="flex flex-col border rounded shadow mb-2">
                                    <div @click="opened_tab = opened_tab === 0 ? null : 0 " class="p-4 cursor-pointer">
                                        @include('common.generic-btn', [
                                            'btn_content' => 'Gestionează prețul și perioada',
                                            'class' => 'w-full ' . getConstant('modal_generic_colors')['purple'],
                                        ])
                                    </div>
                                    <div x-show="opened_tab==0" class="pb-4 p-4">
                                        @include('common.generic-btn', [
                                            'btn_content' => 'Adaugă preț perioadă',
                                            'wire_method' => 'addPretPerioada()',
                                            'class' => 'w-full ' . getConstant('modal_generic_colors')['blue'],
                                        ])

                                        @for ($i = 0; $i < $nrPretPerioada; $i++)
                                            <div class="w-full mt-4 grid grid-cols-3 gap-x-4">
                                                @include('common.genericInputFields', [
                                                    'type' => 'number',
                                                    'id' => 'nr_zile' . $i,
                                                    'key' => 'Nr. zile',
                                                    'placeholder' => 'Adaugă număr de zile',
                                                    'wireModelName' =>
                                                        'modalProps.rowData.pretPerioada.' . $i . '.perioada',
                                                    'validLabelClass' => config(
                                                        'constants.common_css.check_out.valid_label'),
                                                    'errorLabelClass' => config(
                                                        'constants.common_css.check_out.error_label'),
                                                    'emptyLabelClass' => config(
                                                        'constants.common_css.check_out.empty_label'),
                                                    'validInputClass' => config(
                                                        'constants.common_css.check_out.valid_input'),
                                                    'errorInputClass' => config(
                                                        'constants.common_css.check_out.error_input'),
                                                    'emptyInputClass' => config(
                                                        'constants.common_css.check_out.empty_input'),
                                                ])
                                                @include('common.genericInputFields', [
                                                    'type' => 'number',
                                                    'id' => 'pret' . $i,
                                                    'key' => 'Preț',
                                                    'placeholder' => 'Adaugă preț',
                                                    'wireModelName' =>
                                                        'modalProps.rowData.pretPerioada.' . $i . '.pret',
                                                    'validLabelClass' => config(
                                                        'constants.common_css.check_out.valid_label'),
                                                    'errorLabelClass' => config(
                                                        'constants.common_css.check_out.error_label'),
                                                    'emptyLabelClass' => config(
                                                        'constants.common_css.check_out.empty_label'),
                                                    'validInputClass' => config(
                                                        'constants.common_css.check_out.valid_input'),
                                                    'errorInputClass' => config(
                                                        'constants.common_css.check_out.error_input'),
                                                    'emptyInputClass' => config(
                                                        'constants.common_css.check_out.empty_input'),
                                                ])
                                                @include('common.generic-btn', [
                                                    'btn_content' => 'Șterge perioada ' . $i + 1,
                                                    'wire_method' => 'deletePretPerioada(' . $i . ')',
                                                    'class' =>
                                                        'w-full mt-6 ' .
                                                        getConstant('modal_generic_colors')['red'],
                                                ])
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="flex flex-col border rounded shadow mb-2">
                                    <div @click="opened_tab = opened_tab === 1 ? null : 1 " class="p-4 cursor-pointer">
                                        @include('common.generic-btn', [
                                            'btn_content' => 'Gestionează opțiunile',
                                            'class' => 'w-full ' . getConstant('modal_generic_colors')['purple'],
                                        ])</div>
                                    <div x-show="opened_tab==1" class="px-4 pb-4">
                                        @include('common.generic-btn', [
                                            'btn_content' => 'Adaugă opțiune',
                                            'wire_method' => 'addOptiune()',
                                            'class' => 'w-full ' . getConstant('modal_generic_colors')['blue'],
                                        ])

                                        @for ($i = 0; $i < $nrOptiune; $i++)
                                            <div class="w-full mt-4 grid grid-cols-3 gap-x-4">
                                                @include('common.genericInputFields', [
                                                    'type' => 'text',
                                                    'id' => 'nume_optiune' . $i,
                                                    'key' => 'Nume opțiune',
                                                    'placeholder' => 'Adaugă nume opțiune',
                                                    'wireModelName' =>
                                                        'modalProps.rowData.optiune.' . $i . '.nume',
                                                    'validLabelClass' => config(
                                                        'constants.common_css.check_out.valid_label'),
                                                    'errorLabelClass' => config(
                                                        'constants.common_css.check_out.error_label'),
                                                    'emptyLabelClass' => config(
                                                        'constants.common_css.check_out.empty_label'),
                                                    'validInputClass' => config(
                                                        'constants.common_css.check_out.valid_input'),
                                                    'errorInputClass' => config(
                                                        'constants.common_css.check_out.error_input'),
                                                    'emptyInputClass' => config(
                                                        'constants.common_css.check_out.empty_input'),
                                                ])
                                                @include('common.genericInputFields', [
                                                    'type' => 'text',
                                                    'id' => 'descriere_optiune' . $i,
                                                    'key' => 'Descriere opțiune',
                                                    'placeholder' => 'Adaugă descriere opțiune',
                                                    'wireModelName' =>
                                                        'modalProps.rowData.optiune.' . $i . '.descriere',
                                                    'validLabelClass' => config(
                                                        'constants.common_css.check_out.valid_label'),
                                                    'errorLabelClass' => config(
                                                        'constants.common_css.check_out.error_label'),
                                                    'emptyLabelClass' => config(
                                                        'constants.common_css.check_out.empty_label'),
                                                    'validInputClass' => config(
                                                        'constants.common_css.check_out.valid_input'),
                                                    'errorInputClass' => config(
                                                        'constants.common_css.check_out.error_input'),
                                                    'emptyInputClass' => config(
                                                        'constants.common_css.check_out.empty_input'),
                                                ])
                                                @include('common.generic-btn', [
                                                    'btn_content' => 'Șterge opțiune ' . $i + 1,
                                                    'wire_method' => 'deleteOptiune(' . $i . ')',
                                                    'class' =>
                                                        'w-full mt-6 ' .
                                                        getConstant('modal_generic_colors')['red'],
                                                ])
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                {{-- <div class="flex flex-col border rounded shadow mb-2">
                                    <div @click="opened_tab = opened_tab === 2 ? null : 2 " class="p-4 cursor-pointer">
                                        @include('common.generic-btn', [
                                            'btn_content' => 'Preț specific / dată',
                                            'class' => 'w-full ' . getConstant('modal_generic_colors')['purple'],
                                        ])</div>
                                    <div x-show="opened_tab==2" class="px-4 pb-4">
                                        @include('common.generic-btn', [
                                            'btn_content' => 'Adaugă preț specific',
                                            'wire_method' => 'addPretSpecific()',
                                            'class' => 'w-full ' . getConstant('modal_generic_colors')['blue'],
                                        ])

                                        @for ($i = 0; $i < $nrPretSpecific; $i++)
                                            <div class="w-full mt-4 grid grid-cols-3 gap-x-4">
                                                @include('common.genericInputFields', [
                                                    'type' => 'date',
                                                    'id' => 'data_pretSpecific' . $i,
                                                    'key' => 'Data dorită',
                                                    'placeholder' => 'Adaugă dată',
                                                    'wireModelName' =>
                                                        'modalProps.rowData.pretSpecific.' . $i . '.data',
                                                    'validLabelClass' => config(
                                                        'constants.common_css.check_out.valid_label'),
                                                    'errorLabelClass' => config(
                                                        'constants.common_css.check_out.error_label'),
                                                    'emptyLabelClass' => config(
                                                        'constants.common_css.check_out.empty_label'),
                                                    'validInputClass' => config(
                                                        'constants.common_css.check_out.valid_input'),
                                                    'errorInputClass' => config(
                                                        'constants.common_css.check_out.error_input'),
                                                    'emptyInputClass' => config(
                                                        'constants.common_css.check_out.empty_input'),
                                                ])
                                                @include('common.genericInputFields', [
                                                    'type' => 'text',
                                                    'id' => 'pret_pretSpecific' . $i,
                                                    'key' => 'Preț',
                                                    'placeholder' => 'Adaugă preț',
                                                    'wireModelName' =>
                                                        'modalProps.rowData.pretSpecific.' . $i . '.pret',
                                                    'validLabelClass' => config(
                                                        'constants.common_css.check_out.valid_label'),
                                                    'errorLabelClass' => config(
                                                        'constants.common_css.check_out.error_label'),
                                                    'emptyLabelClass' => config(
                                                        'constants.common_css.check_out.empty_label'),
                                                    'validInputClass' => config(
                                                        'constants.common_css.check_out.valid_input'),
                                                    'errorInputClass' => config(
                                                        'constants.common_css.check_out.error_input'),
                                                    'emptyInputClass' => config(
                                                        'constants.common_css.check_out.empty_input'),
                                                ])
                                                @include('common.generic-btn', [
                                                    'btn_content' => 'Șterge opțiune ' . $i + 1,
                                                    'wire_method' => 'deletePretSpecific(' . $i . ')',
                                                    'class' =>
                                                        'w-full mt-6 ' .
                                                        getConstant('modal_generic_colors')['red'],
                                                ])
                                            </div>
                                        @endfor
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    @break

                    @case('delete')
                        {{ __('translations.delete_car_modal_msg') }}
                        <br>
                        {{ __('translations.car') }}: <b>{{ $modalProps['rowData']['nume'] }}</b>
                    @break

                @endswitch

            </div>
        </x-slot>

        <x-slot name="modalFooter">
            <div
                class="flex justify-end items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                @switch($modalProps['operation'])
                    @case('add')
                        @include('common.generic-btn', [
                            'btn_content' => __('translations.add'),
                            'wire_method' => 'create()',
                            'class' => getConstant('modal_generic_colors')['green'],
                        ])
                    @break

                    @case('edit')
                        @include('common.generic-btn', [
                            'btn_content' => __('translations.edit'),
                            'wire_method' => 'update()',
                            'class' => getConstant('modal_generic_colors')['blue'],
                        ])
                    @break

                    @case('delete')
                        @include('common.generic-btn', [
                            'btn_content' => __('translations.delete'),
                            'wire_method' => 'delete()',
                            'class' => getConstant('modal_generic_colors')['red'],
                        ])
                    @break
                @endswitch
            </div>
        </x-slot>
    </x-generic-modal>
</div>
