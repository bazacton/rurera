<?php

namespace App\PaymentChannels\Drivers\Stripe;

use App\Models\Order;
use App\Models\PaymentChannel;
use App\PaymentChannels\IChannel;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Subscription;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class Channel implements IChannel
{
    protected $currency;
    protected $api_key;
    protected $api_secret;
    protected $order_session_key;

    /**
     * Channel constructor.
     * @param PaymentChannel $paymentChannel
     */
    public function __construct(PaymentChannel $paymentChannel)
    {
        $this->currency = currency();
        $this->api_key = env('STRIPE_KEY');
        $this->api_secret = env('STRIPE_SECRET');

        $this->order_session_key = 'strip.payments.order_id';
    }

    public function paymentRequest(Order $order)
    {
        $user = getUser();
        $price = $order->total_amount;
        $generalSettings = getGeneralSettings();
        $currency = currency();
        $currency = 'USD';

        Stripe::setApiKey($this->api_secret);
        $subscribed_childs = $user->parentChilds->where('status', 'active')->sum(function ($child) {
            return isset( $child->user->userSubscriptions->id) ? 1 : 0;
        });

        $subscription_data = array();
        //$subscription_data['billing_cycle_anchor'] = strtotime('+30 days');
        if( $subscribed_childs > 0){
            //$subscription_data['trial_period_days'] = 7;
            $subscription_data['billing_cycle_anchor'] = strtotime('+30 days');
        }


        /*try {

        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getError();
            echo "Card error: " . $error->message;
            pre('--testing33');
        }*/




        try {
            // Step 1: Create a customer
            /*$customer = Customer::create([
                'email' => 'baz.chimpstudio1@gmail.com', // Replace with the customer's email
                // You can add more optional parameters here, such as name, address, etc.
            ]);

            // Step 2: Create a subscription for the customer
            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    [
                        'price' => 'price_1PBYlqFe1936RR55VNrE7Nf6', // Replace with your subscription price ID
                    ],
                ],
                'trial_period_days' => 7, // Replace with the number of trial days you want to offer
                'billing_cycle_anchor' => time() + (37 * 24 * 3600), // Start billing 37 days from now
                // Optional parameters can be added here
            ]);
            
            pre($subscription);*/

            // Step 3: Create a checkout session
            $checkout = Session::create([
               //'customer' => 'cus_Q1d4rL1mnBYViz',//$customer->id,
              'line_items' => [
                [
                  'price' => 'price_1PBYlqFe1936RR55VNrE7Nf6',
                  'quantity' => 1,
                ],
              ],
               'subscription_data' => $subscription_data,
                'mode' => 'subscription',
                'success_url' => $this->makeCallbackUrl('success'),
                'cancel_url' => $this->makeCallbackUrl('cancel'),
            ]);

            // Optionally, you can do something with the checkout session object returned
            $sessionId = $checkout->id;

            session()->put($this->order_session_key, $order->id);

            $Html = '<script src="https://js.stripe.com/v3/"></script>';
            $Html .= '<script type="text/javascript">let stripe = Stripe("' . $this->api_key . '");';
            $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';

            echo $Html;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error
            echo 'Error: ' . $e->getMessage();
        }
        exit;
























        try {
            $subscription = Subscription::create([
                'customer' => 'cus_NKVfMJztmOk7s9',
                'items' => [
                    [
                        'price' => 'price_1PBYlqFe1936RR55VNrE7Nf6', // Replace with the ID of your Stripe product price
                    ],
                ],
                'trial_period_days' => 7, // Replace with the number of trial days you want to offer
                'billing_cycle_anchor' => time() + (37 * 24 * 3600), // Start billing tomorrow
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
                // Optional parameters can be added here
            ]);

            // Optionally, you can do something with the subscription object returned
            $subscriptionID = $subscription->id;

            // Retrieve the payment intent to handle payment
            $paymentIntent = $subscription->latest_invoice->payment_intent;
            pre($subscription);

            // Redirect to the payment confirmation page
            //header("Location: /confirm_payment.php?payment_intent_id=" . $paymentIntent->id);
            //exit;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error
            echo 'Error: ' . $e->getMessage();
        }





        //pre('test');
        /*try {
            $checkout = Session::create([
                'payment_method_types' => ['card'],
                'line_items'           => [
                    [
                        'price_data' => [
                            'currency'            => $currency,
                            'unit_amount_decimal' => $price * 100,
                            'product_data'        => [
                                'name' => 'Rurera payment',
                            ],
                        ],
                        'quantity'   => 1,
                    ]
                ],
                'mode'                 => 'payment',
                'success_url'          => $this->makeCallbackUrl('success'),
                'cancel_url'           => $this->makeCallbackUrl('cancel'),
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo "Error: " . $e->getMessage();
            pre('---testing');
        }


        $order->update([
            'reference_id' => $checkout->id,
        ]);*/

        session()->put($this->order_session_key, $order->id);

        $Html = '<script src="https://js.stripe.com/v3/"></script>';
        $Html .= '<script type="text/javascript">let stripe = Stripe("' . $this->api_key . '");';
        $Html .= 'stripe.redirectToCheckout({ sessionId: "' . $checkout->id . '" }); </script>';

        echo $Html;
    }

    private function makeCallbackUrl($status)
    {
        return url("/payments/verify/Stripe?status=$status&session_id={CHECKOUT_SESSION_ID}");
    }

    public function verify(Request $request)
    {
        $data = $request->all();
        $status = $data['status'];

        $order_id = session()->get($this->order_session_key, null);
        session()->forget($this->order_session_key);

        $user = auth()->user();

        $order = Order::where('id', $order_id)
            ->where('user_id', $user->id)
            ->first();

        if ($status == 'success' and !empty($request->session_id) and !empty($order)) {
            Stripe::setApiKey($this->api_secret);

            $session = Session::retrieve($request->session_id);

            if (!empty($session) and $session->payment_status == 'paid') {
                $order->update([
                    'status' => Order::$paying
                ]);
                return $order;
            }
        }

        // is fail

        if (!empty($order)) {
            $order->update(['status' => Order::$fail]);
        }

        return $order;
    }
}
