<!--Guest Content Wrapper-->
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <div>
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/img/png/black-logo.png') }}" alt="starent-logo" width="200px"
                height="60px">
        </a>
    </div>

    <div
        class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>