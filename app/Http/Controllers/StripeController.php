<?php

namespace App\Http\Controllers;
use Session;
use Stripe;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\Stripe as StripeGateway;

// use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100*100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "This payment is testing purpose of techsolutionstuff",
        ]);
   
        Session::flash('success', 'Payment Successfull!');
           
        return back();
    }

    public function initiatePayment(Request $request)
    {
        StripeGateway::setApiKey('sk_test_51Mq90NSHdhhC06MMuEuuq4yi2gEAtWNzvefyrbSWF7MlOcCpr1SN7wjDdj83FwF914bJj8vnUfYGUgXGQC3eIbSx00iRocS4J2');

        try {
            $paymentIntent = PaymentIntent::create([
                'description' => 'Software development services',
                'shipping' => [
                  'name' => 'Jenny Rosen',
                  'address' => [
                    'line1' => '510 Townsend St',
                    'postal_code' => '98140',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'country' => 'US',
                  ],
                ],
                'amount' => $request->amount * 1, // Multiply as & when required
                'currency' => $request->currency,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            // Save the $paymentIntent->id to identify this payment later
            session()->put('variableName', $paymentIntent->id);
            // echo session()->get('variableName'); die;
        } catch (Exception $e) {
            // throw error
        }

        return [
            'token' => (string) Str::uuid(),
            'client_secret' => $paymentIntent->client_secret
        ];
    }

    public function completePayment(Request $request)
    {
        $stripe = new StripeClient('sk_test_51Mq90NSHdhhC06MMuEuuq4yi2gEAtWNzvefyrbSWF7MlOcCpr1SN7wjDdj83FwF914bJj8vnUfYGUgXGQC3eIbSx00iRocS4J2');

        $pid = session()->get('variableName');
        // echo $pid;
        // Use the payment intent ID stored when initiating payment
        // $paymentDetail = $stripe->paymentIntents->retrieve($pid);
        // var_dump($paymentDetail); die;
        // $paymentDetail = $stripe->paymentIntents->retrieve(
        //   $pid,
        //   []
        // );

        // if ($paymentDetail->status != 'succeeded') {
        //     // throw error
        // }

        // Complete the payment
    }

    public function failPayment(Request $request)
    {
        // Log the failed payment if you wish
    }
}