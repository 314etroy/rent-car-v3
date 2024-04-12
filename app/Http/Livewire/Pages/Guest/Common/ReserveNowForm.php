<?php

namespace App\Http\Livewire\Pages\Guest\Common;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class ReserveNowForm extends Component
{

    private $jsonArr = [
        'rent_date' => [],
    ];

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

    protected $messages = [
        'rawData.rent_date.location.required' => 'este necesar',
        'rawData.rent_date.return_to_another_location.required' => 'este necesar',
        'rawData.rent_date.pickup_date.required' => 'este necesar',
        'rawData.rent_date.return_date.required' => 'este necesar',
        'rawData.rent_date.pickup_time.required' => 'este necesar',
        'rawData.rent_date.return_time.required' => 'este necesar',
    ];

    public $showDateError = false;

    public function boot()
    {
        if (Cookie::has('options')) {
            $rawDataJsonArr = json_decode(Cookie::get('options'), true);
            $this->jsonArr['rent_date'] = $rawDataJsonArr['rent_date'];
            if (!empty($this->jsonArr['rent_date'])) {
                $this->rawData['rent_date'] = $this->jsonArr['rent_date'];
            } else {
                $this->reset('rawData');
            }
        }

        $this->setCookieStep(0);
    }

    private function setCookieOptions($value): void
    {
        $this->setCookie('options', json_encode($value));
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

        $this->showDateError = !($dateTime1->lte($dateTime2) && $dateTime1->gte($currentDateTime) && $dateTime2->gte($currentDateTime));

        if (!$this->showDateError) {
            $dateTime1->addMinutes(45);
            // dacă $dateTime1 nu este mai mic sau egal cu $dateTime2, atunci $this->showDateError va fi setată la true, altfel va fi setată la false
            // $dateTime1 <= dateTime2 && dateTime1 >= currentDateTime && dateTime2 >= currentDateTime
            $this->showDateError = !($dateTime1->lte($dateTime2) && $dateTime1->gte($currentDateTime) && $dateTime2->gte($currentDateTime));
        }
    }

    public function changeSection(int $value)
    {

        if ($value !== 1) {
            return;
        }

        $this->handleSectionValidation($this->rent_date_rules, $value);

        $this->seteazaNrDeZile();

        if (!$this->showDateError) {
            return redirect()->route('reserve_now');
        }
    }

    private function setCookieStep(int $value): void
    {
        $this->setCookie('step', $value);
    }

    private function setCookie(string $key, int|string|null $value, int $expires = 60): void
    {
        Cookie::queue($key, $value, $expires);
    }

    private function handleSectionValidation(array $rules, int $value)
    {
        if ($this->hasValidationErrors($rules)) {
            $this->validate($rules);
        } else {
            $this->setCookieStep($value);
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

    public function updated(string $property): void
    {
        if (strpos($property, 'rawData') === false) {
            return;
        }

        $this->setCookieOptions($this->rawData);

        $this->handleValidateOnlyProperty($property);
    }

    private function handleValidateOnlyProperty(string $property)
    {
        if (empty($property)) {
            dd('Eroare la validarea input-ului, contacteaza echipa de suport!');
        }

        return $this->validateOnly($property, $this->rent_date_rules);
    }

    public function render(): View
    {
        return view('livewire.pages.guest.common.reserve-now-form');
    }
}
