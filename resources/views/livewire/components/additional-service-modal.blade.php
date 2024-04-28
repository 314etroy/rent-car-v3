@props([
    'inputs' => [
        [
            'type' => 'text',
            'isRequired' => true,
            'key' => 'Comment 1',
            'placeholder' => 'Adauga comment 1',
            'wireModelName' => 'modalProps.rowData.comment1',
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
            'key' => 'Comment 2',
            'placeholder' => 'Adauga comment 2',
            'wireModelName' => 'modalProps.rowData.comment2',
            'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
            'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
            'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
            'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
            'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
            'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => 'Descriere 1',
            'placeholder' => 'Adauga Descriere 1',
            'wireModelName' => 'modalProps.rowData.descriere1',
            'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
            'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
            'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
            'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
            'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
            'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
        ],
        [
            'type' => 'text',
            'key' => 'Descriere 2',
            'placeholder' => 'Adauga Descriere 2',
            'wireModelName' => 'modalProps.rowData.descriere2',
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
            'key' => 'Pret 1',
            'placeholder' => 'Adauga Pret 1',
            'wireModelName' => 'modalProps.rowData.pret1',
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
            'key' => 'Pret 2',
            'placeholder' => 'Adauga Pret 2',
            'wireModelName' => 'modalProps.rowData.pret2',
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
                        {{ __('translations.add_service') }}
                    @break

                    @case('edit')
                        {{ __('translations.edit_service') }}
                    @break

                    @case('delete')
                        {{ __('translations.delete_service') }}
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
                        <div class="w-full">
                            @include('common.genericInputFields', [
                                'type' => 'checkbox',
                                'key' => 'Display',
                                'labelText' => 'Se afiseaza pentru utilizatori',
                                'divClass' => 'flex flex-row-reverse gap-4 items-center justify-end mb-2',
                                'wireModelName' => 'modalProps.rowData.display',
                                'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
                                'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
                                'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
                                'validInputClass' => config('constants.common_css.modal_inputs.valid_checkbox'),
                                'errorInputClass' => config('constants.common_css.modal_inputs.error_checkbox'),
                                'emptyInputClass' => config('constants.common_css.modal_inputs.empty_checkbox'),
                            ])

                            @include('common.genericInputFields', [
                                'type' => 'text',
                                'isRequired' => true,
                                'key' => 'Nume',
                                'placeholder' => 'Adauga Nume',
                                'wireModelName' => 'modalProps.rowData.nume',
                                'validLabelClass' => config('constants.common_css.modal_inputs.valid_label'),
                                'errorLabelClass' => config('constants.common_css.modal_inputs.error_label'),
                                'emptyLabelClass' => config('constants.common_css.modal_inputs.empty_label'),
                                'validInputClass' => config('constants.common_css.modal_inputs.valid_input'),
                                'errorInputClass' => config('constants.common_css.modal_inputs.error_input'),
                                'emptyInputClass' => config('constants.common_css.modal_inputs.empty_input'),
                            ])
                        </div>
                        <div class="w-full mt-4 grid grid-cols-2 gap-x-4">
                            @forelse ($inputs ?? [] as $key => $value)
                                @include('common.genericInputFields', $value)
                            @empty
                                <span>{{ __('translations.modal_no_fields_msg') }}</span>
                            @endforelse
                        </div>
                    @break

                    @case('delete')
                        {{ __('translations.delete_service_modal_msg') }}
                        <br>
                        {{ __('translations.service') }}: <b>{{ $this->modalProps['rowData']['nume'] }}</b>
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
