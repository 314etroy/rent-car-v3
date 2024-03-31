<div
    class="relative flex flex-col group @if ($date === currentYearMonthAndDay()) bg-stone-200 @else bg-white @endif @if ($isDaySelected || in_array($date, $currentSelectedDays)) bg-teal-100 @endif">
    <span class="mx-2 my-1 text-xs font-bold">{{ $day }} {{ $monthName }}</span>
    <button type="button" wire:click="isSelected('{{ $date }}')" wire:ignore
        class="absolute top-0 right-0 flex items-center justify-center hidden w-6 h-6 mt-1 mr-2 text-white bg-green-400 rounded group-hover:flex hover:bg-green-500">
        @include('svg.plus-select-day')
    </button>
    <div class="flex flex-col px-1 py-1 overflow-auto">
        <button class="flex items-center flex-shrink-0 h-5 px-1 text-xs hover:bg-gray-200"
            wire:click="$emit('modalTaskData', {{ json_encode(['day' => $day, 'monthName' => $monthName, 'time' => '8:30am', 'task_data' => 'An unconfirmed event']) }})">
            <span class="flex-shrink-0 w-2 h-2 border border-gray-500 rounded-full"></span>
            <span class="ml-2 font-light leading-none">8:30</span>
            <span class="ml-2 font-medium leading-none truncate">An unconfirmed event</span>
        </button>
        <button class="flex items-center flex-shrink-0 h-5 px-1 text-xs hover:bg-gray-200"
            wire:click="$emit('modalTaskData', {{ json_encode(['day' => $day, 'monthName' => $monthName, 'time' => '2:15pm', 'task_data' => 'A confirmed event']) }})">
            <span class="flex-shrink-0 w-2 h-2 bg-gray-500 rounded-full"></span>
            <span class="ml-2 font-light leading-none">2:15</span>
            <span class="ml-2 font-medium leading-none truncate">A confirmed event</span>
        </button>
    </div>
    <button type="button"
        wire:click="$emit('modalFormType', {{ json_encode(['day' => $day, 'monthName' => $monthName]) }})"
        class="absolute bottom-0 right-0 flex items-center justify-center hidden w-6 h-6 mb-2 mr-2 text-white bg-gray-400 rounded group-hover:flex hover:bg-gray-500">
        @include('svg.plus-open-calendar-modal')
    </button>
</div>
