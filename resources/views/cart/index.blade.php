@extends('layouts.app')

@section('content')

<!-- Back Button -->
<div class="mb-6 max-w-6xl mx-auto mt-4 px-4">
  <a 
    href="javascript:history.back()" 
    class="inline-flex items-center px-4 py-2 border border-black rounded-md bg-white text-black hover:bg-black hover:border-black hover:text-white transition duration-200"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </a>
</div>

<div class="flex max-w-6xl mx-auto bg-white p-6 rounded shadow mt-8 space-x-12 mb-12">
    @php
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * ($item['quantity'] ?? 1);
        }
        $shipping = 0;
        $tax = $total * 0.07;
        $finalTotal = $total + $shipping + $tax;
    @endphp

  <div class="flex-1 mr-6 min-w-0">
    <h2 class="text-3xl font-semibold mb-8">Shopping Cart</h2>

    @if (empty($cart))
      <div class="text-center py-16">
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.293 2.707a1 1 0 00.217 1.207l.086.086A1 1 0 007 17h10m-4 4a1 1 0 100-2 1 1 0 000 2zm-6 0a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
        <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
            Shop Now
        </a>
        </div>
    @else
        <div class="divide-y divide-gray-200">
            @foreach ($cart as $id => $i)
                @php $qty = $i['quantity'] ?? 1; @endphp
                <div class="flex flex-col sm:flex-row items-center py-6 space-y-4 sm:space-y-0 sm:space-x-6">
                    
                    <div class="w-32 h-32 flex-shrink-0">
                    <img 
                        src="{{ asset('assets/images/'.strtolower($i['category'] ?? 'general').'/'.($i['image'] ?? 'placeholder.jpg')) }}" 
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/placeholder.jpg') }}';"
                        class="w-full h-full object-contain bg-gray-100 rounded"
                        alt="{{ $i['name'] }}"
                    >
                    </div>

                    <div class="flex-1 min-w-0">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $i['name'] }}</h4>
                    <p class="text-sm text-gray-500">Price: ${{ number_format($i['price'], 2) }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 min-w-[250px]">
                    <form action="{{ route('cart.update') }}" method="POST" class="inline-flex items-center">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input
                            type="number"
                            name="quantity"
                            value="{{ $qty }}"
                            min="1"
                            class="qty-input w-20 border border-gray-300 rounded px-3 py-1 text-center text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                            onchange="this.form.submit()"
                        />
                    </form>

                    <span class="subtotal font-semibold text-gray-700">
                        ${{ number_format($i['price'] * $qty, 2) }}
                    </span>

                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="text-red-600 text-sm hover:underline">Remove</button>
                    </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-right mt-8">
            <p class="text-2xl font-semibold">Total: $<span id="total">{{ number_format($total, 2) }}</span></p>
        </div>
    @endif
  </div>

  @if (!empty($cart))
  <aside class="w-full max-w-md bg-gray-50 p-8 rounded-lg shadow-md mx-auto self-start">
    <h3 class="text-2xl font-semibold mb-6 text-gray-900">Order Summary</h3>
    <div class="space-y-5 text-gray-700 text-lg">
        <div class="flex justify-between">
        <span>Subtotal:</span>
        <span>${{ number_format($total, 2) }}</span>
        </div>
        <div class="flex justify-between">
        <span>Shipping:</span>
        <span>${{ number_format($shipping, 2) }}</span>
        </div>
        <div class="flex justify-between">
        <span>Tax (7%):</span>
        <span>${{ number_format($tax, 2) }}</span>
        </div>
        <div class="border-t border-gray-300 pt-4 flex justify-between font-bold text-gray-900 text-2xl">
        <span>Total:</span>
        <span>${{ number_format($finalTotal, 2) }}</span>
        </div>
    </div>

    <div class="mt-8 space-y-4">
        <a 
        href="{{ route('checkout.index') }}" 
        class="block bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition text-lg font-semibold shadow"
        >
        Proceed to Checkout
        </a>
        <a 
        href="{{ route('products.index') }}" 
        class="block bg-gray-300 text-center py-3 rounded-lg hover:bg-gray-400 transition text-lg font-semibold shadow"
        >
        Continue Shopping
        </a>
    </div>
    </aside>
  @endif

</div>
@endsection
