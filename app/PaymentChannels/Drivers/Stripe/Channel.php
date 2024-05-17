<?php

namespace App\PaymentChannels\Drivers\Stripe;

use App\Models\Order;
use App\Models\PaymentChannel;
use App\PaymentChannels\IChannel;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Subscription;
use Stripe\Coupon;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\SetupIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use App\User;

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

    public function orderPaymentRequest(Order $order)
    {
        Stripe::setApiKey($this->api_secret);


        $SetupIntent = SetupIntent::create(['payment_method_types' => ['card']]);
        $output = [
            'clientSecret' => $SetupIntent->client_secret,
        ];
        return $output;


        /*$paymentIntent = PaymentIntent::create([
            'customer' => 'CUSTOMER_ID', // Optionally, if you have a customer
            'payment_method_types' => ['card'],
            'amount' => 1000, // Optionally, specify the amount (in cents) for the first invoice
            'currency' => 'usd', // Specify the currency
            'description' => 'Subscription Payment', // Optional description
            'confirm' => true, // Confirm the PaymentIntent immediately
            'confirmation_method' => 'automatic', // Confirmation method
            'setup_future_usage' => 'off_session', // Usage beyond this payment
            'application_fee_amount' => 0, // Optional application fee
            'metadata' => ['key' => 'value'], // Optional metadata
            'statement_descriptor' => 'Custom Descriptor', // Optional statement descriptor
            'receipt_email' => 'customer@example.com', // Optional receipt email
            'payment_method' => 'pm_card_visa', // Optionally, if you have a saved payment method
            'off_session' => true, // Or set to false if you need it to be on session
            'confirm' => true, // Confirm the PaymentIntent immediately
            'payment_method_options' => [
                'card' => [
                    'request_three_d_secure' => 'automatic'
                ]
            ],
            'subscription_data' => [
                'items' => [
                    [
                        'price' => 'price_1PBYlqFe1936RR55VNrE7Nf6',
                        'quantity' => 1,
                    ]
                ]
            ],
        ]);

        pre($paymentIntent);*/

        $checkout = Session::create([
           //'customer' => 'cus_Q1d4rL1mnBYViz',//$customer->id,
          'line_items' => [
            [
              'price' => 'price_1PEYLnFe1936RR55Euqi8htC',//'price_1PBYlqFe1936RR55VNrE7Nf6',
              'quantity' => 1,
            ],
          ],
           'discounts' => [],
           'subscription_data' => [],
           'mode' => 'payment',
           'ui_mode' => 'embedded',
           'return_url' => $this->makeCallbackUrl('success'),
           //'success_url' => $this->makeCallbackUrl('success'),
           //'cancel_url' => $this->makeCallbackUrl('cancel'),
        ]);
        $checkoutSession = Session::retrieve($checkout->id);
        $client_secret = $checkoutSession->client_secret;

        // Now retrieve the PaymentIntent
        //$paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        $output = [
            'clientSecret' => $client_secret,
        ];
        return $output;
    }

    public function paymentRequest(Order $order)
    {
        $user = getUser();
        $price = $order->total_amount;
        $generalSettings = getGeneralSettings();
		$student_id = $order->student_id;
		$studentObj = User::find($student_id);
        $currency = currency();
        $currency = 'USD';
        $payment_data = isset( $order->payment_data )? json_decode($order->payment_data) : (object) array();
        $remaining_days  = isset( $payment_data->remaining_days )? $payment_data->remaining_days : 30;
        $discount_amount = isset( $payment_data->discount_amount )? $payment_data->discount_amount : 0;
		$subscribe_for  = isset( $payment_data->subscribe_for )? $payment_data->subscribe_for : 1;
		$package_price_id = ($subscribe_for > 1)? $order->package->stripe_price_yearly : $order->package->stripe_price_monthly;
		
		//pre($payment_data, false);
		//pre($order);
		
		


        Stripe::setApiKey($this->api_secret);
        $subscribed_childs = $user->parentChilds->where('status', 'active')->sum(function ($child) {
            return isset( $child->user->userSubscriptions->id) ? 1 : 0;
        });
		$trial_days = 0;

        $subscription_data = array();

        if( $subscribed_childs == 0){
            $subscription_data['trial_period_days'] = 7;
			$trial_days = 7;
            //$subscription_data['billing_cycle_anchor'] = strtotime('+30 days');
        }else{
            //$subscription_data['trial_period_days'] = 0;
            //$subscription_data['billing_cycle_anchor'] = strtotime('+'.$remaining_days.' days');
        }
		$trial_days = 2;


        /*try {

        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getError();
            echo "Card error: " . $error->message;
            pre('--testing33');
        }*/




        try {
			
			if( $discount_amount > 0){
			   $couponObj = Coupon::create([
				  'amount_off' => ($discount_amount*100),
				  'duration' => 'once',
				  'currency' => 'gbp',
			   ]);
			}
			
			$stripeCustomer = $studentObj->createOrGetStripeCustomer();
			$checkout = $studentObj->newSubscription('default', $package_price_id);
			if( $trial_days > 0){
				$checkout = $checkout->trialDays($trial_days);
			}
			if( $discount_amount > 0){
				$checkout = $checkout->withCoupon($couponObj->id);
			}
			$checkout = $checkout->checkout([
				'success_url' => $this->makeCallbackUrl('success'),
				'cancel_url' => $this->makeCallbackUrl('cancel'),
			]);
			
			pre($checkout);
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
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


            /*$discounts_data = [];
            if( $discount_amount > 0){
                   $couponObj = Coupon::create([
                      'amount_off' => ($discount_amount*100),
                      'duration' => 'once',
                      'currency' => 'cad',
                   ]);
                   $discounts_data = [['coupon' => $couponObj->id]];
               }
            $checkout = Session::create([
              'line_items' => [
                [
                  'price' => 'price_1PBYlqFe1936RR55VNrE7Nf6',
                  'quantity' => 1,
                ],
              ],
               'discounts' => $discounts_data,
               'subscription_data' => $subscription_data,
               'mode' => 'subscription',
               'success_url' => $this->makeCallbackUrl('success'),
               'cancel_url' => $this->makeCallbackUrl('cancel'),
            ]);*/

            // Optionally, you can do something with the checkout session object returned
            $sessionId = $checkout->id;

        } catch (\Stripe\Exception\ApiErrorException $e) {
            pre($e->getMessage());
            // Handle error
            echo 'Error: ' . $e->getMessage();
        }



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
