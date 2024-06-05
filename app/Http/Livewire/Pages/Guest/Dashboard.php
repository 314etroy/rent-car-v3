<?php

namespace App\Http\Livewire\Pages\Guest;

use App\Models\User;
use Livewire\Component;
use App\Models\CheckoutOrder;
use App\Models\CarSpecification;
use App\Models\AdditionalService;
use App\Models\AdditionalEquipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Dashboard extends Component
{

    public $tableData = [];
    public $input = [];
    public $dbAdditionalDriver = [];
    private $userData = [];

    protected $listeners = [
        'refreshCompnent',
    ];

    public function boot()
    {
        $this->getUserDashboardData();
    }

    public function refreshCompnent(string $orderId)
    {

        $userData = User::where('id', $this->userData[$orderId])->select('name', 'first_name', 'email')->first()->toArray();

        [
            'pickUpDateTime' => $pickUpDateTime,
            'returnDateTime' => $returnDateTime,
            'nrInmatriculare' => $nrInmatriculare,
            'location' => $location,
            'nrOfDays' => $nrOfDays,
            'carName' => $carName,
            'price' => $price,
        ] = $this->tableData[$orderId] ?? [];

        $emailDetails = [
            'nameSiPrenume' => $userData['name'] . ' ' . $userData['first_name'],
            'email' => $userData['email'],
            'car_name' => $carName,
            'car_number' => $nrInmatriculare,
            'pick_up_dateTime' => $pickUpDateTime,
            'return_dateTime' => $returnDateTime,
            'nr_of_days' => $nrOfDays,
            'price' => (float) $price,
            'location' => ucfirst($location),
            'order_id' => $orderId,
        ];

        $this->handleEmailSubmit(env('MAIL_TO'), $emailDetails);
        $this->handleEmailSubmit($userData['email'], $emailDetails);

        $this->getUserDashboardData();
    }

    private function handleEmailSubmit(string $emailTo, array $emailDetails)
    {
        Mail::send('emails.cancelOrder', ['details' => $emailDetails], function ($message) use ($emailTo, $emailDetails) {
            $message->from('no-replay@site.ro')->to($emailTo)->subject('CheckOut: ' . $emailDetails['nameSiPrenume']);
        });
    }

    public function handleAdditionalDriver($orderId)
    {
        CheckoutOrder::where('order_id', '=', $orderId)->update(['additional_driver_name' => $this->input[$orderId]]);
        $this->refreshCompnent($orderId);
    }

    private function getUserDashboardData()
    {
        $checkoutOrder = CheckoutOrder::where('user_id', Auth::id())->orderByRaw('deleted_at IS NOT NULL')->orderBy('created_at', 'desc')->withTrashed()->get()->toArray();

        $arr = [];
        $checkOutData = [];

        foreach ($checkoutOrder ?? [] as $value) {
            $this->userData[$value['order_id']] = $value['user_id'];
            
            $arr['pickUpDateTime'] = specificYearMonthDayHourAndMinute($value['pick_up_dateTime']);
            $arr['returnDateTime'] = specificYearMonthDayHourAndMinute($value['return_dateTime']);
            $arr['nrOfDays'] = $value['nr_of_days'];
            $arr['price'] = (float) $value['price'];
            $arr['pricePerDay'] = $value['price_per_day'];
            $arr['location'] = $value['location'];
            $arr['codeId'] = $value['order_id'];
            $arr['status'] = $value['status'];
            $arr['additionalDriver'] = (bool) $value['additional_driver'];
            $arr['isDeletedOrder'] = $value['deleted_at'] !== null;
            $arr['created_at'] = $value['created_at'];

            $carSpecification = CarSpecification::where('id', $value['car_id'])->first()->toArray();
            $arr['carName'] = $carSpecification['nume'];
            $arr['nrInmatriculare'] = $carSpecification['nr_inmatriculare'];
            $arr['garantie'] = (float) $carSpecification['garantie'];
            $arr['carImage'] = $carSpecification['path'];

            $this->input[$value['order_id']] = $value['additional_driver_name'];
            $this->dbAdditionalDriver[$value['order_id']] = $value['additional_driver_name'];

            $aditionalEquipmentIds = json_decode($value['aditional_equipment_ids'], true);
            $aditionalEquipments = AdditionalEquipment::whereIn('id', $aditionalEquipmentIds)->get()->toArray();

            $equipmentArr = [];
            foreach ($aditionalEquipments ?? [] as $equipment) {
                $equipmentArr[] =  [
                    'name' => $equipment['nume'],
                    'price' => (float) $equipment['pret'],
                ];
            }

            $arr['aditionalEquipments'] = $equipmentArr;

            $aditionalServicesJsonData = json_decode($value['aditional_services_ids'], true);

            $aditionalServicesData = [];
            foreach ($aditionalServicesJsonData as $subArray) {
                foreach ($subArray as $key => $value) {
                    $aditionalServicesData[$key] = $value;
                }
            }

            $aditionalServicesKeys = array_keys($aditionalServicesData);
            $aditionalServices = AdditionalService::whereIn('id', $aditionalServicesKeys)->get()->toArray();

            $serviceArr = [];
            foreach ($aditionalServices ?? [] as $service) {
                $serviceJson = json_decode($service['services'], true);
                $nestedData = $serviceJson[$aditionalServicesData[$service['id']]];

                $serviceArr[] =  [
                    'name' => $service['nume'],
                    'comment' => $nestedData['comment'],
                    'price' => (float) $nestedData['pret'],
                ];
            }

            $arr['aditionalServices'] = $serviceArr;
            $checkOutData[$arr['codeId']] = $arr;            
        }
        
        $this->tableData = $checkOutData;
    }

    public function render()
    {
        return view('livewire.pages.guest.dashboard');
    }
}
