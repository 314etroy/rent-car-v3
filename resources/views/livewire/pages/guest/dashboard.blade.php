@props([
    'emitToPath' => 'components.delete-order-modal',
    'emitToMethod' => 'show',
])

<section>
    <div class="w-full text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 py-8">Comenzi realizate</h1>
    </div>

    <div class="p-1">
        @forelse ($tableData ?? [] as $value)
            <div
                class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 md:grid-cols-5 bg-white dark:bg-gray-800">
                <figure
                    class="flex flex-col items-center p-8 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e justify-center dark:bg-gray-800 dark:border-gray-700">
                    <img class="object-cover w-full rounded-t-lg h-80 md:h-auto md:w-72 md:rounded-none md:rounded-s-lg"
                        src="{{ Storage::url('public/images/cars/' . $value['carImage']) }}" alt="{{ uniqid() }}" />
                </figure>
                <figure
                    class="bg-white border-b border-gray-200 col-span-2 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center md:border-e md:rounded-ss-lg md:rounded-t-none rounded-t-lg text-center">
                    <blockquote class="dark:text-gray-400 max-w-2xl text-gray-500 mt-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $value['carName'] }}</h3>
                    </blockquote>

                    <div class="p-2 w-full">
                        <div class="w-full">

                            <p
                                class="dark:text-white font-bold border-b-2 mb-1 pb-1 text-gray-900 text-left text-sm truncate">
                                Nr. comandă: {{ $value['codeId'] }}
                            </p>

                            <p class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                Preț închiriere pe zi: {{ $value['pricePerDay'] }} lei
                            </p>
                            <p class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                Perioadă închiriere: {{ $value['nrOfDays'] }}
                                {{ $value['nrOfDays'] > 1 ? 'zile' : 'zi' }}
                            </p>
                            <p class="text-sm text-left text-black truncate">
                                {{ $value['pickUpDateTime'] }} ~ {{ $value['returnDateTime'] }}
                            </p>
                            <p class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                Ridicare și predare autovehicul:
                            </p>
                            <p class="text-sm text-left text-black truncate">
                                {{ ucfirst($value['location']) }}
                            </p>
                            <p class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                Nr. înmatriculare: {{ $value['nrInmatriculare'] }}
                            </p>
                            @if (
                                $value['additionalDriver'] &&
                                    !$value['isDeletedOrder'] &&
                                    \Carbon\Carbon::parse($value['pickUpDateTime']) >= \Carbon\Carbon::now())
                                <p
                                    class="border-t-2 dark:text-white font-bold mt-2 pt-1 text-gray-900 text-left text-sm truncate">
                                    Nume șofer adițional:
                                </p>
                                <div class="text-sm text-left text-black truncate">
                                    <input type="search" wire:model="input.{{ $value['codeId'] }}"
                                        placeholder="Numele șoferului adițional" class="w-60">
                                    @if ($input[$value['codeId']] !== $dbAdditionalDriver[$value['codeId']])
                                        <button class="bg-green-500 hover:underline ml-1 p-2.5 pt-3 text-white w-40"
                                            wire:click="handleAdditionalDriver('{{ $value['codeId'] }}')">
                                            Salvează
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </figure>
                <figure
                    class="bg-white border-b border-gray-200 col-span-2 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-center justify-center md:border-e md:rounded-ss-lg md:rounded-t-none rounded-t-lg text-center">
                    <div class="p-2 w-full">
                        <div class="w-full mt-2 mb-1">
                            <p class="dark:text-white font-bold text-gray-900 text-left text-sm truncate">
                                Detalii închiriere
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
                                            {{ $value['nrOfDays'] }}
                                            {{ $value['nrOfDays'] > 1 ? 'zile' : 'zi' }} x {{ $value['pricePerDay'] }}
                                            lei = {{ $value['nrOfDays'] * $value['pricePerDay'] }} lei
                                        </div>
                                    </div>
                                </li>
                                <li class="">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <p
                                                class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                                Garantie
                                            </p>
                                        </div>
                                        <div
                                            class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $value['garantie'] }} lei
                                        </div>
                                    </div>
                                </li>
                                @foreach ($value['aditionalEquipments'] ?? [] as $equipment)
                                    <li class="">
                                        <div class="flex items-center">
                                            <div class="flex-1">
                                                <p
                                                    class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                                    {{ $equipment['name'] }}
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $equipment['price'] }} lei
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                @foreach ($value['aditionalServices'] ?? [] as $service)
                                    <li class="">
                                        <div class="flex items-center">
                                            <div class="flex-1">
                                                <p
                                                    class="dark:text-white font-medium text-gray-900 text-left text-sm truncate">
                                                    {{ $service['name'] }}
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $service['price'] }} lei
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                <li class="">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <p
                                                class="dark:text-white font-bold text-gray-900 text-left text-sm truncate">
                                                Total:
                                            </p>
                                        </div>
                                        <div
                                            class="inline-flex items-center text-base font-bold text-gray-900 dark:text-white">
                                            {{ $value['price'] }} lei
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="px-2 pb-2 w-full">
                        {{-- @dd(\Carbon\Carbon::parse($value['pickUpDateTime']), \Carbon\Carbon::now(), \Carbon\Carbon::parse($value['pickUpDateTime']) >= \Carbon\Carbon::now()) --}}
                        @if (\Carbon\Carbon::parse($value['pickUpDateTime']) >= \Carbon\Carbon::now() && !$value['isDeletedOrder'])
                            <button class="font-medium w-full text-white bg-red-500 hover:underline p-2"
                                wire:click="{{ handleEmitTo($emitToPath, $emitToMethod, handleModalDeleteData(['code' => $value['codeId']])) }}">
                                Anulează comanda
                            </button>
                            {{-- @else
                            <div class="font-medium w-full text-black bg-gray-300 p-2 cursor-not-allowed">
                                Comandă realizată
                            </div> --}}
                        @endif
                    </div>
                </figure>
            </div>
        @empty
            <div class="pb-8">
                <div
                    class="w-full flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <h5 class="w-full p-4 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
                        Nu am
                        găsit nici o comandă.</h5>
                </div>
            </div>
        @endforelse
    </div>
</section>
