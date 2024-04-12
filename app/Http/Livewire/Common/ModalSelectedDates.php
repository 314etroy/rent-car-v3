<?php

namespace App\Http\Livewire\Common;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\CheckoutOrder;
use App\Models\AdditionalService;
use App\Models\AdditionalEquipment;
use Illuminate\Validation\ValidationException;

class ModalSelectedDates extends Component
{
    public $showComponent = false;

    public $firstSelectedCard = null;
    public $lastSelectedCard = null;
    public $nrOfDays = 0;
    public $checkoutPrice = 0;

    public $selectedCarData = [];
    public $selectedEquipments = [];
    public $selectedServices = [];

    public $additionalEquipmentData = [];
    public $additionalServicesData = [];

    public $aditionalEquipmentIds = [];
    public $aditionalServicesIds = [];

    public $selectedEquipmentIds = [];
    public $selectedServicesIds = [];

    public $showDateError = false;
    public $timeIntervals = [];

    protected $listeners = [
        'modalSelectedDates',
        'hideModalSelectedDates',
    ];

    public $rawData = [
        'form_data' => [
            'name' => '',
            'first_name' => '',
            'company_name' => '',
            'cui' => '',
            'contry_region' => 'Romania',
            'complete_address' => '',
            'phone' => '',
            'email' => '',
            'location' => '',
            'pickup_time' => '',
            'return_time' => '',
            'additional_driver_name' => '',
        ],
        'services_data' => [],
        'equipments_data' => [],
    ];

    public $form_data_rules = [
        'rawData.form_data.name' => 'required',
        'rawData.form_data.first_name' => 'required',
        'rawData.form_data.contry_region' => 'required',
        'rawData.form_data.complete_address' => 'required',
        'rawData.form_data.phone' => 'required',
        'rawData.form_data.email' => 'required|email|unique:users,email',
        'rawData.form_data.location' => 'required',
        'rawData.form_data.pickup_time' => 'required',
        'rawData.form_data.return_time' => 'required',
    ];

    protected $messages = [
        'rawData.form_data.name.required' => 'este necesar',
        'rawData.form_data.first_name.required' => 'este necesar',
        'rawData.form_data.contry_region.required' => 'este necesar',
        'rawData.form_data.complete_address.required' => 'este necesar',
        'rawData.form_data.phone.required' => 'este necesar',
        'rawData.form_data.email.required' => 'este necesar',
        'rawData.form_data.email.email' => 'in format email',
        'rawData.form_data.email.unique' => 'email utilizat deja',
        'rawData.form_data.location.required' => 'este necesar',
        'rawData.form_data.pickup_time.required' => 'este necesar',
        'rawData.form_data.return_time.required' => 'este necesar',
    ];

    public function hideModalSelectedDates()
    {
        $this->reset([
            'showComponent',
            'rawData',
            'firstSelectedCard',
            'lastSelectedCard',
            'nrOfDays',
            'checkoutPrice',
            'selectedCarData',
            'selectedEquipments',
            'selectedServices',
            'additionalEquipmentData',
            'additionalServicesData',
            'aditionalEquipmentIds',
            'aditionalServicesIds',
            'selectedEquipmentIds',
            'selectedServicesIds',
            'showDateError',
            'timeIntervals',
        ]);
    }

    public function modalSelectedDates(array $modalData)
    {
        [
            'firstSelectedCard' => $firstSelectedCard,
            'lastSelectedCard' => $lastSelectedCard,
            'nrOfDays' => $nrOfDays,
            'selectedCarData' => $selectedCarData,
            'timeIntervals' => $timeIntervals,
        ] = $modalData['selectedData'];

        $this->timeIntervals = $timeIntervals;

        $correctOrderDates = getFirstAndLastDate($firstSelectedCard, $lastSelectedCard);
        
        $this->firstSelectedCard = $correctOrderDates['first'];
        $this->lastSelectedCard = $correctOrderDates['last'];

        $this->nrOfDays = $nrOfDays;
        $this->selectedCarData = $selectedCarData;

        $this->takeAdditionalEquipment();
        $this->takeAdditionalServices();

        $this->calculateTotal();

        $this->showComponent = !$this->showComponent;
    }

    private function takeAdditionalEquipment()
    {
        $dbAdditionalEquipment = AdditionalEquipment::select(['id', 'nume', 'code', 'descriere', 'pret'])->where('display', true)->get()->toArray();

        $arr = [];
        $aditionalEquipmentIds = [];

        foreach ($dbAdditionalEquipment ?? [] as $value) {
            $arr[$value['code']] = [
                'nume' => $value['nume'],
                'descriere' => $value['descriere'],
                'code' => $value['code'],
                'pret' => (float) $value['pret'],
                'isSelected' => $this->jsonArr['selectedEquipment'][$value['code']] ?? false,
            ];
            $aditionalEquipmentIds[$value['code']] = $value['id'];
        }

        $this->additionalEquipmentData = $arr;
        $this->aditionalEquipmentIds = $aditionalEquipmentIds;
    }

    private function takeAdditionalServices()
    {
        $dbAdditionalService = AdditionalService::select(['id', 'nume', 'row_code', 'services'])->where('display', true)->get()->toArray();

        $arr = [];
        $serviceCodes = [];
        $aditionalServicesIds = [];

        foreach ($dbAdditionalService ?? [] as $value) {
            $serviceCodes[$value['row_code']] = false;
            $arr[$value['row_code']] = [
                'nume' => $value['nume'],
                'row_code' => $value['row_code'],
                'services' => json_decode($value['services'], true) ?? [],
            ];
            $aditionalServicesIds[$value['row_code']] = $value['id'];
        }

        $this->additionalServicesData = $arr;
        $this->aditionalServicesIds = $aditionalServicesIds;
    }

    public function updated(string $property): void
    {
        if (strpos($property, 'rawData') === false) {
            return;
        }

        $this->handleRawDataCheckbox($property, 'equipments_data');
        $this->handleRawDataCheckbox($property, 'services_data');

        $this->handleValidateOnlyProperty($property);
    }

    private function handleRawDataCheckbox(string $property, string $whatToFind)
    {
        if (strpos($property, 'rawData.' . $whatToFind) !== false) {
            $segments = explode('.', $property);

            if ($whatToFind === 'services_data') {
                if (!$this->rawData[$whatToFind][$segments[2]][$segments[3]][$segments[4]]) {
                    unset($this->rawData[$whatToFind][$segments[2]]);
                    unset($this->selectedServices[$segments[2]]);
                    return;
                }
                unset($this->rawData[$whatToFind][$segments[2]]);
                $this->rawData[$whatToFind][$segments[2]][$segments[3]][$segments[4]] = true;
                $this->selectedServices[$segments[2]] = $segments[3];
            }

            if ($whatToFind === 'equipments_data' && !$this->rawData[$whatToFind][$segments[2]]) {
                unset($this->rawData[$whatToFind][$segments[2]]);
            }

            $this->calculateTotal();
        }
    }

    public function updatedRawData()
    {
        [
            'pickup_time' => $pickup_time,
            'return_time' => $return_time,
        ] = $this->rawData['form_data'];

        if (count($this->rawData['services_data']) && isset($this->rawData['services_data']['p2']['d1'][0])) {
            $this->rawData['form_data']['additional_driver_name'] = '';
        }

        $this->handleTime($pickup_time, $return_time);
    }

    private function handleTime(string $pickupTime, string $returnTime)
    {

        $pickUpDate = $this->firstSelectedCard;
        $returnDate = $this->lastSelectedCard;

        $currentDate = Carbon::now()->format('Y-m-d H:i');

        $pickUpFormat = $pickUpDate . ' ' . $pickupTime;
        $returnFormat = $returnDate . ' ' . $returnTime;

        if (!$pickUpDate || !$pickupTime) {
            $pickUpFormat = $currentDate;
        }

        if (!$returnDate || !$returnTime) {
            $returnFormat = $currentDate;
        }

        $currentDateTime = Carbon::now();
        $dateTime1 = Carbon::createFromFormat('Y-m-d H:i', $pickUpFormat);
        $dateTime2 = Carbon::createFromFormat('Y-m-d H:i', $returnFormat);

        $this->showDateError = !($dateTime1->lte($dateTime2) && $dateTime1->gte($currentDateTime) && $dateTime2->gte($currentDateTime));

        if (!$this->showDateError) {
            $dateTime1->addMinutes(45);
            // dacă $dateTime1 nu este mai mic sau egal cu $dateTime2, atunci $this->showDateError va fi setată la true, altfel va fi setată la false
            // $dateTime1 <= dateTime2 && dateTime1 >= currentDateTime && dateTime2 >= currentDateTime
            $this->showDateError = !($dateTime1->lte($dateTime2) && $dateTime1->gte($currentDateTime) && $dateTime2->gte($currentDateTime));
        }

        $this->showDateError = $this->checkTimeInterval($this->timeIntervals, $pickupTime, $returnTime);
    }

    private function calculateTotal()
    {
        $totalPrice = 0;

        [
            'pret' => $pret,
            'garantie' => $garantie,
        ] = $this->selectedCarData;

        $buyOptions = [$garantie, $pret];

        $this->selectedEquipmentIds = [];
        $this->selectedServicesIds = [];

        foreach ($this->rawData['equipments_data'] ?? [] as $key => $value) {
            if ($this->additionalEquipmentData[$key]['pret']) {
                $this->selectedEquipmentIds[] = $this->aditionalEquipmentIds[$key];
                $buyOptions[] = $this->additionalEquipmentData[$key]['pret'];
            }
        }

        foreach ($this->selectedServices ?? [] as $key => $value) {
            if ($this->additionalServicesData[$key]['services'][$value]['pret']) {
                $this->selectedServicesIds[] = $this->aditionalServicesIds[$key];
                $buyOptions[] = $this->additionalServicesData[$key]['services'][$value]['pret'];
            }
        }

        foreach ($buyOptions as $item) {
            $totalPrice += (float) $item;
        }

        $this->checkoutPrice = $totalPrice;
    }

    private function handleValidateOnlyProperty(string $property)
    {
        if (empty($property)) {
            dd('Eroare la validarea input-ului, contacteaza echipa de suport!');
        }

        return $this->validateOnly($property, $this->form_data_rules);
    }

    public function handleModalSelectedDates()
    {
        if ($this->hasValidationErrors($this->form_data_rules)) {
            $this->validate($this->form_data_rules);
        }
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

    private function checkTimeInterval(array $arr, string $startHHmm, string $endHHmm): bool
    {
        foreach ($arr as $key => $value) {
            // Dacă cheia nu este '24:00'
            if ($key !== '24:00') {
                // Convertim timpul de start și timpul de sfârșit la timestamp-uri pentru a facilita verificarea suprapunerii
                $startTime = strtotime($startHHmm);
                $endTime = strtotime($endHHmm);
                $valueStartTime = strtotime($value['start']);
                $valueEndTime = strtotime($value['end']);

                // Verificăm dacă intervalul specificat nu se suprapune cu intervalul curent din $arr
                if (!($startTime >= $valueEndTime || $endTime <= $valueStartTime)) {
                    return true; // Dacă există suprapunere, returnăm true
                }
            }
        }

        return false; // Dacă nu există suprapunere cu niciun interval, returnăm false
    }

    public function handleCheckoutOrder()
    {
        $this->handleModalSelectedDates();

        $arrUser = [];

        [
            'name' => $name,
            'first_name' => $first_name,
            'company_name' => $company_name,
            'cui' => $cui,
            'contry_region' => $contry_region,
            'complete_address' => $complete_address,
            'phone' => $phone,
            'email' => $email,
            'location' => $location,
            'pickup_time' => $pickup_time,
            'return_time' => $return_time,
            'additional_driver_name' => $additional_driver_name,
        ] = $this->rawData['form_data'];

        $arrUser['name'] = $name;
        $arrUser['first_name'] = $first_name;
        $arrUser['email'] = $email;
        $arrUser['phone'] = $phone;
        $arrUser['company_name'] = $company_name;
        $arrUser['cui'] = $cui;
        $arrUser['contry_region'] = $contry_region;
        $arrUser['complete_address'] = $complete_address;
        $arrUser['created_by'] = 'ADMIN';
        $arrUser['is_admin'] = false;
        $arrUser['password'] = '';
        $arrUser['code'] = uniqid();
        $arrUser['remember_token'] = NULL;
        $arrUser['email_verified_at'] = NULL;

        [
            'id' => $user_id,
        ] = User::create($arrUser)->toArray();

        [
            'id' => $car_id,
            'pretZi' => $pretZi,
            'nr_inmatriculare' => $nr_inmatriculare,
        ] = $this->selectedCarData;

        $haveAdditionalDriver = in_array('d2', array_values($this->selectedServices));
        $arrCheckout = [];

        if (Auth::check() && isAdmin()) {
            $arrCheckout['user_id'] = (int) $user_id;
        } else {
            $arrCheckout['user_id'] = 0;
        }

        $selectedServicesIds = [];
        foreach ($this->rawData['services_data'] ?? [] as $row_key => $row) {
            foreach ($row ?? [] as $service_key => $service) {
                $selectedServicesIds[] = [$this->aditionalServicesIds[$row_key] => $service_key];
            }
        }

        $arrCheckout['order_id'] = uniqid();
        $arrCheckout['car_id'] = $car_id;

        $arrCheckout['aditional_equipment_ids'] = json_encode($this->selectedEquipmentIds);
        $arrCheckout['aditional_services_ids'] = json_encode($selectedServicesIds);

        $arrCheckout['location'] = $location;
        $arrCheckout['pick_up_dateTime'] = $this->firstSelectedCard . ' ' . $pickup_time;
        $arrCheckout['return_dateTime'] = $this->lastSelectedCard . ' ' . $return_time;
        $arrCheckout['price'] = (float) $this->checkoutPrice;
        $arrCheckout['nr_of_days'] = $this->nrOfDays;
        $arrCheckout['status'] = false;
        $arrCheckout['additional_driver'] = $haveAdditionalDriver;
        $arrCheckout['additional_driver_name'] = $haveAdditionalDriver ? $additional_driver_name : '';
        $arrCheckout['price_per_day'] = $pretZi;

        CheckoutOrder::create($arrCheckout);
        $this->hideModalSelectedDates();

        $this->emitTo('components.calendar', 'updatedSelectedCar', $nr_inmatriculare, true);
    }

    public function render(): View
    {
        return view('livewire.common.modal-selected-dates');
    }
}
