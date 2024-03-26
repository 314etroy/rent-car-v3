<?php

namespace App\Http\Livewire\Pages\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AdditionalService;

class AdditionalServiceTable extends Component
{

    use WithPagination;

    public $searchService = '';

    protected $listeners = [
        'refreshView' => '$refresh',
        'resetTable' => 'updatingSearchService',
    ];

    public function updatingSearchService()
    {
        $this->resetPage('servicesPage');
    }

    public function render()
    {
        $additionalServices = AdditionalService::select(['id', 'nume', 'row_code', 'services', 'display'])->where('nume', 'like', "%{$this->searchService}%")->paginate(3, ['*'], 'servicesPage');

        return view('livewire.pages.auth.additional-service-table', ['additionalServices' => $additionalServices]);
    }
}
