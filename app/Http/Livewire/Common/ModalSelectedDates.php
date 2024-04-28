<?php

namespace App\Http\Livewire\Common;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        'rawData.form_data.phone' => 'required|numeric|digits_between:1,10',
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
        'rawData.form_data.phone.numeric' => 'in format numeric',
        'rawData.form_data.phone.digits_between' => 'maxim 10 cifre',
        'rawData.form_data.email.required' => 'este necesar',
        'rawData.form_data.email.email' => 'in format email',
        'rawData.form_data.email.unique' => 'email utilizat deja',
        'rawData.form_data.location.required' => 'este necesar',
        'rawData.form_data.pickup_time.required' => 'este necesar',
        'rawData.form_data.return_time.required' => 'este necesar',
    ];

    public function hideModalSelectedDates()
    {
        $this->resetValidation();
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

        $this->handleModalSelectedDates();
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
        $dateTime145 = Carbon::createFromFormat('Y-m-d H:i', $pickUpFormat)->addMinutes(45);

        $this->showDateError = !($dateTime145->lte($dateTime2) && $dateTime1->gte($currentDateTime) && $dateTime2->gte($currentDateTime));

        if (empty($pickupTime) || empty($returnTime)) {
            $this->showDateError = true;
            return;
        }
    }

    private function calculateTotal()
    {
        $totalPrice = 0;

        [
            'pret' => $pret,
            'garantie' => $garantie,
        ] = $this->selectedCarData;

        $buyOptions = [(float) $garantie * $this->nrOfDays, (float) $pret];

        $this->selectedEquipmentIds = [];
        $this->selectedServicesIds = [];

        foreach ($this->rawData['equipments_data'] ?? [] as $key => $value) {
            if ($this->additionalEquipmentData[$key]['pret']) {
                $this->selectedEquipmentIds[] = $this->aditionalEquipmentIds[$key];
                $buyOptions[] = (float) $this->additionalEquipmentData[$key]['pret'] * $this->nrOfDays;
            }
        }

        foreach ($this->selectedServices ?? [] as $key => $value) {
            if ($this->additionalServicesData[$key]['services'][$value]['pret']) {
                $this->selectedServicesIds[] = $this->aditionalServicesIds[$key];
                $buyOptions[] = (float) $this->additionalServicesData[$key]['services'][$value]['pret'];
            }
        }
        
        foreach ($buyOptions as $item) {
            $totalPrice += (float) $item;
        }

        $this->checkoutPrice = $totalPrice;
    }

    private function handleModalSelectedDates()
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
            'nume' => $car_name,
            'nr_inmatriculare' => $nr_inmatriculare,
        ] = $this->selectedCarData;
        
        $haveAdditionalDriver = in_array('65f8a6b2370b0', array_values($this->selectedServices));
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

        $pick_up_dateTime = $this->firstSelectedCard . ' ' . $pickup_time;
        $return_dateTime = $this->lastSelectedCard . ' ' . $return_time;

        $arrCheckout['location'] = $location;
        $arrCheckout['pick_up_dateTime'] = $pick_up_dateTime;
        $arrCheckout['return_dateTime'] = $return_dateTime;
        $arrCheckout['price'] = (float) $this->checkoutPrice;
        $arrCheckout['nr_of_days'] = $this->nrOfDays;
        $arrCheckout['status'] = false;
        $arrCheckout['additional_driver'] = $haveAdditionalDriver;
        $arrCheckout['additional_driver_name'] = $haveAdditionalDriver ? $additional_driver_name : '';
        $arrCheckout['price_per_day'] = $pretZi;

        [
            'order_id' => $order_id,
        ] = CheckoutOrder::create($arrCheckout);

        $buyOptions = [];

        if (count($this->selectedCarData) && $this->selectedCarData['garantie'] && $this->selectedCarData['pretZi']) {
            $buyOptions[] = ['nume' => $this->selectedCarData['nume'], 'pret' => (float) $this->selectedCarData['pretZi'], 'showPriceDetails' => true];
            $buyOptions[] = ['nume' => 'Garantie', 'pret' => (float) $this->selectedCarData['garantie'], 'showPriceDetails' => true];
        }

        foreach ($this->additionalEquipmentData ?? [] as $key => $value) {
            if (in_array($key, array_keys($this->rawData['equipments_data']))) {
                $buyOptions[] = ['nume' => $value['nume'], 'pret' => (float) $value['pret'], 'showPriceDetails' => true];
            }
        }

        foreach ($this->rawData['services_data'] ?? [] as $key1 => $value) {
            foreach ($value ?? [] as $key2 => $data) {
                if ($key1 && $key2 && $this->additionalServicesData[$key1]['services'][$key2]['pret'] > 0) {
                    $buyOptions[] = ['nume' => $this->additionalServicesData[$key1]['services'][$key2]['comment'], 'pret' => (float) $this->additionalServicesData[$key1]['services'][$key2]['pret']];
                }
            }
        }

        $emailDetails = [
            'nameSiPrenume' => $name . ' ' . $first_name,
            'email' => $email,
            'phone' => $phone,
            'car_name' => $car_name,
            'car_number' => $nr_inmatriculare,
            'pick_up_dateTime' => $pick_up_dateTime,
            'return_dateTime' => $return_dateTime,
            'nr_of_days' => $this->nrOfDays,
            'price' => (float) $this->checkoutPrice,
            'buyOptions' => $buyOptions,
            'location' => ucfirst($location),
            'order_id' => $order_id,
        ];

        $this->handleEmailSubmit(env('MAIL_TO'), $emailDetails);
        $this->handleEmailSubmit($emailDetails['email'], $emailDetails);

        $this->hideModalSelectedDates();
        $this->emitTo('components.calendar', 'updatedSelectedCar', $nr_inmatriculare, true);
    }

    private function handleEmailSubmit(string $emailTo, array $emailDetails)
    {
        Mail::send('emails.checkout', ['details' => $emailDetails], function ($message) use ($emailTo, $emailDetails) {
            $message->from('no-replay@site.ro')->to($emailTo)->subject('CheckOut: ' . $emailDetails['nameSiPrenume']);
        });
    }

    public function render(): View
    {
        return view('livewire.common.modal-selected-dates');
    }
}
