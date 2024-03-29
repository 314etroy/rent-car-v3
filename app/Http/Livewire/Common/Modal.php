<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;

    protected $listeners = [
        'show',
        'closeModal',
        'refreshModal' => '$refresh',
    ];
    
    public function show(array $data): void
    {
        $this->init($data);

        $this->show = !$this->show;
    }
}
