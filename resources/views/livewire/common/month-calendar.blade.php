<div>

    <div class="flex items-center">
        <input type="text" id="selectDate" class="w-36" type="button" wire:click="showDropdown"
            wire:model="currentYearAndMonth" readonly aria-label="select_month">

        @if ($currentYearAndMonth === currentYearAndLongFormatMonth())
            <label for="selectDate"
                class="text-white bg-blue-700 font-medium text-sm px-5 py-2.5 border-y-[1px] border-y-blue-700">
                {{ __('translations.current_date') }}
            </label>
        @else
            <button type="button" wire:click="resetDateToCurrentDate"
                class="text-black bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-600 font-medium text-sm px-5 py-2.5 border-y-[1px] border-y-amber-500">
                {{ __('translations.reset_date') }}
            </button>
        @endif
    </div>

    <!-- Dropdown menu -->
    @if ($showComponent)

        {{-- wire:mouseover="showDropdown" --}}
        {{-- wire:mouseout="$emit('hideComp')" --}}

        <div wire:clickaway="hideComp"
            class="z-40 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 block"
            style="position: absolute; top: 115px;">

            <div class="px-2 py-2 flex">

                <button type="button" aria-label="prev_year" class="m-l-1"
                    wire:click="renderYear('{{ $prevYear_str }}')">
                    @include('svg.arrow_left_calendar')
                </button>

                <input type="text" wire:model.lazy="currentYear" class="w-16 mx-10" minlength="4" maxlength="4"
                    required>

                <button type="button" aria-label="next_year" wire:click="renderYear('{{ $nextYear_str }}')">
                    @include('svg.arrow_right_calendar')
                </button>

            </div>

            <div class="py-2 justify-items-center">
                @if (isset($allMonthsInYear))
                    <div class="grid grid-cols-4 ">
                        @foreach ($allMonthsInYear as $key => $month)
                            <div wire:click='selectedMonth("{{ $key + 1 }}")'
                                class="text-center hover:bg-gray-400 p-1 mx-1 border hover:border-indigo-600 border-transparent cursor-pointer @if (isset($selectedMonth) && $selectedMonth === $key + 1) bg-gray-400 @endif">
                                {{ $month }}</div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">Check months logic.</p>
                @endif
            </div>

        </div>
    @endif

</div>
