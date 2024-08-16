<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Models\Transaction;
use App\Models\User;

use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payments.form');
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey('sk_test_51Po38pP3Qn1mHufqZuEJKPrwYeoo9B4peBDg5YdS6UEyaFXBjA4TTCHaEDg6sR3e4LRhdptgXyqdlRjOo2ZiXHql00kElzuZpC');

        // Retrieve or create Stripe customer
        $user = auth()->user();
        $stripeCustomerId = $user->stripe_customer_id;

        if (!$stripeCustomerId) {
            // Create a new Stripe customer
            $customer = Customer::create([
                'email' => $user->email,
            ]);

            // Save the customer ID in the user model for future use
            $user->stripe_customer_id = $customer->id;
            

            $stripeCustomerId = $customer->id;
        }

        // Attach the payment method (card) to the customer if provided
        $stripeToken = $request->input('stripeToken');
        if ($stripeToken) {
            $customer = Customer::retrieve($stripeCustomerId);
            $customer->sources->create(['source' => $stripeToken]);

            // Set this card as the default payment method
            $customer->default_source = $stripeToken;
            
        }

        try {

            // Charge the customer using their default payment method
            $charge = Charge::create([
                'customer' => $stripeCustomerId,
                'amount' => $request->amount * 100, // amount in cents
                'currency' => 'usd',
                'description' => 'Payment for Order ID: ' . $request->order_id,
            ]);

            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // amount in cents
                'currency' => 'usd',
                'payment_method' => $request->input('payment_method'),
                'confirm' => true,
                'description' => 'Payment for Order ID: '.$request->order_id,
                'receipt_email' => auth()->user()->email,
            ]);

            // Save transaction
            $transaction = new Transaction();
            $transaction->user_id = auth()->id();
            $transaction->amount = $request->amount;
            $transaction->status = 'success';
            $transaction->save();
            return redirect()->route('transactions.index')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Payment processing failed: ' . $e->getMessage());

            // Return the error message to the user
            return back()->with('error', 'Payment failed! ' . $e->getMessage());
        }
    }


}

