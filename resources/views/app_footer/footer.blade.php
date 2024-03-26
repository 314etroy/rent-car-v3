@php
    $common_links = [
        'anpc' => 'https://anpc.ro/ce-este-sal/',
        'netopia' => 'https://netopia-payments.com/',
        'solvit' => 'https://ec.europa.eu/consumers/odr/main/index.cfm?event=main.home2.show&lng=RO',
];
@endphp

@props([

    'guest_footer_utils_links' => [
        [
            'route_name' => 'terms_and_conditions',
            'route_translation' => __('translations.terms_and_conditions_menu'),
        ],
        // [
        //     'route_name' => 'return_policy',
        //     'route_translation' => __('translations.return_policy_menu'),
        // ],
        [
            'route_name' => 'cancellation_policy',
            'route_translation' => __('translations.cancellation_policy_menu'),
        ],
        [
            'route_name' => 'gdpr',
            'route_translation' => __('translations.gdpr_menu'),
        ],
        [
            'route_name' => 'anpc',
            'link' => $common_links['anpc'],
            'route_translation' => __('translations.anpc_menu'),
        ],
        [
            'route_name' => 'solvit',
            'link' => $common_links['solvit'],
            'route_translation' => __('translations.solvit_menu'),
        ],
    ],
    'guest_footer_services_links' => [
        [
            'route_name' => 'cars',
            'route_translation' => __('translations.cars_menu'),
        ],
        [
            'route_name' => 'airport_transfer',
            'route_translation' => __('translations.airport_transfer_menu'),
        ],
        [
            'route_name' => 'about_us',
            'route_translation' => __('translations.about_us_menu'),
        ],
        [
            'route_name' => 'car_fleet',
            'route_translation' => __('translations.car_fleet_menu'),
        ],
    ],
])

<footer class="bg-[#070415] mb-10">
    {{-- <div class="container px-6 py-12 mx-auto"> --}}
    <div class="max-w-7xl mx-auto ">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
            <div class="flex flex-col ">
                <p class="text-[20px] text-[#ddd] pt-6 font-bold">StaRent Inchirieri Auto Campulung</p>
                <div class="flex flex-col  mt-5 space-y-2 text-white">
                    <ul>
                        <li>Municipiul Câmpulung, Strada G-RAL GRIGORE GRECESCU, Nr. 9, Bloc D17, Scara A, Etaj 1, Ap. 7, Judet Argeş</li>
                        <li><a href="tel:0722222222">0722-222-222</a></li>
                        <li><a href="mailto:contact@starentinchirieriauto.ro">contact@starentinchirieriauto.ro</a></li>
                    </ul>
                    <u>Harta Sediu Campulung:</u>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d89876.85852940445!2d24.988596499804682!3d45.25483289432369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b329b90719bcb7%3A0xd4d45c5e5ba46dad!2sC%C3%A2mpulung!5e0!3m2!1sro!2sro!4v1708299022213!5m2!1sro!2sro"
                        width="100%" style="border:0;" allowfullscreen="" loading="async"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="flex flex-col items-center">
                <p class="text-[20px] text-[#ddd] pt-6 font-bold">Linkuri utile</p>
                <div class="flex flex-col justify-center items-center mt-5 space-y-2">
                    @foreach ($guest_footer_utils_links ?? [] as $value)
                        <a href={{ $value['route_name'] !== 'anpc' && $value['route_name'] !== 'solvit' ? route($value['route_name']) : $value['link'] }}
                            class="text-white">
                            {{ $value['route_translation'] }}
                        </a>
                    @endforeach
                    <div>
                        <a href="{{ $common_links['solvit'] }}">
                            <img src="{{ asset('assets/img/png/sol.png') }}" alt="Solvit" width="200px" height="20px">
                        </a>
                    </div>
                    <div>
                        <a href="{{ $common_links['anpc'] }}">
                            <img src="{{ asset('assets/img/png/anpc.png') }}" alt="Anpc" width="200px" height="20px">
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center">
                <p class="text-[20px] text-[#ddd] pt-6 font-bold">Servicii</p>
                <div class="flex flex-col mt-5 space-y-2 text-white items-center">
                    @foreach ($guest_footer_services_links ?? [] as $value)
                        <a href={{ route($value['route_name']) }} class=" text-white">
                            {{ $value['route_translation'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col items-center">
                <p class="text-[20px] text-[#ddd] pt-6 font-bold">Program de lucru</p>

                <div class="flex flex-col mt-5 space-y-2 text-white ">
                    <ul>
                        <li>Luni - Vineri: 08:00 la 17:00</li>
                        <li>Sambata: 08:00 - 14:00</li>
                        <li>Duminica: <b class="text-red-700">inchis</b></li>
                    </ul>
                </div>

                <div class="mt-10">
                    <a href="{{ $common_links['netopia'] }}">
                        <img src="{{ asset('assets/img/png/netopia.png') }}" alt="Netopia" width="200px" height="20px">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
