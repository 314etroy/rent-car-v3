<?php

namespace App\Http\Livewire\Common;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;

use App\Models\CheckoutOrder;
use App\Models\AdditionalService;
use App\Models\AdditionalEquipment;

use Illuminate\Validation\ValidationException;

class ModalEditSelectedDates extends Component
{
    protected $listeners = [
        'modalEditSelectedDates',
        'hideEditModalSelectedDates',
    ];

    public $rawData = [];

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

    public $showComponent = false;
    public $showDeleteBtn = false;

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

    public $haveAdditionalDriver = false;
    public $showDateError = false;

    public $pick_up_dateTime = '';

    public $timeIntervals = [];

    public $pickDate = '';

    public $selectUserData = [
        'name',
        'first_name',
        'company_name',
        'cui',
        'contry_region',
        'complete_address',
        'phone',
        'email',
    ];

    public function hideEditModalSelectedDates()
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
            'haveAdditionalDriver',
            'showDateError',
            'showDeleteBtn',
            'pick_up_dateTime',
            'timeIntervals',
        ]);
    }

    public function modalEditSelectedDates(array $modalCheckoutData)
    {
        [
            'user_id' => $user_id,
            'order_id' => $order_id,
            'nr_of_days' => $nr_of_days,
            'price_per_day' => $price_per_day,
            'pick_up_dateTime' => $pick_up_dateTime,
            'price' => $price,
            'location' => $location,
            'additional_driver' => $additional_driver,
            'additional_driver_name' => $additional_driver_name,
            'aditional_equipment_ids' => $aditional_equipment_ids,
            'aditional_services_ids' => $aditional_services_ids,
            'car_name' => $car_name,
            'nr_inmatriculare' => $nr_inmatriculare,
            'garantie' => $garantie,
            'pickup_time' => $pickup_time,
            'return_time' => $return_time,
            'firstSelectedCard' => $firstSelectedCard,
            'lastSelectedCard' => $lastSelectedCard,
            'timeIntervals' => $timeIntervals,
        ] = $modalCheckoutData;

        $this->timeIntervals = $timeIntervals;
        $this->pickDate = $pickup_time;

        $this->checkoutPrice = $price;
        $this->haveAdditionalDriver = $additional_driver;
        $this->pick_up_dateTime = $pick_up_dateTime;

        $userData = User::where('id', $user_id)->select($this->selectUserData)->first()->toArray();

        $this->rawData = [
            'form_data' => [
                'name' => $userData['name'],
                'first_name' => $userData['first_name'],
                'company_name' => $userData['company_name'],
                'cui' => $userData['cui'],
                'contry_region' => $userData['contry_region'],
                'complete_address' => $userData['complete_address'],
                'phone' => $userData['phone'],
                'email' => $userData['email'],
                'location' => $location,
                'pickup_time' => $pickup_time,
                'return_time' => $return_time,
                'additional_driver_name' => $additional_driver_name,
            ],
            'services_data' => [],
            'equipments_data' => [],
            'user_id' => $user_id,
            'order_id' => $order_id,
            'nr_inmatriculare' => $nr_inmatriculare,
        ];

        $jsonDecodeEquipments = json_decode($aditional_equipment_ids, true);
        $jsonDecodeServices = json_decode($aditional_services_ids, true);

        $jsonDecodeEquipmentsKeys = [];
        foreach ($jsonDecodeEquipments as $value) {
            $jsonDecodeEquipmentsKeys[] = $value;
        }

        $jsonDecodeServicesKeys = [];
        foreach ($jsonDecodeServices as $value) {
            $jsonDecodeServicesKeys[] = key($value);
        }

        $this->takeAdditionalEquipment($jsonDecodeEquipmentsKeys);
        $this->takeAdditionalServices($jsonDecodeServicesKeys);

        $equipmentsFlipIds = array_flip($this->aditionalEquipmentIds);
        $servicesFlipIds = array_flip($this->aditionalServicesIds);

        foreach ($jsonDecodeEquipments ?? [] as $value) {
            $this->rawData['equipments_data'][$equipmentsFlipIds[$value]] = true;
        }

        if (!empty($jsonDecodeServices)) {
            $selectedServicesKeys = [];

            foreach ($jsonDecodeServices ?? [] as $array) {
                $selectedServicesKeys[] = reset($array);
            }

            foreach (array_values($servicesFlipIds) ?? [] as $key => $value) {
                $all_service_keys = array_keys($this->additionalServicesData[$value]['services']);
                $intersect_service_key = array_intersect($all_service_keys, $selectedServicesKeys);
                if (empty($intersect_service_key)) {
                    continue;
                }
                $rowAndServiceArrCodes = [$value => reset($intersect_service_key)];

                $this->selectedServices[$value] = reset($intersect_service_key);

                $service_key = key($rowAndServiceArrCodes);
                $service_value = current($rowAndServiceArrCodes);

                $checkboxPosition = array_flip($all_service_keys);

                $this->rawData['services_data'][$service_key][$service_value][$checkboxPosition[$service_value]] = true;
            }
        }

        $this->getFirstAndLastDate($firstSelectedCard, $lastSelectedCard);

        $this->nrOfDays = $nr_of_days;
        $this->selectedCarData = [
            'nume' => $car_name,
            'nr_inmatriculare' => $nr_inmatriculare,
            'garantie' => $garantie,
            'pret' => (float) $nr_of_days * $price_per_day,
            'pretZi' => $price_per_day,
        ];

        $this->showComponent = !$this->showComponent;
    }

    private function getFirstAndLastDate(string $date1, string $date2)
    {
        $dateTime1 = Carbon::parse($date1);
        $dateTime2 = Carbon::parse($date2);

        if ($dateTime1->lt($dateTime2)) {
            $this->firstSelectedCard = $date1;
            $this->lastSelectedCard = $date2;
        } else {
            $this->firstSelectedCard = $date2;
            $this->lastSelectedCard = $date1;
        }
    }

    public function updatedRawData()
    {
        [
            'pickup_time' => $pickup_time,
            'return_time' => $return_time,
        ] = $this->rawData['form_data'];

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

        if (empty($pickupTime) || empty($returnTime)) {
            $this->showDateError = true;
            return;
        }

        unset($this->timeIntervals[$this->pickDate]);
        $this->showDateError = $this->checkTimeInterval($this->timeIntervals, $pickupTime, $returnTime);
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

    private function takeAdditionalEquipment(array $jsonDecodeEquipmentsKeys)
    {
        $dbAdditionalEquipment = AdditionalEquipment::select(['id', 'nume', 'code', 'descriere', 'pret'])->whereIn('id', $jsonDecodeEquipmentsKeys)->get()->toArray();

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

    private function takeAdditionalServices(array $selectedServicesKeys)
    {
        $dbAdditionalService = AdditionalService::select(['id', 'nume', 'row_code', 'services'])->whereIn('id', $selectedServicesKeys)->get()->toArray();

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

    public function handleEditModalSelectedDates()
    {
        $rules = $this->form_data_rules;
        unset($rules['rawData.form_data.email']);

        if ($this->hasValidationErrors($rules)) {
            $this->validate($rules);
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

    public function handleCheckoutOrder()
    {
        $this->handleEditModalSelectedDates();

        $arrUser = [];
        $arrCheckout = [];

        [
            'name' => $name,
            'first_name' => $first_name,
            'company_name' => $company_name,
            'cui' => $cui,
            'contry_region' => $contry_region,
            'complete_address' => $complete_address,
            'phone' => $phone,
            'location' => $location,
            'pickup_time' => $pickup_time,
            'return_time' => $return_time,
            'additional_driver_name' => $additional_driver_name,
        ] = $this->rawData['form_data'];

        [
            'user_id' => $user_id,
            'order_id' => $order_id,
            'nr_inmatriculare' => $nr_inmatriculare,
        ] = $this->rawData;

        $arrUser['name'] = $name;
        $arrUser['first_name'] = $first_name;
        $arrUser['phone'] = $phone;
        $arrUser['company_name'] = $company_name;
        $arrUser['cui'] = $cui;
        $arrUser['contry_region'] = $contry_region;
        $arrUser['complete_address'] = $complete_address;

        User::where('id', $user_id)->update($arrUser);

        $arrCheckout['location'] = $location;
        $arrCheckout['pick_up_dateTime'] = $this->firstSelectedCard . ' ' . $pickup_time;
        $arrCheckout['return_dateTime'] = $this->lastSelectedCard . ' ' . $return_time;
        $arrCheckout['additional_driver_name'] = $additional_driver_name;

        CheckoutOrder::where('order_id', $order_id)->update($arrCheckout);

        $this->hideEditModalSelectedDates();
        $this->emitTo('components.calendar', 'updatedSelectedCar', $nr_inmatriculare, true);
    }

    public function handleCheckoutOrderAccordion()
    {
        $this->showDeleteBtn = !$this->showDeleteBtn;
    }

    public function deleteCheckoutOrder()
    {
        [
            'order_id' => $order_id,
            'nr_inmatriculare' => $nr_inmatriculare,
        ] = $this->rawData;

        CheckoutOrder::where('order_id', $order_id)->delete();

        $this->hideEditModalSelectedDates();
        $this->emitTo('components.calendar', 'updatedSelectedCar', $nr_inmatriculare, true);
    }

    public function render(): View
    {
        return view('livewire.common.modal-edit-selected-dates');
    }
}
