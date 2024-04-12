<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;

class CalendarCard extends Component
{
    public $date = null;
    public $cardData = [];
    public $timeIntervals = [];

    public function mount()
    {
        // aici cand se randeaza
    }

    public function render()
    {
        return view('livewire.common.calendar-card');
    }
}
