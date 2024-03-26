<?php

namespace App\Http\Livewire\Pages\Guest\Common;

use Livewire\Component;

class BreadcrumbButton extends Component
{
    public $content = '';
    public $sectionNumber = 0;
    public $isActive = false;

    public function changeSection(int $value)
    {
        if ($value === 0 || $value < 3) {
            $this->emitTo('pages.guest.rent-car', 'changeSection', $value);
        }
    }

    public function render()
    {
        return view('livewire.pages.guest.common.breadcrumb-button');
    }
}
