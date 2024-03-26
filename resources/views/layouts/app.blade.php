<!DOCTYPE html>
<html lang="{{ webSiteLang() }}">

<head>
    @include('common.metadata')
    <title>@yield('page_title', env('APP_NAME'))</title>
    @include('common.fonts')
    @stack('css')
    @include('common.css')
    @include('common.headScripts')

    @livewireStyles
</head>

<body class="overflow-x-hidden bg-[#070415]">

    @if (isAllowedRoute(getConstant('guestAllowedRoute')))
        @component('common.guestContentWrapper')
            @yield('content')
        @endcomponent
    @else
        @component('common.contentWrapper')
            @yield('content')
            @include('common.scrollToTop')
        @endcomponent

        @include('app_footer.footer')

        @if (isAllowedRoute(['dashboard']))
            @livewire('components.additional-equipment-modal', key(uniqid()))
            @livewire('components.additional-service-modal', key(uniqid()))
            @livewire('components.car-specifications-modal', key(uniqid()))
        @endif
    @endif

    @include('common.bodyScripts')

    @livewireScripts

    @stack('js')

</body>

</html>
