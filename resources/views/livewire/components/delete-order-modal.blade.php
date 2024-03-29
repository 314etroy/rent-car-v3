<div>
    <x-generic-modal>
        <x-slot name="modalHeader">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                @switch($modalProps['operation'])
                    @case('delete')
                        Șterge comandă
                    @break
                @endswitch
            </h3>
        </x-slot>

        <x-slot name="modalBody">
            <div class="p-6">

                @switch($modalProps['operation'])
                    @case('delete')
                        Ești sigur că vrei să ștergi acestă comandă?
                        <br>
                        Comanda: <b>{{ $modalProps['rowData']['orderId'] }}</b>
                    @break
                @endswitch

            </div>
        </x-slot>

        <x-slot name="modalFooter">
            <div
                class="flex justify-end items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                @switch($modalProps['operation'])
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
