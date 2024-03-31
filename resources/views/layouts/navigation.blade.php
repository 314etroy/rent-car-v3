@props([
    'guest_links' => [
        [
            'route_name' => 'reserve_now',
            'route_translation' => __('translations.home_menu'),
        ],
        [
            'route_name' => 'about_us',
            'route_translation' => __('translations.about_us_menu'),
        ],
        [
            'route_name' => 'faqs',
            'route_translation' => __('translations.faqs_menu'),
        ],
        [
            'route_name' => 'contact',
            'route_translation' => __('translations.contact_menu'),
        ],
    ],
])

<header class="bg-[#1d1a29] bx-dark bx-static">
    <nav x-data="{ open: false }" class="bg-[#1d1a29] dark:bg-gray-800 fixed top-0 left-0 w-full z-50">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/png/white-logo.png') }}" alt="starent-logo" width="100px"
                                height="60px">
                        </a>
                    </div>

                    @auth
                        <!-- Admin Navigation Links -->
                        @foreach ($guest_links ?? [] as $value)
                            <div class="hidden space-x-8 md:-my-px md:ms-3 md:flex">
                                <x-nav-link :href="route($value['route_name'])" :active="request()->routeIs($value['route_name'])">
                                    {{ $value['route_translation'] }}
                                </x-nav-link>
                            </div>
                        @endforeach

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('translations.dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('reserve_a_car')" :active="request()->routeIs('reserve_a_car')">
                                {{ __('translations.reserveACar') }}
                            </x-nav-link>
                        </div>
                    @else
                        <!-- Navigation Links -->
                        @foreach ($guest_links ?? [] as $value)
                            <div class="hidden space-x-8 md:-my-px md:ms-3 md:flex">
                                <x-nav-link :href="route($value['route_name'])" :active="request()->routeIs($value['route_name'])">
                                    {{ $value['route_translation'] }}
                                </x-nav-link>
                            </div>
                        @endforeach
                    @endauth
                </div>

                @auth
                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">

                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        @include('svg.dropdown-down-arrow')
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('translations.profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('translations.logout') }}
                                    </x-dropdown-link>

                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden md:flex special-cta">
                        <x-nav-link :href="route('login')">
                            {{ __('translations.check_booking') }}
                        </x-nav-link>
                    </div>
                @endauth

                <!-- Hamburger -->
                <div class="-me-2 flex items-center @auth sm:hidden @else md:hidden @endauth">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        @include('svg.hamburger')
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden @auth sm:hidden @else md:hidden @endauth">

            @auth
                <!-- Responsive Navigation Links -->
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('translations.dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reserve_a_car')" :active="request()->routeIs('reserve_a_car')">
                    {{ __('translations.reserveACar') }}
                </x-responsive-nav-link>
            @else
                <!-- Responsive Navigation Links -->
                @foreach ($guest_links ?? [] as $value)
                    <x-responsive-nav-link :href="route($value['route_name'])">
                        {{ $value['route_translation'] }}
                    </x-responsive-nav-link>
                @endforeach

                <x-responsive-nav-link :href="route('login')">
                    {{ __('translations.check_booking') }}
                </x-responsive-nav-link>
            @endauth

            @auth
                <!-- Responsive Settings Options -->
                <div class="pt-2 pb-3 ">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('translations.profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('translations.logout') }}
                        </x-responsive-nav-link>

                    </form>
                </div>
            @endauth
        </div>
    </nav>
</header>
