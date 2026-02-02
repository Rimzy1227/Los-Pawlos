<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)){
            return redirect()->route('products.index')->with('error', 'Cart is empty');
        }
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
        ]);

        $cart = session()->get('cart', []);
        
        $stripeSecret = trim(config('services.stripe.secret') ?? '');
        $stripeKey = trim(config('services.stripe.key') ?? '');

        if (!$stripeSecret || str_contains($stripeSecret, 'your_stripe') || str_contains($stripeSecret, 'xxxx')) {
            return redirect()->back()->with('error', 'Invalid Stripe API Secret. You are still using "xxxx" placeholders or "your_stripe" text. Please replace them with real keys from your Stripe Dashboard.');
        }

        if (!$stripeKey || str_contains($stripeKey, 'your_stripe') || str_contains($stripeKey, 'xxxx')) {
            return redirect()->back()->with('error', 'Invalid Stripe Publishable Key. You are still using "xxxx" placeholders. Please replace them with real keys from your Stripe Dashboard.');
        }

        Stripe::setApiKey($stripeSecret);

        $lineItems = [];
        foreach ($cart as $id => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100, // Stripe expects amount in cents
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.index'),
            'customer_email' => Auth::user()->email ?? null,
            'metadata' => [
                'user_id' => Auth::id(),
                'full_name' => $request->full_name,
                'address' => $request->street . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip,
            ]
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if ($sessionId) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $session = Session::retrieve($sessionId);
                
                if ($session && $session->payment_status === 'paid') {
                    $cart = session()->get('cart', []);
                    $total = 0;
                    foreach($cart as $item) {
                        $total += $item['price'] * $item['quantity'];
                    }

                    // SECURITY & DATA INTEGRITY: Using Database Transactions
                    \Illuminate\Support\Facades\DB::beginTransaction();

                    $order = Order::create([
                        'user_id' => Auth::id() ?? 1,
                        'total' => $total,
                        'status' => 'paid'
                    ]);

                    foreach($cart as $id => $details) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $id,
                            'quantity' => $details['quantity'],
                            'price' => $details['price']
                        ]);
                        
                        // PERFORMANCE: Updating stock using Eloquent logic
                        $product = Product::find($id);
                        if ($product) {
                            $product->decrement('stock', $details['quantity']);
                        }
                    }

                    \Illuminate\Support\Facades\DB::commit();

                    \Illuminate\Support\Facades\Log::info("Order #{$order->id} created successfully. Redirecting to home.");

                    session()->forget('cart');
                    return redirect()->route('home')->with('success', 'Order placed successfully! Thank you for your purchase.');
                }
            } catch (\Throwable $e) {
                if (\Illuminate\Support\Facades\DB::transactionLevel() > 0) {
                    \Illuminate\Support\Facades\DB::rollBack();
                }
                \Illuminate\Support\Facades\Log::error("CRITICAL CHECKOUT ERROR: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
                return redirect()->route('home')->with('error', 'Payment processed but we had an issue saving your order: ' . $e->getMessage());
            }
        }

        return redirect('/')->with('error', 'Payment failed or session not found.');
    }
}
