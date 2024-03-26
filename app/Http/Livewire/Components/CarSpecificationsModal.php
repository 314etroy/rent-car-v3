<?php

namespace App\Http\Livewire\Components;

use Livewire\WithFileUploads;
use App\Models\CarSpecification;
use App\Http\Livewire\Common\Modal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CarSpecificationsModal extends Modal
{

    use WithFileUploads;

    public $modalProps = [
        'id' => null,
        'rowId' => null,
        'rowData' => [
            'nume' => '',
            'nr_inmatriculare' => '',
            'culoare' => '',
            'garantie' => '',
            'image' => '',
            'pretPerioada' => [],
            'optiune' => [],
            'display' => false,
        ],
        'operation' => null,
        'inhibModalClosure' => false,
    ];

    public $temporaryPhoto = null;
    public $storagePhotoLocation = null;
    public $isValidPhoto = false;

    public $services_rules = [
        'modalProps.rowData.nume' => 'required',
        'modalProps.rowData.nr_inmatriculare' => 'required',
        'modalProps.rowData.garantie' => 'required',
        'modalProps.rowData.image' => 'required|image|mimes:jpeg,jpg,png|max:1024',
    ];

    protected $messages = [
        'modalProps.rowData.nume.required' => 'este necesar',
        'modalProps.rowData.nr_inmatriculare.required' => 'este necesar',
        'modalProps.rowData.garantie.required' => 'este necesar',
        'modalProps.rowData.image.required' => 'este necesar',
        'modalProps.rowData.image.image' => 'trebuie sa fie imagine',
        'modalProps.rowData.image.max' => 'nu trebuie sa depaseasca 1MB',
        'modalProps.rowData.image.mimes' => 'trebuie sa fie JPEG, JPG sau PNG',
    ];

    public $nrPretPerioada = 0;
    public $nrOptiune = 0;

    public function addPretPerioada()
    {
        $this->nrPretPerioada = $this->nrPretPerioada + 1;
        $this->modalProps['rowData']['pretPerioada'][] = [
            'perioada' => null,
            'pret' => null,
        ];
    }

    private function resetModalData()
    {
        $this->reset([
            'nrOptiune',
            'modalProps',
            'isValidPhoto',
            'nrPretPerioada',
            'temporaryPhoto',
            'pretPerioadaErrorMsg',
            'storagePhotoLocation',
        ]);
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetModalData();
        $this->emitSelf('refreshModal');
    }

    public function deletePretPerioada($item)
    {
        unset($this->modalProps['rowData']['pretPerioada'][$item]);
        $this->modalProps['rowData']['pretPerioada'] = array_values($this->modalProps['rowData']['pretPerioada']);
        $this->nrPretPerioada = $this->nrPretPerioada - 1;
    }

    public function addOptiune()
    {
        $this->nrOptiune = $this->nrOptiune + 1;
    }

    public function deleteOptiune($item)
    {
        unset($this->modalProps['rowData']['optiune'][$item]);
        $this->modalProps['rowData']['optiune'] = array_values($this->modalProps['rowData']['optiune']);
        $this->nrOptiune = $this->nrOptiune - 1;
    }

    protected function init(array $data): void
    {
        $this->resetModalData();

        empty($data) && exit;

        if ($data['operation'] === 'edit') {

            [
                'nume' => $nume,
                'nr_inmatriculare' => $nr_inmatriculare,
                'garantie' => $garantie,
                'pret' => $pretPerioada,
                'options' => $optiune,
                'path' => $path,
                'display' => $display,
            ] = $data['rowData'];

            $this->modalProps['id'] = $data['id'];
            $this->modalProps['rowData']['nume'] = $nume;
            $this->modalProps['rowData']['nr_inmatriculare'] = $nr_inmatriculare;
            $this->modalProps['rowData']['garantie'] = $garantie;
            $this->modalProps['rowData']['image'] = $path;
            $this->modalProps['rowData']['display'] = (bool) $display;

            $this->isValidPhoto = $path !== null && $path !== '';

            if ($this->isValidPhoto) {
                $this->storagePhotoLocation = 'public/images/cars/' . $path;
            }

            $pretPerioadaDecode = json_decode($pretPerioada, true);
            $optiuneDecode = json_decode($optiune, true);

            $this->nrPretPerioada = count($pretPerioadaDecode ?? []);
            $this->nrOptiune = count($optiuneDecode ?? []);

            foreach ($pretPerioadaDecode ?? [] as $key => $value) {
                $this->modalProps['rowData']['pretPerioada'][] = ['perioada' => $key, 'pret' => $value];
            }

            foreach ($optiuneDecode ?? [] as $value) {
                $this->modalProps['rowData']['optiune'][] = ['nume' => $value['nume'], 'descriere' => $value['descriere']];
            }
        }

        if ($data['operation'] === 'delete') {
            $this->modalProps['id'] = $data['id'];
            $this->modalProps['rowId'] = $data['rowId'];
            $this->modalProps['rowData']['nume'] = $data['rowData']['nume'];
            $this->storagePhotoLocation = 'public/images/cars/' . $data['rowData']['path'];
        }

        $this->modalProps['operation'] = $data['operation'];
        $this->modalProps['inhibModalClosure'] = $data['inhibModalClosure'];
    }

    public $pretPerioadaErrorMsg = false;

    public function create(): void
    {
        $baseNameImage = '';
        $storePath = 'public/images/cars';
        $rules = $this->services_rules;

        if ($this->hasValidationErrors($rules)) {
            $this->validate($rules);
        }

        // prepare code to be send in db-Table

        $rowData = $this->modalProps['rowData'];

        [
            'nume' => $nume,
            'nr_inmatriculare' => $nr_inmatriculare,
            'garantie' => $garantie,
            'pretPerioada' => $pretPerioada,
            'optiune' => $optiune,
            'image' => $image,
            'display' => $display,
        ] = $rowData;

        if (empty($pretPerioada) || !$this->hasNonNullValues($pretPerioada, ['perioada', 'pret'])) {
            $this->pretPerioadaErrorMsg = true;
            return;
        }

        $this->reset('pretPerioadaErrorMsg');

        $arr = [];
        $rawPretPerioadaArr = [];
        $rawOptionsArr = [];
        $arr['nume'] = $nume;
        $arr['nr_inmatriculare'] = $nr_inmatriculare;
        $arr['garantie'] = $garantie;
        $arr['cod_produs'] = uniqid();
        $arr['display'] = $display;

        foreach ($pretPerioada ?? [] as $value) {
            $rawPretPerioadaArr[$value['perioada']] = (float) $value['pret'];
        }

        $arr['pret'] = json_encode($rawPretPerioadaArr);

        foreach ($optiune ?? [] as $value) {
            $rawOptionsArr[] = [
                'nume' => $value['nume'],
                'descriere' =>  $value['descriere']
            ];
        }

        if (is_object($image)) {
            $imagePath = $image->store($storePath);
            $baseNameImage = basename($imagePath) ?? '';
        }

        $arr['options'] = json_encode($rawOptionsArr);
        $arr['path'] = $baseNameImage;

        CarSpecification::create($arr);

        $this->closeModal();
        $this->emitTo('pages.auth.car-specifications-table', 'refreshView');
    }

    private function hasNonNullValues(array $arr, array $values): bool
    {
        $hasNonNullValues = false;

        foreach ($arr as $subArray) {
            if (
                isset($subArray[$values[0]], $subArray[$values[1]]) &&
                ($subArray[$values[0]] !== null && $subArray[$values[0]] !== "") &&
                ($subArray[$values[1]] !== null && $subArray[$values[1]] !== "")
            ) {
                $hasNonNullValues = true;
                break;
            }
        }

        return $hasNonNullValues;
    }

    public function update(): void
    {

        $baseNameImage = '';
        $storePath = 'public/images/cars';
        $rules = $this->services_rules;
        unset($rules['modalProps.rowData.image']);

        if ($this->hasValidationErrors($rules)) {
            $this->validate($rules);
        }

        // prepare code to be send in db-Table

        $rowData = $this->modalProps['rowData'];

        [
            'nume' => $nume,
            'nr_inmatriculare' => $nr_inmatriculare,
            'garantie' => $garantie,
            'pretPerioada' => $pretPerioada,
            'optiune' => $optiune,
            'image' => $image,
            'display' => $display,
        ] = $rowData;

        if (is_object($image)) {
            if ($this->storagePhotoLocation) {
                Storage::delete($this->storagePhotoLocation);
            }

            $imgRule = [
                'modalProps.rowData.image' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            ];

            if ($this->hasValidationErrors($imgRule)) {
                $this->validate($imgRule);
            }

            $imagePath = $image->store($storePath);
            $baseNameImage = basename($imagePath) ?? '';
        } else {
            $baseNameImage = $image;
        }

        if (empty($pretPerioada) || !$this->hasNonNullValues($pretPerioada, ['perioada', 'pret'])) {
            $this->pretPerioadaErrorMsg = true;
            return;
        }

        $this->reset('pretPerioadaErrorMsg');

        $arr = [];
        $rawPretPerioadaArr = [];
        $rawOptionsArr = [];
        $arr['nume'] = $nume;
        $arr['nr_inmatriculare'] = $nr_inmatriculare;
        $arr['garantie'] = $garantie;
        $arr['cod_produs'] = uniqid();
        $arr['path'] = $baseNameImage;
        $arr['display'] = $display;

        foreach ($pretPerioada ?? [] as $value) {
            $rawPretPerioadaArr[$value['perioada']] = (float) $value['pret'];
        }

        $arr['pret'] = json_encode($rawPretPerioadaArr);

        foreach ($optiune ?? [] as $value) {
            $rawOptionsArr[] = [
                'nume' => $value['nume'],
                'descriere' =>  $value['descriere']
            ];
        }

        $arr['options'] = json_encode($rawOptionsArr);

        CarSpecification::updateOrCreate(['id' => $this->modalProps['id']], $arr);

        $this->closeModal();
        $this->emitTo('pages.auth.car-specifications-table', 'refreshView');
    }

    public function delete(): void
    {
        [
            'id' => $id,
        ] = $this->modalProps;

        empty($id) && exit;

        if ($this->storagePhotoLocation) {
            Storage::delete($this->storagePhotoLocation);
        }

        CarSpecification::find($id)->delete();

        $this->closeModal();
        $this->emitTo('pages.auth.car-specifications-table', 'resetTable');
    }

    public function updated(string $property): void
    {

        if ($property === 'modalProps.rowData.image') {
            $this->temporaryPhoto = $this->modalProps['rowData']['image'];
        }

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
        return view('livewire.components.car-specifications-modal');
    }
}
