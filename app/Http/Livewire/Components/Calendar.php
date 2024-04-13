<?php

namespace App\Http\Livewire\Components;

use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\CheckoutOrder;
use App\Models\CarSpecification;
use Illuminate\Contracts\View\View;

class Calendar extends Component
{

    private $allUserNames = [];

    public $prevMonth_str = null;
    public $currentYearAndMonth = null;
    public $nextMonth_str = null;

    public $pretPerioada = 0;
    public $currentDay_int = 0;
    public $numberOfRows_int = 0;

    public $nameOfDaysOfWeek_arr = [];
    public $daysBetweenTwoDates_arr = [];
    public $selectedCar = ''; // a nu se sterge, este cea de la select2
    public $selectedData = [];
    public $series = [];
    public $timeIntervals = [];

    public $showSelectBtn = [];
    public $availableDatesToSelectInterval = [];
    public $isOverlapInterval = false;

    public $selectedDaysArr = [];

    public $cardData = [];

    private $carIds = [];

    private $carsData = [];

    public $selectedCarNumber = '';
    public $selectedCarData = [];

    private $selectCarSpecification = ['id', 'nume', 'nr_inmatriculare', 'garantie', 'pret'];
    private $selectCheckoutOrder = [
        'user_id',
        'order_id',
        'pick_up_dateTime',
        'return_dateTime',
        'nr_of_days',
        'price_per_day',
        'price',
        'location',
        'additional_driver',
        'additional_driver_name',
        'aditional_equipment_ids',
        'aditional_services_ids',
    ];
    public $carSelected = false;

    // Card data
    public $firstSelectedCard = null;
    public $lastSelectedCard = null;
    public $selectedCards = [];
    public $selectionData = [];

    public $calendarIntervals = [];

    public function boot()
    {
        $this->handleUsers();
        $this->handleCarData();
        $this->handleCalendarData();
    }

    protected $listeners = [
        'newCalendarDate',
        'updatedSelectedCar',
    ];

    private function handleUsers()
    {
        $this->allUserNames = User::where('is_admin', 0)->pluck('name', 'id');
    }

    private function handleCarData()
    {
        $carsData = CarSpecification::select($this->selectCarSpecification)->get()->toArray();

        $arr1 = [];
        $arr2 = [];
        $arr3 = [];

        foreach ($carsData ?? [] as $key => $value) {
            $arr1[$value['nr_inmatriculare']] = $value['nr_inmatriculare'] . ': ' . $value['nume'];
            $arr2[$value['nr_inmatriculare']] = $value['id'];
            $arr3[$value['nr_inmatriculare']] = $value;
            $arr3[$value['nr_inmatriculare']]['pret'] = json_decode($value['pret'], true);
        }

        $this->series = $arr1;
        $this->carIds = $arr2;
        $this->carsData = $arr3;
    }

    private function handleCalendarData()
    {
        $calendarPersistenceDate = currentYearMonthAndDay();

        if (isset($calendarPersistenceDate)) {
            $this->currentYearAndMonth = $calendarPersistenceDate;
        } else {
            $this->currentYearAndMonth = currentYearMonthAndDay();
        }

        $this->prevMonth_str = prevMonth($this->currentYearAndMonth);
        $this->nextMonth_str = nextMonth($this->currentYearAndMonth);
        $this->nameOfDaysOfWeek_arr = nameOfDaysWeek();
        $this->daysBetweenTwoDates_arr = specificMonthDays($this->currentYearAndMonth);
        $this->currentDay_int = $this->flipArrayObtainKey($this->nameOfDaysOfWeek_arr, specificDayNameLongFormat(specificStartDateOfMonth($this->currentYearAndMonth)));
        $this->numberOfRows_int = $this->correctNumberOfRows();
    }

    private function generateHourlyIntervals(string $pick, string $return)
    {
        $pickDateTime = Carbon::parse($pick);
        $returnDateTime = Carbon::parse($return);

        $startDate = firstDayOTheMonth($this->currentYearAndMonth);
        $endDate = firstDayOTheMonth($this->nextMonth_str);

        $interval = new DateInterval('PT1H'); // Interval de 1 oră

        $hours = [];
        while ($pickDateTime <= $returnDateTime && $pickDateTime <= $endDate) {
            if ($pickDateTime >= $startDate) {
                $hours[] = $pickDateTime->format('Y-m-d H:i');
            }
            $pickDateTime->add($interval);
        }

        return $hours;
    }

    function countEntriesByDay(array $entries): array
    {
        $counts = [];

        foreach ($entries as $entry) {
            $date = substr($entry, 0, 10); // Extrage doar partea de dată (YYYY-MM-DD)
            if (!isset($counts[$date])) {
                $counts[$date] = 1;
            } else {
                $counts[$date]++;
            }
        }

        return $counts;
    }

    public function updatedSelectedCar(string $prop, $resetSelectedDates = false)
    {
        if (!$prop) {
            $this->reset([
                'carSelected',
                'cardData',
                'selectedData',
                'selectedCards',
                'availableDatesToSelectInterval',
            ]);
            return;
        }

        if ($resetSelectedDates) {
            $this->reset([
                'selectionData',
                'firstSelectedCard',
                'lastSelectedCard',
                'selectedData',
                'selectedCards',
                'availableDatesToSelectInterval',
            ]);
        }

        $this->carSelected = true;
        $this->selectedCarNumber = $prop;
        $this->selectedCarData = $this->carsData[$prop];
        
        $checkoutOrderData = CheckoutOrder::where('car_id', $this->carIds[$prop])->select($this->selectCheckoutOrder)->get()->toArray();

        [
            'nume' => $car_name,
            'nr_inmatriculare' => $nr_inmatriculare,
            'garantie' => $garantie,
        ] = $this->carsData[$prop];

        $arr = [];
        $arrDates = [];
        $timeIntervals = [];
      
        foreach ($checkoutOrderData ?? [] as $index => $value) {
            $firstAndLastDate = getFirstAndLastDate($value['pick_up_dateTime'], $value['return_dateTime']);

            $pick_up_date = specificYearMonthAndDay($firstAndLastDate['first']);
            $pick_up_time = specificHourAndMinute($firstAndLastDate['first']);
            $return_date = specificYearMonthAndDay($firstAndLastDate['last']);
            $return_time = specificHourAndMinute($firstAndLastDate['last']);

            $arrDates[] = $this->countEntriesByDay($this->generateHourlyIntervals($firstAndLastDate['first'], $firstAndLastDate['last']));

            $arr[$index] = $value;
            $arr[$index]['userName'] = $this->allUserNames[$value['user_id']] ?? 'ADMIN'; // cand admin-ul creaza o comanda
            $arr[$index]['car_name'] = $car_name;
            $arr[$index]['nr_inmatriculare'] = $nr_inmatriculare;
            $arr[$index]['garantie'] = $garantie;
            $arr[$index]['pickup_time'] = $pick_up_time;
            $arr[$index]['return_time'] = $return_time;
            $arr[$index]['firstSelectedCard'] = $pick_up_date;
            $arr[$index]['lastSelectedCard'] = $return_date;

            foreach ($arrDates[$index] as $key => $numberOfHours) {
                $enrichArr = array_merge($arr[$index], ['numberOfHours' => $numberOfHours, 'totalHours' => hours_difference($firstAndLastDate['first'], $firstAndLastDate['last'])]);
                switch ($key) {
                    case $pick_up_date:
                        $arrDates[$index][$key] = [$pick_up_time => array_merge($enrichArr, ['type' => 'start'])];
                        break;

                    case $return_date:
                        $arrDates[$index][$key] = [$return_time => array_merge($enrichArr, ['type' => 'end'])];
                        break;

                    default:
                        $arrDates[$index][$key] = ['24:00' => array_merge($enrichArr, ['type' => 'between'])];
                        break;
                }

                $today = Carbon::parse($key);

                $pick_up_time_interval = $pick_up_time;
                $return_time_interval = $return_time;

                if (Carbon::parse(specificYearMonthAndDay($firstAndLastDate['first']))->lt($today)) {
                    $pick_up_time_interval = '00:00';
                }

                if (Carbon::parse(specificYearMonthAndDay($firstAndLastDate['last']))->gt($today)) {
                    $return_time_interval = '23:59';
                }

                $timeIntervals[$key][$pick_up_time_interval] = ['start' => $pick_up_time_interval, 'end' => $return_time_interval];
            }
        }

        $customSort = function ($a, $b) {
            $timeA = strtotime($a);
            $timeB = strtotime($b);

            if ($timeA === false) {
                $timeA = strtotime('00:00');
            }
            if ($timeB === false) {
                $timeB = strtotime('00:00');
            }

            return $timeA - $timeB;
        };

        // Sortează fiecare submatrice
        foreach ($timeIntervals as $date => &$subarray) {
            uksort($subarray, $customSort); // Folosim uksort pentru a păstra cheile
        }

        $mergedArray = array_merge_recursive(...$arrDates);

        ksort($mergedArray);

        // Sortează fiecare submatrice
        foreach ($mergedArray as $date => &$subarray) {
            uksort($subarray, $customSort); // Folosim uksort pentru a păstra cheile
        }

        $this->timeIntervals = $timeIntervals;
        $this->cardData = $mergedArray;

        $this->handleShowSelectBtn(false, true);
    }

    public function renderMonth($month)
    {
        $firstDayOTheMonth = firstDayOTheMonth($month);

        $this->emit('getSelectedDays');

        $this->prevMonth_str = prevMonth($firstDayOTheMonth);
        $this->currentYearAndMonth = specificYearAndMonth($firstDayOTheMonth);
        $this->nextMonth_str = nextMonth($firstDayOTheMonth);
        $this->daysBetweenTwoDates_arr = daysBetween(specificStartDateOfMonth($firstDayOTheMonth), specificEndDateOfMonth($firstDayOTheMonth));
        $this->currentDay_int = $this->flipArrayObtainKey($this->nameOfDaysOfWeek_arr, specificDayNameLongFormat($firstDayOTheMonth));
        $this->numberOfRows_int = $this->correctNumberOfRows();

        if ($this->selectedCarNumber) {
            $this->updatedSelectedCar($this->selectedCarNumber);
        }

        $this->emit('newCurrentYearAndMonth', $this->currentYearAndMonth);
    }

    public function correctNumberOfRows()
    {
        if (
            ($this->currentDay_int < 5 && count($this->daysBetweenTwoDates_arr) === 31) ||
            ($this->currentDay_int === 0 && count($this->daysBetweenTwoDates_arr) >= 29) ||
            ($this->currentDay_int >= 1 && $this->currentDay_int <= 6 && count($this->daysBetweenTwoDates_arr) === 28) ||
            ($this->currentDay_int >= 1 && $this->currentDay_int <= 5 && count($this->daysBetweenTwoDates_arr) <= 30)
        ) {
            return 5;
        } elseif ($this->currentDay_int === 0 && count($this->daysBetweenTwoDates_arr) === 28) {
            return 4;
        } else {
            return 6;
        }
    }

    public function flipArrayObtainKey($arr, $key)
    {
        $flippedArray = array_flip($arr);
        return $flippedArray[$key];
    }

    public function newCalendarDate($data)
    {
        $this->renderMonth(firstDayOTheMonth($data));
    }

    private function findNeighbors(array $dates, string $targetDate)
    {
        sort($dates);

        $prevDate = null;
        $nextDate = null;

        foreach ($dates as $date) {
            if ($date < $targetDate) {
                $prevDate = Carbon::parse($date)->addDay()->toDateString();
            } elseif ($date > $targetDate) {
                $nextDate = Carbon::parse($date)->subDay()->toDateString();
                break;
            }
        }

        if ($prevDate === null) {
            $prevDate = firstDayOfCurrentMonth($this->currentYearAndMonth);
        }

        if ($nextDate === null) {
            $nextDate = lastDayOfCurrentMonth($this->currentYearAndMonth);
        }

        return ['firstDay' => $prevDate, 'lastDay' => $nextDate];
    }

    public function selectDate(string $date)
    {
        $this->reset(['isOverlapInterval']);
        
        if (in_array($date, $this->selectedCards)) {
            $key_to_unset = array_search($date, $this->selectedCards);
            unset($this->selectedCards[$key_to_unset]);
            if (count($this->selectedCards) === 0) {
                $this->reset(['pretPerioada']);
            }
        } else {
            $this->selectedCards[] = $date;
        }

        $this->handleDatesToSelectInterval($date);

        if (count($this->selectedCards) >= 2) {
            $selectedDatesInterval = getFirstAndLastDate(reset($this->selectedCards), end($this->selectedCards));
            $this->isOverlapInterval = CheckoutOrder::select('order_id')->where('car_id', $this->selectedCarData['id'])->where('pick_up_dateTime', '<=', $selectedDatesInterval['last'])->where('return_dateTime', '>=', $selectedDatesInterval['first'])->pluck('order_id')->first();
            if(!$this->isOverlapInterval) {
                $this->reset(['isOverlapInterval']);
            } else {
                $this->isOverlapInterval = true;
                $this->reset(['selectedCards', 'availableDatesToSelectInterval']);
                $this->handleShowSelectBtn(false, true);
            }
        }

        if (count($this->selectedCards)) {
            $this->firstSelectedCard = min_date($this->selectedCards);
            $this->lastSelectedCard = max_date($this->selectedCards);
            $this->selectedCards = daysBetween($this->firstSelectedCard, $this->lastSelectedCard)->toArray();

            $this->selectionData = getFirstAndLastDate($this->firstSelectedCard, $this->lastSelectedCard);

            $nrOfDays = count($this->selectedCards);

            $this->selectedData['firstSelectedCard'] = $this->firstSelectedCard;
            $this->selectedData['lastSelectedCard'] = $this->lastSelectedCard;
            $this->selectedData['nrOfDays'] = $nrOfDays;
            $this->selectedData['timeIntervals'] = $this->timeIntervals[$date] ?? [];

            $this->handlePricePeriod($nrOfDays);
        }
    }

    private function handleDatesToSelectInterval(string $date)
    {
        $availableDatesToSelect =  $this->findNeighbors(array_keys($this->cardData), $date);
        $this->availableDatesToSelectInterval = daysBetween($availableDatesToSelect['firstDay'], $availableDatesToSelect['lastDay'])->toArray();

        if (count($this->selectedCards)) {
            $this->handleShowSelectBtn(true, false);
        } else {
            $this->reset(['availableDatesToSelectInterval']);
            $this->handleShowSelectBtn(false, true);
        }
    }

    private function handleShowSelectBtn(bool $bool1, bool $bool2)
    {
        foreach ($this->daysBetweenTwoDates_arr ?? [] as $date) {
            if (count($this->availableDatesToSelectInterval)) {
                if (in_array($date, $this->availableDatesToSelectInterval)) {
                    $this->showSelectBtn[$date] = $bool1;
                    continue;
                }
            } else {
                if (in_array($date, array_keys($this->cardData))) {
                    $this->showSelectBtn[$date] = $bool1;
                    continue;
                }
            }
            $this->showSelectBtn[$date] = $bool2;
        }
    }

    private function handlePricePeriod(int $nrOfDays)
    {
        if ($this->carsData && $this->selectedCarNumber) {
            foreach ($this->carsData[$this->selectedCarNumber]['pret'] ?? [] as $zile => $pret) {
                if ($nrOfDays >= $zile) {
                    $this->carsData[$this->selectedCarNumber]['pretZi'] = $pret;
                    if ($nrOfDays === 0) {
                        $this->pretPerioada = (float) $pret;
                    } else {
                        $this->pretPerioada = (float) $pret * $nrOfDays;
                    }
                }
            }
            $this->carsData[$this->selectedCarNumber]['pret'] = $this->pretPerioada;
            $this->selectedData['selectedCarData'] = $this->carsData[$this->selectedCarNumber];
        }
    }

    public function removeSelectedDates()
    {
        $this->reset(['selectedCards', 'pretPerioada', 'availableDatesToSelectInterval', 'isOverlapInterval']);
        $this->handleShowSelectBtn(false, true);
    }

    public function render(): View
    {
        return view('livewire.components.calendar');
    }
}
