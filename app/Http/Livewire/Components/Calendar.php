<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\CheckoutOrder;
use App\Models\CarSpecification;

class Calendar extends Component
{

    public $prevMonth_str = null;
    public $currentYearAndMonth = null;
    public $nextMonth_str = null;
    public $currentDay_int = 0;
    public $numberOfRows_int = 0;
    public $nameOfDaysOfWeek_arr = [];
    public $daysBetweenTwoDates_arr = [];
    public $currentSelectedDays = [];
    public $selectedCar = '';
    public $series = [
        'Wanda Vision',
        'Money Heist',
        'Lucifer',
        'Stranger Things',
    ];

    private $carIds = [];

    public function boot()
    {
        $carsData = CarSpecification::select('id', 'nume', 'nr_inmatriculare')->get()->toArray();

        $arr1 = [];
        $arr2 = [];
        foreach ($carsData as $key => $value) {
            $arr1[$value['nr_inmatriculare']] = $value['nr_inmatriculare'] . ': ' . $value['nume'];
            $arr2[$value['nr_inmatriculare']] = $value['id'];
        }

        $this->series = $arr1;
        $this->carIds = $arr2;

        // dd($this->series, CheckoutOrder::get()->toArray());

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

    public function updatedSelectedCar($prop)
    {
        $nrInmatriculareArr = explode(':', $prop);
        $nrInmatriculare = $this->carIds[reset($nrInmatriculareArr)];
        dd($nrInmatriculare, CheckoutOrder::where('car_id', $nrInmatriculare)->get()->toArray());
        return;
    }

    public function renderMonth($month)
    {
        $this->emit('getSelectedDays');

        $this->prevMonth_str = prevMonth($month);
        $this->currentYearAndMonth = specificYearAndMonth($month);
        $this->nextMonth_str = nextMonth($month);
        $this->daysBetweenTwoDates_arr = daysBetween(specificStartDateOfMonth($month), specificEndDateOfMonth($month));
        $this->currentDay_int = $this->flipArrayObtainKey($this->nameOfDaysOfWeek_arr, specificDayNameLongFormat($month));
        $this->numberOfRows_int = $this->correctNumberOfRows();

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

    protected $listeners = [
        'newCalendarDate',
        'clearSelectedDates',
        'currentSelectedDays',
    ];

    public function clearSelectedDates()
    {
        $this->currentSelectedDays = [];
    }

    public function currentSelectedDays($value)
    {
        $this->currentSelectedDays = $value;
    }

    public function newCalendarDate($data)
    {
        $this->renderMonth(firstDayOTheMonth($data));
    }

    public function render()
    {
        return view('livewire.components.calendar');
    }
}
