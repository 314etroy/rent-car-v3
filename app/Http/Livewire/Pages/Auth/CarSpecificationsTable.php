<?php

namespace App\Http\Livewire\Pages\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CarSpecification;

class CarSpecificationsTable extends Component
{

    use WithPagination;

    public $searchCar = '';

    protected $listeners = [
        'refreshView' => '$refresh',
        'resetTable' => 'updatingSearchCar',
    ];

    public function updatingSearchCar()
    {
        $this->resetPage('carsPage');
    }

    public function render()
    {
        $carSpecifications = CarSpecification::select(['id', 'nume', 'nr_inmatriculare', 'cod_produs', 'pret', 'garantie', 'options', 'path', 'display'])->where('nume', 'like', "%{$this->searchCar}%")->paginate(3, ['*'], 'carsPage');
        
        return view('livewire.pages.auth.car-specifications-table', ['carSpecifications' => $carSpecifications]);
    }
}
