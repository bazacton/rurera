<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Http\Request;
use App\User;
use Log;

class WebhookController extends CashierController
{
    /**
     * Handle an invoice payment succeeded event.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        switch ($payload['type']) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($payload['data']['object']);
                break;
				
			case 'invoice.payment_succeeded':
                $this->handleInvoicePaymentSucceeded($payload['data']['object']);
                break;
            // Add other event types you want to handle
        }

        return response('Webhook handled', 200);
    }
	
	protected function handleCheckoutSessionCompleted($session)
    {
        $user = User::where('stripe_id', $session['customer'])->first();

        if ($user) {
            // Create or update the subscription in your local database
            $user->subscriptions()->updateOrCreate(
                ['stripe_id' => $session['subscription']],
                [
                    'name' => 'default',
                    'stripe_status' => 'active',
                    'stripe_price' => 0,
                    'quantity' => 1,
                    'trial_ends_at' => 0,
                    'ends_at' => null,
                ]
            );
        }
    }
	
    public function handleInvoicePaymentSucceeded(array $payload)
    {
        $invoice = $payload;
        $user = \App\Models\User::where('stripe_id', $invoice['customer'])->first();

        if ($user) {
            // Update the user's subscription status
            $subscription = $user->subscriptions()->where('stripe_id', $invoice['subscription'])->first();

            if ($subscription) {
                $subscription->update([
                    'stripe_status' => 'active',
                ]);

                // You might want to log or perform other actions here
            }
        }

        return $this->successMethod();
    }
}
