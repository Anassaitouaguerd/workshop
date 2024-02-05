<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SK')); 
        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $request->name,
                        ],
                        'unit_amount' => 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('index'),
        ]);
        // dd($session);
        return redirect()->away($session->url);
    }
    public function success()
    {
        return view('index');
    }
}
