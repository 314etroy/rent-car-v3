<?php

namespace App\Http\Livewire\Components;

use App\Models\AdditionalService;
use App\Http\Livewire\Common\Modal;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

class AdditionalServiceModal extends Modal
{

    public $modalProps = [
        'id' => null,
        'rowId' => null,
        'rowData' => [
            'nume' => '',
            'comment1' => '',
            'descriere1' => '',
            'pret1' => '',
            'comment2' => '',
            'descriere2' => '',
            'pret2' => '',
            'display' => false,
        ],
        'operation' => null,
        'inhibModalClosure' => false,
    ];

    public $services_rules = [
        'modalProps.rowData.nume' => 'required',

        'modalProps.rowData.comment1' => 'required',
        'modalProps.rowData.pret1' => 'required',

        'modalProps.rowData.comment2' => 'required',
        'modalProps.rowData.pret2' => 'required',
    ];

    protected $messages = [
        'modalProps.rowData.nume.required' => 'este necesar',

        'modalProps.rowData.comment1.required' => 'este necesar',
        'modalProps.rowData.pret1.required' => 'este necesar',

        'modalProps.rowData.comment2.required' => 'este necesar',
        'modalProps.rowData.pret2.required' => 'este necesar',
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
                'row_code' => $row_code,
                'services' => $services,
                'display' => $display,
            ] = $data['rowData'];

            $this->modalProps['id'] = $data['id'];
            $this->modalProps['rowId'] = $data['rowId'];
            $this->modalProps['rowData']['nume'] = $nume;
            $this->modalProps['rowData']['row_code'] = $row_code;
            $this->modalProps['rowData']['display'] = (bool) $display;

            $editArrData = json_decode($services, true);
            $index = 1;

            foreach ($editArrData as $value) {
                $this->modalProps['rowData']['comment' . $index] = $value['comment'];
                $this->modalProps['rowData']['descriere' . $index] = $value['descriere'];
                $this->modalProps['rowData']['pret' . $index] = $value['pret'];
                $this->modalProps['rowData']['code' . $index] = $value['code'];
                $index++;
            }
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

        $arr = [];
        $arr['nume'] = $rowData['nume'];
        $arr['row_code'] = uniqid();
        $arr['display'] = $rowData['display'];

        $servicesArr = [];
        foreach (range(1, 2) as $value) {
            $uniqId = uniqid();
            $servicesArr[$uniqId] = [
                'comment' => $rowData['comment' . $value],
                'pret' => (float) $rowData['pret' . $value],
                'descriere' => $rowData['descriere' . $value],
                'code' => $uniqId,
                'isSelected' => false,
            ];
        }

        $arr['services'] = json_encode($servicesArr);

        AdditionalService::create($arr);

        $this->closeModal();
        $this->emitTo('pages.auth.additional-service-table', 'refreshView');
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
            'row_code' => $row_code,
            'display' => $display,
        ] = $rowData;

        $arr = [];
        $arr['nume'] = $nume;
        $arr['row_code'] = $row_code;
        $arr['display'] = $display;

        $servicesArr = [];
        foreach (range(1, 2) as $value) {
            $servicesArr[$rowData['code' . $value]] = [
                'comment' => $rowData['comment' . $value],
                'pret' => (float) $rowData['pret' . $value],
                'descriere' => $rowData['descriere' . $value],
                'code' => $rowData['code' . $value],
                'isSelected' => false,
            ];
        }

        $arr['services'] = json_encode($servicesArr);

        AdditionalService::updateOrCreate(['id' => $this->modalProps['id']], $arr);

        $this->closeModal();
        $this->emitTo('pages.auth.additional-service-table', 'refreshView');
    }

    public function delete(): void
    {
        [
            'id' => $id,
        ] = $this->modalProps;

        empty($id) && exit;

        AdditionalService::find($id)->delete();

        $this->closeModal();
        $this->emitTo('pages.auth.additional-service-table', 'resetTable');
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
        return view('livewire.components.additional-service-modal');
    }
}
