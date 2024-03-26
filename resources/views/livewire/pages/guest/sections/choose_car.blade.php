{{-- Section 2 --}}
<section class="mt-4">
    <div>
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 bg-white">
            <div class="border-b border-gray-200 pb-6 pt-8">
                {{-- Left Content --}}
                <h1 class="text-4xl font-bold text-center tracking-tight text-gray-900">
                    {{ __('translations.choose_car_section') }}
                </h1>

                {{-- Right Content --}}
                @if (count($sort_options ?? []))

                    <div class="flex items-center">
                        <div class="relative inline-block text-left">
                            <div>
                                <button type="button"
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                    id="menu-button" aria-expanded="false" aria-haspopup="true">
                                    Sort
                                    @include('svg.dropdown-down-arrow', [
                                        'class' =>
                                            '-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500',
                                    ])
                                </button>
                            </div>


                            <div class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">

                                    @foreach ($sort_options ?? [] as $value)
                                        <button
                                            class="text-gray-500 block px-4 py-2 text-sm">{{ $value }}</button>
                                    @endforeach

                                </div>
                            </div>


                        </div>

                        <button type="button"
                            class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden">
                            <span class="sr-only">Filters</span>
                            @include('svg.dropdown-down-arrow', ['class' => 'h-5 w-5'])
                        </button>

                    </div>
                @endif
            </div>

            <section aria-labelledby="products-heading" class="pb-6 pt-6">
                <div class="grid grid-cols-5 gap-6">

                    <!-- Content grid -->
                    <div class="col-span-6">
                        <!-- Your content -->

                        <div class="grid grid-cols-2">
                            
                            @foreach ($carsData ?? [] as $value)
                                <div class="mx-auto px-5 mb-4 w-full">
                                    <div
                                        class="cursor-pointer rounded-lg {{ $value['isSelected'] ? 'selected-car' : 'bg-white' }} p-2 shadow duration-150 hover:scale-105 hover:shadow-md w-full {{ array_search($value['code'], $unavailableCars) ? 'indisponibil' : null }}">
                                        <img class="w-full h-[300px] rounded-lg object-cover object-center flex-shrink-0"
                                            src="{{ Storage::url('public/images/cars/' . $value['image']) }}"
                                            alt="{{ $value['nume'] }}" />
                                        <div>
                                            <div class="my-6 flex items-center justify-between px-4">
                                                <p class="font-bold text-gray-500">{{ $value['nume'] }}</p>
                                                <p
                                                    class="rounded-full bg-[#7963e0] px-2 py-0.5 text-xs font-semibold text-white">
                                                    de la {{ (float) $pretZiPerCode[$value['code']] ?? 0 }} Lei / Zi</p>
                                            </div>

                                            <div class="my-6 flex items-center justify-between px-4">
                                                <p class="font-bold text-gray-500">Garantie</p>
                                                <p
                                                    class="rounded-full bg-[#7963e0] px-2 py-0.5 text-xs font-semibold text-white">
                                                    {{ (float) $value['garantie'] ?? 0 }} Lei
                                                </p>
                                            </div>

                                            @foreach ($value['options'] ?? [] as $key => $option)
                                                <div class="my-4 flex items-center justify-between px-4">
                                                    <p class="text-sm font-semibold text-gray-500">{{ ucfirst($key) }}
                                                    </p>
                                                    <p
                                                        class="rounded-full bg-gray-200 px-2 py-0.5 text-xs font-semibold text-gray-600">
                                                        {{ ucfirst($option) }}</p>
                                                </div>
                                            @endforeach

                                            <div class="my-6 flex items-center justify-between px-4">
                                                <p class="font-bold text-gray-500">Pentru perioada:</p>
                                            </div>

                                            <div class="my-6 flex items-center justify-between px-4">
                                                <p class="font-bold text-gray-500">
                                                    {{ $rawData['rent_date']['pickup_date'] }} ~
                                                    {{ $rawData['rent_date']['return_date'] }}</p>
                                                <p
                                                    class="rounded-full bg-[#7963e0] px-2 py-0.5 text-xs font-semibold text-white">
                                                    @if ($nrZileDeInchiriere !== 0)
                                                        @if ($nrZileDeInchiriere === 1)
                                                            1 Zi
                                                        @else
                                                            {{ $nrZileDeInchiriere . ' zile' }}
                                                        @endif
                                                        x
                                                        {{ (float) $pretZiPerCode[$value['code']] ?? 0 }} Lei / Zi =
                                                        {{ !empty($handlePriceForEachCar) ? (float) $handlePriceForEachCar[$value['code']] : 0 }}
                                                        Lei
                                                    @else
                                                        1 Zi x {{ (float) $pretZiPerCode[$value['code']] ?? 0 }} Lei /
                                                        Zi =
                                                        {{ !empty($handlePriceForEachCar) ? (float) $handlePriceForEachCar[$value['code']] : 0 }}
                                                        Lei
                                                    @endif
                                                </p>
                                            </div>

                                            @if (!array_search($value['code'], $unavailableCars))
                                                <!-- Go to Section 2 Btn -->
                                                @include('common.generic-btn', [
                                                    'btn_content' => 'Alege masina',
                                                    'wire_method' => 'choseCar("' . $value['code'] . '", "' . $value['nume'] . '" ,"' . $value['image'] . '")',
                                                    'onclick' => 'goTop()',
                                                    'class' =>
                                                        'w-full p-2 rounded-md ' .
                                                        getConstant('modal_generic_colors')['purple'],
                                                ])
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{-- <pre>
                            @php
                                print_r('<br');
                                print_r($nrZileDeInchiriere);
                                print_r('<br>');
                                print_r($pretZiPerCode);
                            @endphp
                        </pre> --}}

                    </div>
                </div>
            </section>

        </main>
    </div>
</section>
