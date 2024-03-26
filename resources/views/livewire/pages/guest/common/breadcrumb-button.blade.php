@props([
    'noActiveCss' =>
        'ms-1 text-sm font-medium text-gray-500 hover:text-black md:ms-2 dark:text-gray-400 dark:hover:text-white cursor-not-allowed',
    'activeCss' =>
        'inline-flex items-center text-sm font-medium hover:text-gray-900 dark:text-gray-400 dark:hover:text-white rounded-full bg-[#7963e0] px-2 py-0.5 text-white',
])

<li>
    <div class="flex items-center">
        @if ($sectionNumber !== 0)
            @include('svg.breadcrumb-right-arrow')
        @endif
        <button {{ $isActive && $sectionNumber < 3 ? 'wire:click=changeSection(' . $sectionNumber . ')' : null }}
            class="{{ $isActive ? $activeCss : $noActiveCss }}">{{ __('translations.' . $content) }}</button>
    </div>
</li>
