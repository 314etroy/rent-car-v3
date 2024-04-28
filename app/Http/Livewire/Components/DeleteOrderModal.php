<?php

namespace App\Http\Livewire\Components;

use App\Models\CheckoutOrder;
use App\Http\Livewire\Common\Modal;
use Illuminate\Contracts\View\View;

class DeleteOrderModal extends Modal
{

    public $modalProps = [
        'id' => null,
        'operation' => null,
        'inhibModalClosure' => false,
    ];

    private function resetModalData()
    {
        $this->reset([
            'modalProps',
        ]);
    }

    public function closeModal()
    {
        $this->show = false;
        $this->resetModalData();
        $this->emitSelf('refreshModal');
    }

    protected function init(array $data): void
    {
        $this->resetModalData();

        empty($data) && exit;

        if ($data['operation'] === 'delete') {
            [
                'code' => $orderId,
                'price' => $price,
            ] = $data['rowData'];

            $this->modalProps['rowData']['orderId'] = $orderId;
        }

        $this->modalProps['operation'] = $data['operation'];
        $this->modalProps['price'] = $price;
        $this->modalProps['inhibModalClosure'] = $data['inhibModalClosure'];
    }

    public function delete(): void
    {
        [
            'orderId' => $orderId,
        ] = $this->modalProps['rowData'];

        empty($orderId) && exit;

        CheckoutOrder::where('order_id', '=', $orderId)->delete();

        $this->closeModal();
        $this->emitTo('pages.guest.dashboard', 'refreshCompnent', $orderId);
    }

    public function render(): View
    {
        return view('livewire.components.delete-order-modal');
    }
}
