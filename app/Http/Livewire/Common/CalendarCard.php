<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;
// use Illuminate\Support\Facades\Cookie;

class CalendarCard extends Component
{
    public $day = null;
    public $date = null;
    public $monthName = '';
    public $isDaySelected = false;
    public $currentSelectedDays = [];

    public function isSelected($value)
    {
        $this->isDaySelected = !$this->isDaySelected;
        
        if($this->isDaySelected) {
            // dd($value);
            $this->emit('newSelectedDay', $value);
        } else {
            $this->emit('removeSelectedDay', $value);
        }

        // $cookie = json_decode(Cookie::get('checkout'));

        // $cookie[] = $value;
        // Cookie::queue('checkout', json_encode($cookie), 30);

        // Cookie::expire('checkout');
    }

    public function render()
    {
        return view('livewire.common.calendar-card');
    }
}
