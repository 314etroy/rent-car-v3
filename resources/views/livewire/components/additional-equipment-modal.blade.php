@props([
    'inputs' => [
        [
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
        ],
        [
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
        ],
        [
            'type' => 'text',
            'key' => 'Descriere',
            'placeholder' => 'Adauga Descriere 1',
            'wireModelName' => 'modalProps.rowData.descriere',
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
            'key' => 'Pret',
            'placeholder' => 'Adauga Pret',
            'wireModelName' => 'modalProps.rowData.pret',
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
                        {{ __('translations.add_equipment') }}
                    @break

                    @case('edit')
                        {{ __('translations.edit_equipment') }}
                    @break

                    @case('delete')
                        {{ __('translations.delete_equipment') }}
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
                        @forelse ($inputs ?? [] as $key => $value)
                            @include('common.genericInputFields', $value)
                        @empty
                            <span>{{ __('translations.modal_no_fields_msg') }}</span>
                        @endforelse
                    @break

                    @case('delete')
                        {{ __('translations.delete_equipment_modal_msg') }}
                        <br>
                        {{ __('translations.equipment') }}: <b>{{ $this->modalProps['rowData']['nume'] }}</b>
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
