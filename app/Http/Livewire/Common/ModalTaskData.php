<?php

namespace App\Http\Livewire\Common;

use Livewire\Component;

class ModalTaskData extends Component
{
    public $day = null;
    public $monthName = '';
    public $showComponent = false;
    public $time = null;
    public $task_data = null;

    protected $listeners = [
        'modalTaskData' => 'modalLogic',
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
        $this->time = $data['time'];
        $this->task_data = $data['task_data'];
    }

    public function render()
    {
        return view('livewire.common.modal-task-data');
    }
}
