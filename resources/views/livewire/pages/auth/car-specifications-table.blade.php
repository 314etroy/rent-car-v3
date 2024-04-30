@props([
    'emitToPath' => 'components.car-specifications-modal',
    'emitToMethod' => 'show',
])

<section>
    <div class="w-full text-center p-1">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 pt-6">Date Mașini</h1>
    </div>
    <div class="relative">
        <div
            class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
            <div>
                @include('common.genericInputFields', [
                    'type' => 'search',
                    'placeholder' => 'Caută Mașină',
                    'key' => 'search',
                    'wireModelName' => 'searchCar',
                    'emptyInputClass' => config('constants.common_css.choose_car.empty_input'),
                    'hideLabel' => true,
                    'inputData' => $search ?? null,
                    'showValidationMsg' => false,
                    'style' => 'margin-left: 2px;',
                ])
            </div>
            <div>
                @include('common.generic-btn', [
                    'btn_content' => 'Adaugă Mașină',
                    'wire_method' => handleEmitTo(
                        $emitToPath,
                        $emitToMethod,
                        handleModalAddData('add', $carSpecifications->items() ?? [])),
                    'class' =>
                        'w-full p-2 bg-green-500 hover:bg-green-700 text-white border border-gray-300 rounded-md',
                ])
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @foreach (['Id', 'Nume', 'Garanție', 'Action'] ?? [] as $value)
                        <th scope="col" class="px-6 py-3 {{ $value === 'Action' ? 'text-center' : null }}">
                            {{ $value }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>

                @foreach ($carSpecifications->items() ?? [] as $index => $rowData)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        @foreach (handleTableBody($rowData->getAttributes(), ['id', 'nume', 'garantie']) ?? [] as $key => $value)
                            <td class="px-6 py-4">

                                {{ $key === 'id' ? handleLivewireTableIds($index, $carSpecifications) : $value }}

                            </td>
                        @endforeach

                        <td class="px-6 py-4 flex justify-center">
                            <!-- Modal toggle -->
                            @include('common.generic-btn', [
                                'btn_content' => 'Editează',
                                'wire_method' => handleEmitTo(
                                    $emitToPath,
                                    $emitToMethod,
                                    handleModalData(handleLivewireTableIds($index - 1, $carSpecifications),
                                        'edit',
                                        $rowData->getAttributes())),
                                'class' => 'font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2',
                            ])

                            @include('common.generic-btn', [
                                'btn_content' => 'Șterge',
                                'wire_method' => handleEmitTo(
                                    $emitToPath,
                                    $emitToMethod,
                                    handleModalData(handleLivewireTableIds($index - 1, $carSpecifications),
                                        'delete',
                                        $rowData->getAttributes())),
                                'class' => 'font-medium text-red-600 dark:text-red-500 hover:underline ml-2',
                            ])
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        @if (empty($carSpecifications->items()))
            <div class="border py-2 text-2xl text-center">{{ __('translations.no_data_to_show') }}</div>
        @endif

        <div class="py-4">
            {{ $carSpecifications->links() }}
        </div>

    </div>

</section>
