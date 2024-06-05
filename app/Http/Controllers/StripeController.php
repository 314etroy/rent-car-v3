<?php

namespace App\Http\Controllers;

use App\Models\CheckoutOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Checkout;

class StripeController extends Controller
{
    protected $stripeKey = '';
    protected function connectStripe()
    {
        $stripe = new \Stripe\StripeClient(
            config('cashier.secret')
        );
        return $stripe;
    }
    public function charge(Request $request)
    {
        $stripe = new \Stripe\StripeClient(
            config('cashier.secret')
          );
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'ron',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' =>route('successPayment')."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('cancelPayment')."?session_id={CHECKOUT_SESSION_ID}",
        ]);

        return redirect($checkout_session->url);
    }
    public function successPayment(){
        $stripe = $this->connectStripe();
        $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
        if($session->payment_status == 'paid'){
            if($session->metadata->type == 'appointment'){

                $orderUpdate = DB::table('checkout_orders')->where('id', $session->metadata->appointment_id)->update(['status' => 0, 'deleted_at' => null]);
                $orderId = DB::table('checkout_orders')->where('id', $session->metadata->appointment_id)->first()->order_id;
                $chache_key = $orderId . '_mail';
                $mailFromCache = Cache::get($chache_key);

                $this->handleEmailSubmit(env('MAIL_TO'), $mailFromCache);
                $this->handleEmailSubmit($mailFromCache['email'], $mailFromCache);

                return redirect()->route('dashboard')->with('success', 'Plata a fost efectuata cu succes!');
            }
        }
    }
    public function cancelPayment(){
        $stripe = $this->connectStripe();
        $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
        if($session->metadata->type == 'appointment'){
            $orderUpdate = DB::table('checkout_orders')->where('id', $session->metadata->appointment_id)->update(['status' => 2]);
        }
        return redirect()->route('dashboard')->with('error', 'Plata a fost anulata!');
    }

    public function stripe($order_id){
        $decrypt = decrypt($order_id);
        $order = DB::table('checkout_orders')->where('order_id', $decrypt)->first();
        $stripe = $this->connectStripe();
        $checkout_session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => config('cashier.currency'),
                    'product_data' => [
                        'name' => 'Servicii Inchiere Auto',
                    ],
                    'unit_amount' => $order->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' =>route('successPayment')."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('cancelPayment')."?session_id={CHECKOUT_SESSION_ID}",
            'metadata' => [
                'appointment_id' => $order->id,
                'type' => 'appointment',
            ],
        ]);
        return redirect($checkout_session->url);
    }

    private function handleEmailSubmit(string $emailTo, array $emailDetails)
    {
        Mail::send('emails.checkout', ['details' => $emailDetails], function ($message) use ($emailTo, $emailDetails) {
            $message->from('no-replay@site.ro')->to($emailTo)->subject('CheckOut: ' . $emailDetails['nameSiPrenume']);
        });
    }

}

