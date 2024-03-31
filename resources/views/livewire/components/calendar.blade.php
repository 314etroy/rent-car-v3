<div class="text-gray-700">

    <!-- Component Start -->
    <div class="flex flex-grow w-screen h-screen overflow-auto">

        <div class="flex flex-col flex-grow">

            <div class="flex items-center justify-between mt-4 pl-4 pr-8">
                <div>
                    <div wire:ignore>
                        <select class="form-control" id="select2">
                            <option value="">Selectează autovehicul</option>
                            @foreach ($series as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="mr-6 mt-2">
                        <button type="button" aria-label="prev_month" wire:click="renderMonth('{{ $prevMonth_str }}')">
                            @include('svg.arrow_left_calendar')
                        </button>
                        <button type="button" aria-label="next_month" wire:click="renderMonth('{{ $nextMonth_str }}')">
                            @include('svg.arrow_right_calendar')
                        </button>
                    </div>
                    @livewire('common.month-calendar', ['currentYearAndMonth' => $currentYearAndMonth])
                </div>
            </div>

            <div class="grid grid-cols-7 mt-4">
                @if (isset($nameOfDaysOfWeek_arr))
                    @forelse ($nameOfDaysOfWeek_arr as $name)
                        <div class="pl-1 text-sm text-center">{{ $name }}</div>
                    @empty
                        Nu sunt declarate zilele saptamanii
                    @endforelse
                @else
                    Array-ul ce contine zilele saptamanii nu exista.
                @endif
            </div>
            <div
                class="grid flex-grow w-full h-auto grid-cols-7 grid-rows-{{ $numberOfRows_int }} gap-px pt-px mt-1 bg-gray-200">

                @if (isset($currentDay_int))
                    @for ($i = 0; $i < $currentDay_int; $i++)
                        <div></div>
                    @endfor
                @else
                    Array-ul pe baza caruia se randeaza spatiul pana la primul card nu exista.
                @endif

                @if (isset($daysBetweenTwoDates_arr))
                    @forelse ($daysBetweenTwoDates_arr as $date)
                        {{-- Aici se pun datele din card-uri --}}
                        @livewire(
                            'common.calendar-card',
                            [
                                'currentSelectedDays' => $currentSelectedDays,
                                'date' => $date,
                                'day' => specificDay($date),
                                'monthName' => specificMonthNameLongFormat($currentYearAndMonth),
                            ],
                            key(time() . $date)
                        )
                    @empty
                        Array-ul cu datele utilizate pentru randarea card-urilor este gol.
                    @endforelse
                @else
                    Array-ul pe baza caruia se randeaza card-urile nu exista.
                @endif

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
