<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;

class ModalFormType extends Component
{
    public $day = null;
    public $monthName = '';
    public $showComponent = false;

    protected $listeners = [
        'modalFormType' => 'modalLogic',
        'hideFormModal' => 'hideModal',
    ];

    public function hideModal()
    {
        $this->showComponent = false;
    }

    public function modalLogic($data)
    {
        $this->day = $data['day'];
        $this->monthName = $data['monthName'];
        $this->showComponent = true;
    }

    public function render()
    {
        return view('livewire.common.modal-form-type');
    }
}
