<div class="flex flex-col px-1 py-1 overflow-auto">
    @foreach ($cardData ?? [] as $key => $value)
        <button class="flex items-center h-5 px-1 text-xs hover:bg-gray-200"
            wire:click="$emit('modalEditSelectedDates', {{ json_encode(array_merge($value, ['timeIntervals' => $timeIntervals[$date]])) }})">
            @if ($value['firstSelectedCard'] === $value['lastSelectedCard'])
                <span class="font-medium leading-none truncate flex justify-between items-center w-full">
                    <span
                        class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full {{ $value['type'] === 'start' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                        <span
                            class="w-2 h-2 me-1 rounded-full {{ $value['type'] === 'start' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ strtoupper($value['type']) . ' - ' . $value['pickup_time'] }}
                    </span>
                    <span
                        class="font-bold">{{ is_array($value['userName']) ? 'WRONG-VALUE' : $value['userName'] }}</span>
                    <span
                        class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                        <span class="w-2 h-2 me-1 rounded-full bg-red-500"></span>
                        {{ 'END' . ' - ' . $value['return_time'] }}
                    </span>
                </span>
            @else
                <span class="font-medium leading-none truncate flex justify-between items-center w-full">
                    @if ($value['type'] !== 'between')
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full {{ $value['type'] === 'start' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                            <span
                                class="w-2 h-2 me-1 rounded-full {{ $value['type'] === 'start' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ strtoupper($value['type']) . ' - ' . $key }}
                        </span>
                    @endif
                    <span
                        class="font-bold">{{ is_array($value['userName']) ? 'WRONG-VALUE' : $value['userName'] }}</span>
                    @if ($value['firstSelectedCard'] === $value['lastSelectedCard'])
                        <span
                            class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                            <span class="w-2 h-2 me-1 rounded-full bg-red-500"></span>
                            {{ 'END' . ' - ' . $key }}
                        </span>
                    @endif
                </span>
            @endif

        </button>
    @endforeach
</div>
