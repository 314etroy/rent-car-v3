<?php

namespace App\Http\Livewire\Components;

use App\Models\AdditionalEquipment;
use App\Http\Livewire\Common\Modal;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

class AdditionalEquipmentModal extends Modal
{

    public $modalProps = [
        'id' => null,
        'rowId' => null,
        'rowData' => [
            'nume' => '',
            'descriere' => '',
            'pret' => '',
            'display' => false,
        ],
        'operation' => null,
        'inhibModalClosure' => false,
    ];

    public $services_rules = [
        'modalProps.rowData.nume' => 'required',
        'modalProps.rowData.pret' => 'required',
    ];

    protected $messages = [
        'modalProps.rowData.nume.required' => 'este necesar',
        'modalProps.rowData.pret.required' => 'este necesar',
    ];

    private function resetModalData()
    {
        $this->reset('modalProps');
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetModalData();
    }

    protected function init(array $data): void
    {
        $this->resetModalData();

        empty($data) && exit;

        if ($data['operation'] === 'edit') {

            [
                'nume' => $nume,
                'descriere' => $descriere,
                'pret' => $pret,
                'display' => $display,
            ] = $data['rowData'];

            $this->modalProps['id'] = $data['id'];
            $this->modalProps['rowData']['nume'] = $nume;
            $this->modalProps['rowData']['descriere'] = $descriere;
            $this->modalProps['rowData']['pret'] = $pret;
            $this->modalProps['rowData']['display'] = (bool) $display;
        }

        if ($data['operation'] === 'delete') {
            $this->modalProps['id'] = $data['id'];
            $this->modalProps['rowId'] = $data['rowId'];
            $this->modalProps['rowData']['nume'] = $data['rowData']['nume'];
        }

        $this->modalProps['operation'] = $data['operation'];
        $this->modalProps['inhibModalClosure'] = $data['inhibModalClosure'];
    }

    public function create(): void
    {
        $rules = $this->services_rules;

        if ($this->hasValidationErrors($rules)) {
            $this->validate($rules);
        }

        // prepare code to be send in db-Table

        $rowData = $this->modalProps['rowData'];

        [
            'nume' => $nume,
            'descriere' => $descriere,
            'pret' => $pret,
            'display' => $display,
        ] = $rowData;

        $arr = [];
        $arr['nume'] = $nume;
        $arr['descriere'] = $descriere;
        $arr['pret'] = (float) $pret;
        $arr['code'] = uniqid();
        $arr['display'] = $display;

        AdditionalEquipment::create($arr);

        $this->closeModal();
        $this->emitTo('pages.auth.additional-equipment-table', 'refreshView');
    }

    public function update(): void
    {
        $rules = $this->services_rules;

        if ($this->hasValidationErrors($rules)) {
            $this->validate($rules);
        }

        // prepare code to be send in db-Table

        $rowData = $this->modalProps['rowData'];

        [
            'nume' => $nume,
            'descriere' => $descriere,
            'pret' => $pret,
            'display' => $display,
        ] = $rowData;

        $arr = [];
        $arr['nume'] = $nume;
        $arr['descriere'] = $descriere;
        $arr['pret'] = (float) $pret;
        $arr['code'] = uniqid();
        $arr['display'] = $display;

        AdditionalEquipment::updateOrCreate(['id' => $this->modalProps['id']], $arr);

        $this->closeModal();
        $this->emitTo('pages.auth.additional-equipment-table', 'refreshView');
    }

    public function delete(): void
    {
        [
            'id' => $id,
        ] = $this->modalProps;

        empty($id) && exit;

        AdditionalEquipment::find($id)->delete();

        $this->closeModal();
        $this->emitTo('pages.auth.additional-equipment-table', 'resetTable');
    }

    public function updated(string $property): void
    {
        $this->handleValidateOnlyProperty($property);
    }

    private function handleValidateOnlyProperty(string $property)
    {

        $this->validateOnly($property, $this->services_rules);
    }

    private function hasValidationErrors(array $rules): bool
    {
        try {
            $this->validate($rules);
            return false;
        } catch (ValidationException $e) {
            // Validation errors occurred
            // dd($e->validator->getMessageBag());
            return true;
        }
    }

    public function render(): View
    {
        return view('livewire.components.additional-equipment-modal');
    }
}
