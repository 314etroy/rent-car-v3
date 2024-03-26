<?php

namespace App\Http\Livewire\Pages\Guest;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use App\Models\CheckoutOrder;
use App\Models\CarSpecification;
use App\Models\AdditionalService;
use App\Models\AdditionalEquipment;

use Illuminate\Validation\ValidationException;

class RentCar extends Component
{

    public $step = 0;

    private $jsonArr = [
        'rent_date' => [],
        'selectedCar' => [],
        'selectedEquipment' => [],
        'selectedServices' => [],
        'order' => [],
        'checkout_form' => [],
    ];

    private $carIds = [];
    private $aditionalServicesIds = [];
    private $aditionalEquipmentIds = [];

    public $rawData = [
        'rent_date' => [
            'location' => '',
            'return_location' => '',
            'return_to_another_location' => '',
            'pickup_date' => '',
            'return_date' => '',
            'pickup_time' => '',
            'return_time' => '',
        ],
        'check_out' => [
            'name' => '',
            'first_name' => '',
            'company_name' => '',
            'cui' => '',
            'contry_region' => 'Romania',
            'complete_address' => '',
            // 'judet' => '',
            'phone' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'terms' => '',
            'policy' => '',
        ],
    ];

    public $rent_date_rules = [
        'rawData.rent_date.location' => 'required',
        'rawData.rent_date.return_location' => '',
        'rawData.rent_date.return_to_another_location' => '',
        'rawData.rent_date.pickup_date' => 'required',
        'rawData.rent_date.return_date' => 'required',
        'rawData.rent_date.pickup_time' => 'required',
        'rawData.rent_date.return_time' => 'required',
    ];

    public $check_out_rules = [
        'rawData.check_out.name' => 'required',
        'rawData.check_out.first_name' => 'required',
        'rawData.check_out.company_name' => '',
        'rawData.check_out.cui' => '',
        'rawData.check_out.contry_region' => 'required',
        'rawData.check_out.complete_address' => 'required',
        // 'rawData.check_out.judet' => 'required',
        'rawData.check_out.phone' => 'required',
        'rawData.check_out.email' => 'required|email',
        'rawData.check_out.password' => '',
        'rawData.check_out.confirm_password' => '',
        'rawData.check_out.terms' => 'required|boolean|accepted',
        'rawData.check_out.policy' => 'required|boolean|accepted',
    ];

    protected $messages = [
        'rawData.rent_date.location.required' => 'este necesar',
        'rawData.rent_date.return_to_another_location.required' => 'este necesar',
        'rawData.rent_date.pickup_date.required' => 'este necesar',
        'rawData.rent_date.return_date.required' => 'este necesar',
        'rawData.rent_date.pickup_time.required' => 'este necesar',
        'rawData.rent_date.return_time.required' => 'este necesar',

        'rawData.check_out.name.required' => 'este necesar',
        'rawData.check_out.first_name.required' => 'este necesar',
        'rawData.check_out.contry_region.required' => 'este necesar',
        'rawData.check_out.complete_address.required' => 'este necesar',
        // 'rawData.check_out.judet.required' => 'este necesar',
        'rawData.check_out.phone.required' => 'este necesar',
        'rawData.check_out.email.required' => 'este necesar',
        'rawData.check_out.email.email' => 'in format email',
        'rawData.check_out.terms.required' => ' ',
        'rawData.check_out.policy.required' => ' ',
        'rawData.check_out.terms.accepted' => ' ',
        'rawData.check_out.policy.accepted' => ' ',
    ];


    public $carsData = [];
    public $buyOptions = [];
    public $handlePriceForEachCar = [];
    public $additionalServicesData = [];
    public $additionalEquipmentData = [];

    public $pretGarantie = 0;
    public $checkoutPrice = 0;
    public $nrZileDeInchiriere = 0;

    public $selectedCar = null;

    public $showDateError = false;
    public $serviceIsSelected = false;

    protected $listeners = ['changeSection'];

    public function boot()
    {

        if (Auth::check()) {
            $this->rawData['check_out']['name'] = Auth::user()->name ?? '';
            $this->rawData['check_out']['first_name'] = Auth::user()->first_name ?? '';
            $this->rawData['check_out']['company_name'] = Auth::user()->company_name ?? '';
            $this->rawData['check_out']['cui'] = Auth::user()->cui ?? '';
            $this->rawData['check_out']['contry_region'] = Auth::user()->contry_region ?? '';
            $this->rawData['check_out']['complete_address'] = Auth::user()->complete_address ?? '';
            $this->rawData['check_out']['phone'] = Auth::user()->phone ?? '';
            $this->rawData['check_out']['email'] = Auth::user()->email ?? '';
        }

        if (Cookie::has('step')) {
            $this->step = (int) Cookie::get('step');
        } else {
            $this->resetStepAndSetCookie();
        }

        if (Cookie::has('options')) {
            $this->jsonArr = json_decode(Cookie::get('options'), true);

            $rent_date = $this->jsonArr['rent_date'];

            if (!empty($rent_date)) {
                $this->rawData['rent_date'] = $rent_date;
            }

            $order = $this->jsonArr['order'] ?? null;

            if (!empty($order)) {
                $this->buyOptions = $order;
                $this->pretGarantie = $order['garantie']['pret'] ?? 0;
                $this->calculateTotal();
            }

            $car = $this->jsonArr['selectedCar'] ?? null;

            if (!empty($car)) {
                $this->selectedCar = $car;
            }

            $checkoutData = $this->jsonArr['checkout_form'] ?? null;

            if (!empty($checkoutData)) {
                $this->rawData['check_out'] = $checkoutData;
            }

            $priceForEachCar = $this->jsonArr['handlePriceForEachCar'] ?? null;

            if (!empty($checkpriceForEachCaroutData)) {
                $this->handlePriceForEachCar = $priceForEachCar;
            }
        } else {
            $this->resetStepAndSetCookie();
        }

        $this->takeCarSpecification();
        $this->takeAdditionalEquipment();
        $this->takeAdditionalServices();
    }

    private function resetStepAndSetCookie()
    {
        $this->reset('step');
        $this->setCookieStep($this->step);
    }

    public function mount()
    {
        if ($this->step === 2) { // metoda mount se apeleaza la randarea componentei asa ca setez in true daca conditia se face la refesh deoarece la refresh livewire-ul pierde state-ul
            $this->showCompleteTheOrderBtn();
        }
        $this->reset('showDateError');
    }

    private $carsRentPrices = [];

    private function takeCarSpecification()
    {
        $dbCars = CarSpecification::select(['id', 'nume', 'nr_inmatriculare', 'garantie', 'cod_produs', 'path', 'pret', 'options'])->where('display', true)->get()->toArray();

        $carIds = [];
        $arr = [];
        foreach ($dbCars ?? [] as $car) {

            $optionsArr = [];
            $options = json_decode($car['options'], true) ?? [];

            foreach ($options as $value) {
                $optionsArr[$value['nume']] = $value['descriere'];
            }

            if (!empty($optionsArr)) {
                ksort($optionsArr);
            }

            $prices = json_decode($car['pret'], true) ?? [];
            $this->carsRentPrices[$car['cod_produs']] = $prices;

            $arr[$car['cod_produs']] = [
                'nume' => $car['nume'],
                'code' => $car['cod_produs'],
                'garantie' => $car['garantie'],
                'pret' => (float) reset($prices), // pentru a lua prima valoare din array
                'isSelected' => isset($this->jsonArr['selectedCar']['code']) && ($this->jsonArr['selectedCar']['code'] === $car['cod_produs']),
                'options' => $optionsArr,
                'image' => $car['path'],
            ];

            $carIds[$car['cod_produs']] = $car['id'];
        }

        $this->carIds = $carIds;
        $this->calculeazaNrDeZile($this->carsRentPrices);
        $this->carsData = $arr;
    }

    public $pretZiPerCode = [];

    private function calculeazaNrDeZile(array $preturi)
    {
        $this->seteazaNrDeZile();

        $arr = [];

        foreach ($preturi ?? [] as $code => $value) {
            foreach ($value ?? [] as $zile => $pret) {
                if ($this->nrZileDeInchiriere >= $zile) {
                    $this->pretZiPerCode[$code] = $pret;
                    if ($this->nrZileDeInchiriere === 0) {
                        $arr[$code] = (float) $pret;
                    } else {
                        $arr[$code] = (float) $pret * $this->nrZileDeInchiriere;
                    }
                }
            }
        }

        $this->jsonArr['handlePriceForEachCar'] = $arr;
        $this->setCookieOptions($this->jsonArr);

        $this->handlePriceForEachCar = $arr;

        return $arr;
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

        $this->aditionalEquipmentIds = $aditionalEquipmentIds;
        $this->additionalEquipmentData = $arr;
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

        if (!$this->additionalServicesData) {
            foreach ($this->jsonArr['selectedServices'] ?? [] as $key => $value) {
                $this->additionalServicesData[$key]['services'][$value]['isSelected'] = true;
            }
        }
    }

    private function handleBuyOptions()
    {
        $value_a = $this->buyOptions[$this->selectedCar['code']];
        $value_b = $this->buyOptions['garantie'];

        unset($this->buyOptions[$this->selectedCar['code']]);
        unset($this->buyOptions['garantie']);

        $this->buyOptions = array_merge([
            $this->selectedCar['code'] => $value_a,
            'garantie' => $value_b,
        ], $this->buyOptions);

        $this->jsonArr['order'] = $this->buyOptions;
        $this->setCookieOptions($this->jsonArr);
    }

    public function changeSection(int $value, $hasFirstStepReValidation = true)
    {

        $this->reset('showDateError');

        if ($value <= $this->step) {
            $this->setCookieStep($value);
        }

        if ((bool) $hasFirstStepReValidation) { // acest if este pus pentru a nu mai da trigger la validare cand se trece de la step-ul 4 la 0
            switch ($this->step) {
                case 0:
                    $this->calculeazaNrDeZile($this->carsRentPrices);
                    $this->handleSectionValidation($this->rent_date_rules, $value);
                    return;

                case 1:
                    $this->showCompleteTheOrderBtn();
                    $this->setCookieStep($value);
                    return;

                case 2:
                    $this->handleBuyOptions();
                    $this->showCompleteTheOrderBtn();
                    $this->calculateTotal();
                    $this->setCookieStep($value);
                    return;

                case 3:
                    return $this->handleSectionValidation($this->check_out_rules, $value);

                default:
                    // if ($value === 4) {
                    //     // dd($value, $this->buyOptions);
                    //     return;
                    // }
                    // $this->setCookieStep($value);
                    return;
            }
        }
    }

    private function showCompleteTheOrderBtn()
    {
        if (count($this->jsonArr['selectedServices'] ?? []) === count($this->additionalServicesData)) {
            $this->serviceIsSelected = true;
        }
    }

    public function choseCar(string $code, string $name, string $imagePath)
    {
        $previousSelectedCarCode = $this->jsonArr['selectedCar']['code'] ?? null;
        
        $this->selectedCar = [
            'id' => $this->carIds[$code],
            'name' => $name,
            'code' => $code,
            'path' => $imagePath,
        ];
        
        $this->jsonArr['selectedCar'] = $this->selectedCar;

        $this->setCookieOptions($this->jsonArr);

        if (!empty($previousSelectedCarCode) && isset($this->carsData[$previousSelectedCarCode])) {
            $this->carsData[$previousSelectedCarCode]['isSelected'] = false;
        }

        $this->pretGarantie = $this->carsData[$code]['garantie'];
        $this->carsData[$code]['isSelected'] = true;

        $nume = $this->carsData[$code]['nume'];
        $pret = (float) $this->calculeazaNrDeZile($this->carsRentPrices)[$code];

        foreach ($this->carsData as $value) {
            if ($value['isSelected'] === false) {
                unset($this->buyOptions[$value['code']]);
            }
        }

        $arr[$code] = [
            'nume' => $nume,
            'pret' => $pret,
            'showPriceDetails' => true,
        ];

        $arr['garantie'] = [
            'nume' => 'Garantie',
            'pret' => $this->pretGarantie,
        ];

        $this->buyOptions = array_merge($this->buyOptions, $arr);
        $this->buyOptions = array_unique($this->buyOptions, SORT_REGULAR);

        $this->jsonArr['order'] = $this->buyOptions;
        $this->setCookieOptions($this->jsonArr);
        $this->changeSection(2);
    }

    private function calculateTotal()
    {
        $totalPrice = 0;
        foreach ($this->buyOptions as $item) {
            $totalPrice += (float) $item['pret'];
        }
        $this->checkoutPrice = $totalPrice;
    }

    public function choseAdditionalEquipment($code)
    {

        if (count($this->additionalServicesData) === 0) {
            $this->serviceIsSelected = true;
        }

        $this->jsonArr['selectedEquipment'][$code] = !$this->additionalEquipmentData[$code]['isSelected'];
        $this->setCookieOptions($this->jsonArr);

        $this->additionalEquipmentData[$code]['isSelected'] = !$this->additionalEquipmentData[$code]['isSelected'];

        if (!$this->additionalEquipmentData[$code]['isSelected']) {
            unset($this->buyOptions[$code]);
            return;
        }

        $nume = $this->additionalEquipmentData[$code]['nume'];
        $pret = (float) $this->additionalEquipmentData[$code]['pret'];

        $arr[$code] = ['nume' => $nume, 'pret' => $pret];

        if (empty($this->buyOptions)) {
            $this->buyOptions = $arr;
            return;
        }

        $this->buyOptions = array_merge($this->buyOptions, $arr);
        $this->buyOptions = array_unique($this->buyOptions, SORT_REGULAR);

        $this->jsonArr['order'] = $this->buyOptions;
        $this->setCookieOptions($this->jsonArr);
    }

    public function checkArray($array)
    {
        foreach ($array as $value) {
            if ($value !== true) {
                return false;
            }
        }
        return true;
    }

    public function choseAdditionalServices($row_code, $code)
    {

        $previousSelectedServiceCode = $this->jsonArr['selectedServices'][$row_code] ?? null;

        $this->jsonArr['selectedServices'][$row_code] = $code;

        $this->showCompleteTheOrderBtn();
        $this->setCookieOptions($this->jsonArr);

        if (!empty($previousSelectedServiceCode) && isset($this->additionalServicesData[$row_code]['services'][$previousSelectedServiceCode])) {
            $this->additionalServicesData[$row_code]['services'][$previousSelectedServiceCode]['isSelected'] = false;
        }

        $this->additionalServicesData[$row_code]['services'][$code]['isSelected'] = true;

        $comment = $this->additionalServicesData[$row_code]['services'][$code]['comment'];
        $pret = (float) $this->additionalServicesData[$row_code]['services'][$code]['pret'];

        if ((int) $pret === 0) {
            unset($this->buyOptions[$row_code]);
            return;
        }

        $arr[$row_code] = ['nume' => $comment, 'pret' => $this->additionalServicesData[$row_code]['services'][$code]['pret']];

        if (!$this->additionalServicesData[$row_code]['services'][$code]['isSelected']) {
            unset($this->buyOptions[$code]);
            return;
        }

        if (empty($this->buyOptions)) {
            $this->buyOptions = $arr;
            return;
        }

        $this->buyOptions = array_merge($this->buyOptions, $arr);
        $this->buyOptions = array_unique($this->buyOptions, SORT_REGULAR);

        $this->jsonArr['order'] = $this->buyOptions;
        $this->setCookieOptions($this->jsonArr);
    }

    private function seteazaNrDeZile()
    {
        $currentDate = Carbon::now()->format('Y-m-d H:i');

        $pickUpDate = $this->rawData['rent_date']['pickup_date'];
        $pickupTime = $this->rawData['rent_date']['pickup_time'];
        $returnDate = $this->rawData['rent_date']['return_date'];
        $returnTime = $this->rawData['rent_date']['return_time'];

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

        $dateTime1->addMinutes(45);

        $this->showDateError = $currentDateTime->gte($dateTime1) ? 'da' : 'nu';

        $this->nrZileDeInchiriere = $dateTime1->diffInDays($dateTime2) + 1;

        // dacă $dateTime1 nu este mai mic sau egal cu $dateTime2, atunci $this->showDateError va fi setată la true, altfel va fi setată la false
        // $dateTime1 <= dateTime2 && dateTime1 >= currentDateTime && dateTime2 >= currentDateTime
        $this->showDateError = !($dateTime1->lte($dateTime2) && $dateTime1->gte($currentDateTime) && $dateTime2->gte($currentDateTime)); 
    }

    public function updated(string $property): void
    {
        if (strpos($property, 'rawData') === false) {
            return;
        }

        switch ($this->step) { // pentu campurile care se actualizeaza
            case 0:
                $this->jsonArr['rent_date'] = $this->rawData['rent_date'];
                $this->setCookieOptions($this->jsonArr);
                break;

            case 3:
                $checkOut = $this->rawData['check_out'];
                unset($checkOut['password']);
                unset($checkOut['confirm_password']);
                $this->jsonArr['checkout_form'] = $checkOut;
                $this->setCookieOptions($this->jsonArr);
                break;
        }

        $this->handleValidateOnlyProperty($property);
    }

    private function handleValidateOnlyProperty(string $property)
    {
        switch ($this->step) {
            case 0:
                $this->validateOnly($property, $this->rent_date_rules);
                break;

            case 3:
                $this->validateOnly($property, $this->check_out_rules);
                break;

            default:
                dd('Eroare la validarea input-ului, contacteaza echipa de suport!');
                break;
        }
    }

    private function handleCheckoutOrder()
    {

        $rent_date = $this->rawData['rent_date'];

        [
            'location' => $location,
            'pickup_date' => $pickup_date,
            'return_date' => $return_date,
            'pickup_time' => $pickup_time,
            'return_time' => $return_time,
        ] = $rent_date;

        $arr = [];

        $selectedServicesIds = [];
        foreach ($this->jsonArr['selectedServices'] ?? [] as $key => $value) {
            if ($value) {
                $selectedServicesIds[] = $this->aditionalServicesIds[$key];
            }
        }

        $selectedServicesIdsJson = json_encode($selectedServicesIds);

        $selectedEquipmentIds = [];
        foreach ($this->jsonArr['selectedEquipment'] ?? [] as $key => $value) {
            if ($value) {
                $selectedEquipmentIds[] = $this->aditionalEquipmentIds[$key];
            }
        }

        $selectedEquipmentIdsJson = json_encode($selectedEquipmentIds);

        if (Auth::check()) {
            $arr['user_id'] = Auth::id();
        } else {
            $arr['user_id'] = 0;
        }

        $arr['car_id'] = $this->jsonArr['selectedCar']['id'];
        $arr['aditional_services_ids'] = $selectedServicesIdsJson;
        $arr['aditional_equipment_ids'] = $selectedEquipmentIdsJson;

        $arr['location'] = $location;
        $arr['return_date'] = $return_date;
        $arr['return_time'] = $return_time;
        $arr['pick_up_date'] = $pickup_date;
        $arr['pick_up_time'] = $pickup_time;
        $arr['price'] = (float) $this->checkoutPrice;
        $arr['nr_of_days'] = $this->nrZileDeInchiriere;
        $arr['status'] = false;
        $arr['addition_drivers'] = json_encode([]);

        // dd($arr, $selectedServicesIds, $selectedEquipmentIds, $this->jsonArr, $this->carIds, $this->aditionalServicesIds, $this->aditionalEquipmentIds);
        // dd($this->rawData, $this->carsData, $this->buyOptions, CheckoutOrder::all()->toArray());

        CheckoutOrder::create($arr);
    }

    private function handleSectionValidation(array $rules, int $value)
    {
        if ($this->hasValidationErrors($rules)) {
            $this->validate($rules);
        } else {
            if ($value === 4) { // am pus acest if pentru a reseta datele utilizatroului atunci cand ajunge in step 4
                $this->handleCheckoutOrder();
                $this->setCookieStep($value);
                $this->reset('rawData');
                Cookie::queue(Cookie::forget('options'));
            }

            if ($value < 4) {
                $this->seteazaNrDeZile();
                if (!$this->showDateError) {
                    $this->setCookieStep($value);
                }
            }
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

    private function setCookieStep(int $value): void
    {
        if (!$value || !is_numeric($value) || $value === 0) {
            $this->reset('step');
        } else {
            $this->step = $value;
        }

        $this->setCookie('step', $this->step);
    }

    private function setCookieOptions($value): void
    {
        $this->setCookie('options', json_encode($value));
    }

    private function setCookie(string $key, int|string|null $value, int $expires = 60): void
    {
        Cookie::queue($key, $value, $expires);
    }

    public function render(): View
    {
        return view('livewire.pages.guest.rent-car');
    }
}
