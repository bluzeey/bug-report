<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Laravel\Paddle\Checkout;

class PaddleController extends Controller
{
    public function showBilling(): \Inertia\Response
    {

        $productId = config('cashier.product_id');
        $proPriceId = config('cashier.pro_price_id');
        $proPlusPriceId = config('cashier.pro_plus_price_id');



        return Inertia::render('Billing', [
            'productId' => $productId,
            'proPriceId' => $proPriceId,
            'proPlusPriceId' => $proPlusPriceId,
        ]);
    }

    public function checkout(Request $request,$priceId)
    {
        // If your checkout requires auth user
        // Replace this with Auth::user()->checkout($priceId)->returnTo(route('dashboard'))
        $user= auth()->user();

        $checkout = auth()->user()->checkout($priceId)->returnTo(route('dashboard'));

        $checkout = [
            'items' => $checkout->getItems(),
            'custom' => $checkout->getCustomData(),
            'return_url' => $checkout->getReturnUrl(),
        ];

        return \response()->json($checkout);
    }

    public function subscriptionSwap(Request $request, $priceId): \Illuminate\Http\RedirectResponse
    {
        $request->user()->subscription()->swap($priceId);

        return redirect()->route('dashboard');
    }

    public function subscriptionCancel(Request $request)
    {
        $request->user()->subscription()->cancel();

        return redirect()->route('dashboard');
    }
}
