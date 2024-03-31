<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;

class MonthCalendar extends Component
{
    public $currentYear = null;
    public $prevYear_str = null;
    public $nextYear_str = null;
    public $showComponent = false;
    public $currentYearAndMonth = null;
    public $allMonthsInYear = null;
    public $selectedMonth = null;
    public $currentDateFormatNormal_str = null;

    public function boot()
    {
        $this->prevYear_str = prevYear($this->currentYear);
        $this->nextYear_str = nextYear($this->currentYear);
        $this->allMonthsInYear = allMonthsInYearShortFormat();
        $this->selectedMonth = specificMonth($this->currentYearAndMonth);
    }

    public function mount()
    {
        $this->currentDateFormatNormal_str = firstDayOTheMonth($this->currentYearAndMonth);
        $this->selectedMonth = specificMonth($this->currentDateFormatNormal_str);
        $this->prevYear_str = prevYear($this->currentDateFormatNormal_str);
        $this->nextYear_str = nextYear($this->currentDateFormatNormal_str);
        $this->currentYearAndMonth = $this->logicForYearAndLongFormatMonth($this->currentYearAndMonth);
    }

    protected $listeners = [
        'newCurrentYearAndMonth',
        'hideComp',
    ];

    public function renderYear($year)
    {
        $this->currentYear = specificYear($year);
        $newYearDate = recreateYearMonthDay($this->currentYear, $this->selectedMonth, '1');
        $this->currentYearAndMonth = $this->logicForYearAndLongFormatMonth($newYearDate);
        $this->prevYear_str = prevYear($newYearDate);
        $this->nextYear_str = nextYear($newYearDate);

        $this->emit('newCalendarDate', $newYearDate);
    }

    public function updatingCurrentYear($year)
    {
        if (strlen($year) === 4) {
            $changedYear = recreateYearMonthDay($year, $this->selectedMonth, '1');

            $this->currentYearAndMonth = $this->logicForYearAndLongFormatMonth($changedYear);
            $this->prevYear_str = prevYear($changedYear);
            $this->nextYear_str = nextYear($changedYear);
            $this->emit('newCalendarDate', $changedYear);
        } else {
            $this->currentYear = currentYearMonthAndDaySimpleFormat();
            $this->emit('newCalendarDate', $this->currentYear);
        }
    }

    public function updated($prop)
    {
        if ($prop === 'currentYear' && strlen($this->currentYear) < 4) {
            $this->currentYear = currentYearMonthAndDaySimpleFormat();
        }
    }

    public function selectedMonth($month)
    {
        $calendarDate = recreateYearMonthDay($this->currentYear, $month, '1');
        $this->selectedMonth = specificMonth($calendarDate);
        $this->currentYearAndMonth = $this->logicForYearAndLongFormatMonth($calendarDate);
        $this->emit('newCalendarDate', $calendarDate);
    }

    public function newCurrentYearAndMonth($value)
    {
        $this->currentYearAndMonth = $this->logicForYearAndLongFormatMonth($value);
        $this->selectedMonth = specificMonth($value);
    }

    public function resetDateToCurrentDate()
    {
        $this->currentYearAndMonth = currentYearAndLongFormatMonth();
        $this->selectedMonth = currentMonth();
        $this->emit('newCalendarDate', currentYearMonthAndDay());
    }

    public function logicForYearAndLongFormatMonth($value)
    {
        return isset($value) ? specificYearAndLongFormatMonth($value) : currentYearAndLongFormatMonth();
    }

    public function hideComp()
    {
        $this->showComponent = false;
    }

    public function showDropdown()
    {
        $this->currentYear = specificYear($this->currentDateFormatNormal_str);
        $this->showComponent = !$this->showComponent;
    }

    public function render()
    {
        return view('livewire.common.month-calendar');
    }
}
