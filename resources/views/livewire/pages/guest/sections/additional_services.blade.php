{{-- Section 3 --}}
<section class="mt-4">
    <div class="bg-white max-w-7xl mx-auto px-4">
        <div data-aos="fade-up" data-aos-duration="500">
            <div
                class="transition-all duration-300 pointer-events-auto hover:shadow-[0_0_1.5rem_0_rgba(0,0,0,.12)] hover:-translate-y-1">
                <div class="border border-blue-300 bg-blue-500 rounded w-full h-full text-center p-5">
                    <h1 class="text-1xl/tight font-strong mt-3">
                        Garantie {{ ucfirst($selectedCar['name']) }}
                    </h1>
                    <h1 class="text-3xl/tight font-semibold mt-3">
                        + {{ $pretGarantie }} Lei
                    </h1>
                </div>
            </div>
        </div>
        <div class="py-5">
            <div class="container relative w-full">

                @if ($additionalEquipmentData)
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 pt-8">
                            {{ __('translations.additional_services_equipment') }}</h1>
                    </div>

                    <div class="grid xl:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-7 mt-14 w-full">

                        @foreach ($additionalEquipmentData ?? [] as $value)
                            <div data-aos="fade-up" data-aos-duration="500"
                                wire:click='choseAdditionalEquipment("{{ $value['code'] }}")'>
                                <div
                                    class="transition-all duration-300 pointer-events-auto hover:shadow-[0_0_1.5rem_0_rgba(0,0,0,.12)] hover:-translate-y-1">
                                    <div
                                        class="border {{ $value['isSelected'] ? 'border-blue-300 bg-blue-500' : 'border-gray-300 bg-white' }} rounded w-full h-full text-center p-5">
                                        <span class="text-lg text-primary">{{ $value['nume'] }}</span>
                                        <h1 class="text-1xl/tight font-strong mt-3">
                                            {{ $value['descriere'] }}
                                        </h1>
                                        <h1 class="text-3xl/tight font-semibold mt-3">
                                            {{ $value['pret'] === 0 ? 'Fără costuri adiționale' : '+ ' . $value['pret'] . '  Lei' }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                @endif

                @foreach ($additionalServicesData ?? [] as $value)
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 pt-14">
                            {{ $value['nume'] }}
                        </h1>
                    </div>

                    <div class="grid xl:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-7 mt-14 w-full">

                        @foreach ($value['services'] ?? [] as $service)
                            <div data-aos="fade-up" data-aos-duration="500"
                                wire:click='choseAdditionalServices("{{ $value['row_code'] }}", "{{ $service['code'] }}")'>
                                <div
                                    class="transition-all duration-300 pointer-events-auto hover:shadow-[0_0_1.5rem_0_rgba(0,0,0,.12)] hover:-translate-y-1">
                                    <div
                                        class="border {{ $service['isSelected'] ? 'border-blue-300 bg-blue-500' : 'border-gray-300 bg-white' }} rounded w-full h-full text-center p-5">
                                        <span class="text-lg text-primary">{{ $service['comment'] }}</span>
                                        <h1 class="text-1xl/tight font-strong mt-3">
                                            {{ $service['descriere'] }}
                                        </h1>
                                        <h1 class="text-3xl/tight font-semibold mt-3">
                                            {{ $service['pret'] === 0 ? 'Fără costuri adiționale' : '+ ' . $service['pret'] . '  Lei' }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endforeach

                @if ($serviceIsSelected)
                    @include('common.generic-btn', [
                        'btn_content' => 'Finalizeaza comanda',
                        'wire_method' => 'changeSection("3")',
                        'onclick' => 'goTop()',
                        'class' =>
                            'w-full mt-14 mb-8 p-2 rounded-md ' . getConstant('modal_generic_colors')['purple'],
                    ])
                @endif

                {{-- <pre>
                    @php
                        print_r($buyOptions);
                    @endphp
                </pre>

                <pre>
                    @php
                        print_r($additionalEquipmentData);
                    @endphp
                </pre> --}}

            </div>
        </div>
    </div>
</section>
