<div class="text-gray-700">

    <!-- Component Start -->
    <div class="flex flex-grow h-screen overflow-auto">

        <div class="flex flex-col flex-grow">

            <div class="flex items-center justify-between mt-4 pl-4 mr-2">
                <div wire:ignore>
                    <select class="form-control" id="select2">
                        <option value="">Selectează autovehicul</option>
                        @foreach ($series ?? [] as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($isOverlapInterval)
                    <div>
                        <span class="bg-red-500 text-white font-bold">Intervalul selectat se suprapune peste o comandă
                            existentă.</span>
                    </div>
                @endif
                <div class="flex items-center">
                    <div class="mr-6 mt-2">
                        <button type="button" aria-label="prev_month" wire:click="renderMonth('{{ $prevMonth_str }}')">
                            @include('svg.arrow_left_calendar')
                        </button>
                        <button type="button" aria-label="next_month" wire:click="renderMonth('{{ $nextMonth_str }}')">
                            @include('svg.arrow_right_calendar')
                        </button>
                    </div>
                    @livewire('common.month-calendar', ['currentYearAndMonth' => $currentYearAndMonth], key(uniqid()))
                    <button type="button" aria-label="next_month" wire:click="renderMonth('{{ head($daysBetweenTwoDates_arr->toArray()) }}')"
                        class="text-white bg-green-700 font-medium text-sm px-5 py-2.5 border-y-[1px] border-y-green-700 ml-2">
                        Refresh
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-7 mt-4">
                @forelse ($nameOfDaysOfWeek_arr ?? [] as $name)
                    <div class="pl-1 text-sm text-center">{{ $name }}</div>
                @empty
                    Nu sunt declarate zilele saptamanii
                @endforelse
            </div>

            <div
                class="grid flex-grow w-full h-auto grid-cols-7 grid-rows-{{ $numberOfRows_int }} gap-px pt-px mt-1 bg-gray-200">

                @for ($i = 0; $i < $currentDay_int; $i++)
                    <div></div>
                @endfor

                @forelse ($daysBetweenTwoDates_arr ?? [] as $date)
                    @php
                        $css = 'bg-white';

                        if ($date === currentYearMonthAndDay()) {
                            $css = 'bg-stone-200';
                        }

                        foreach ($cardData[$date] ?? [] as $key => $value) {
                            $css = 'bg-red-500';
                        }

                        if (in_array($date, $selectedCards)) {
                            $css = 'bg-teal-100';
                        }

                        if ($date < currentYearMonthAndDay()) {
                            $css .= ' cursor-not-allowed';
                        }
                    @endphp
                    {{-- Aici se pun datele din card-uri --}}
                    <div class="h-full relative flex flex-col group {{ $css }}">
                        <span class="mx-2 my-1 text-xs font-bold">{{ specificDay($date) }}
                            {{ specificMonthNameLongFormat($date) }}</span>

                        @if ($carSelected && $date >= currentYearMonthAndDay())
                            {{-- carSelected tine de dropdown-ul de sus --}}
                            @if (!in_array($date, $selectedCards))
                                @if ($showSelectBtn[$date] && !isset($cardData[$date]))
                                    <button type="button" wire:click="selectDate(`{{ $date }}`)"
                                        class="absolute top-0 right-0 hidden items-center justify-center w-6 h-6 mt-1 mr-2 text-white bg-green-400 rounded group-hover:flex hover:bg-green-500">
                                        @include('svg.plus-select-day')
                                    </button>
                                @endif
                            @else
                                @if ($date === $firstSelectedCard || $date === $lastSelectedCard)
                                    <button type="button" wire:click="selectDate(`{{ $date }}`)"
                                        class="absolute top-0 right-0 hidden items-center justify-center w-6 h-6 mt-1 mr-2 text-white bg-red-400 rounded group-hover:flex hover:bg-red-500">
                                        @include('svg.minus-icon')
                                    </button>
                                @else
                                    <button type="button" wire:click="removeSelectedDates()"
                                        class="absolute top-0 right-0 hidden items-center justify-center w-6 h-6 mt-1 mr-2 text-white bg-yellow-400 rounded group-hover:flex hover:bg-yellow-500">
                                        @include('svg.minus-icon')
                                    </button>
                                @endif
                            @endif


                            @if (count($this->selectedCards) && isInsideOfInterval($this->selectedCards, $date))
                                <button type="button"
                                    wire:click="$emit('modalSelectedDates', {{ json_encode([
                                        'selectedData' => $selectedData,
                                    ]) }})"
                                    class="absolute bottom-0 right-0 flex items-center justify-center hidden w-6 h-6 mb-2 mr-2 text-white bg-gray-400 rounded group-hover:flex hover:bg-gray-500">
                                    @include('svg.plus-open-calendar-modal')
                                </button>
                            @endif
                        @endif

                        @isset($cardData[$date])
                            @livewire(
                                'common.calendar-card',
                                [
                                    'date' => $date,
                                    'cardData' => $cardData[$date],
                                    'timeIntervals' => $timeIntervals,
                                ],
                                key(uniqid())
                            )
                        @endisset

                    </div>
                @empty
                    Array-ul cu datele utilizate pentru randarea card-urilor este gol.
                @endforelse
            </div>
        </div>
    </div>
    <!-- Component End  -->

</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('#select2').select2();
            $('#select2').on('change', function(e) {
                var data = $('#select2').select2("val");
                @this.set('selectedCar', data);
            });
        });
    </script>
@endpush
