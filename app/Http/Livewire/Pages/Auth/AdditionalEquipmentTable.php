<?php

namespace App\Http\Livewire\Pages\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AdditionalEquipment;

class AdditionalEquipmentTable extends Component
{

    use WithPagination;

    public $searchEquipment = '';

    protected $listeners = [
        'refreshView' => '$refresh',
        'resetTable' => 'updatingSearchEquipment',
    ];

    public function updatingSearchEquipment()
    {
        $this->resetPage('equipmentsPage');
    }

    public function render()
    {
        $additionalEquipment = AdditionalEquipment::select(['id', 'nume', 'descriere', 'pret', 'code', 'display'])->where('nume', 'like', "%{$this->searchEquipment}%")->paginate(3, ['*'], 'equipmentsPage');

        return view('livewire.pages.auth.additional-equipment-table', ['additionalEquipment' => $additionalEquipment]);
    }
}
