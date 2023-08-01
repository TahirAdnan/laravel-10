<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{

    // Stripe card info view
    public function stripe(Request $request)
    {
        return view('stripeCard')->with('price', $request->price);
    }

    // Stripe payment method
    public function stripePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $paymentIntent = Charge::create([
                'amount' => $request->price * 100,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'This payment is testing purpose of stripe',
            ]);
            // Payment successful, you can do further processing here
            // return redirect()->back()->with('success', 'Payment successful!');
            return redirect()->route('dashboard')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error' , 'Something went wrong');
        }
    }     

    //  Paypal payment method
    public function handlePayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('create.payment')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('dashboard')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    // Function to scrape Mepco bill information
    function getMepcoBill(Request $request)
    {
        // $consumerNumber="09154291243900";
        $consumerNumber = $request->refno;
        // URL for the Mepco bill inquiry
        $url = "https://checkmepcobill.pk/mepco-bill-summary/?refno=" . $consumerNumber.'&company=mepco';

        // Create a new cURL resource
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($ch);

        // // Close the cURL resource
        curl_close($ch);

        // Parse the HTML response to extract bill information
        $dom = new \DOMDocument();
        @$dom->loadHTML($response);

        // // Extract the required labels
        // $labels = $dom->getElementsByTagName('label');
        // $label_array = array();
        // foreach($labels as $label){
        //     $title_text = $label->textContent;
        //     $label_array[] = $title_text;
        //     echo $title_text.'<br>';
        // }

        // Extract the required values
        $xpath = new \DOMXpath($dom);
        $elements = $xpath->query('//*[@class="row"]');
        $element_array = array();
        foreach ($elements as $element) {
            $title_text2 = $element->textContent;
            $element_array[] = $title_text2;
            // echo $title_text2 . '<br>';
        }
        // var_dump($element_array); die;
        // return redirect(route('dashboard'))->with('element_array', $element_array);
        return view('dashboard')->with('Elements', $element_array);
    }


    
}
