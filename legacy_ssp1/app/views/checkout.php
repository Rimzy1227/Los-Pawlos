<?php

ob_start();

$cart = $cart ?? $_SESSION['cart'] ?? [];
$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}


$shipping = 0;
$tax = $total * 0.07; 
$finalTotal = $total + $shipping + $tax;

?>
<!-- Back Button -->
<div class="mb-6">
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

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow mt-8">

    <h2 class="text-2xl mb-6">Checkout</h2>

    <form action="index.php?route=checkout.submit" method="post">

        <div class="grid grid-cols-2 gap-6">

            <div>
                <h3 class="text-lg font-bold mb-2">Shipping Address</h3>

                <div class="mb-4">
                    <label for="full-name" class="block mb-1">Full Name</label>
                    <input type="text" id="full-name" name="full_name" placeholder="Enter full name" class="border rounded w-full p-2" required>
                </div>
                <div class="mb-4">
                    <label for="street" class="block mb-1">Street Address</label>
                    <input type="text" id="street" name="street" placeholder="Enter street address" class="border rounded w-full p-2" required>
                </div>
                <div class="mb-4">
                    <label for="city" class="block mb-1">City</label>
                    <input type="text" id="city" name="city" placeholder="Enter city" class="border rounded w-full p-2" required>
                </div>
                <div class="mb-4">
                    <label for="state" class="block mb-1">State</label>
                    <input 
                        list="states" 
                        name="state" 
                        id="state" 
                        class="border rounded w-full p-2" 
                        placeholder="Select or type a state" 
                        required>
                    <datalist id="states">
                        <option value="California">
                        <option value="Texas">
                        <option value="Florida">
                        <option value="New York">
                        <option value="Pennsylvania">
                        <option value="Illinois">
                        <option value="Ohio">
                        <option value="Georgia">
                        <option value="North Carolina">
                        <option value="Michigan">
                    </datalist>
                    </div>

                <div class="mb-4">
                    <label for="zip" class="block mb-1">ZIP Code</label>
                    <input type="text" id="zip" name="zip" placeholder="Enter ZIP code" class="border rounded w-full p-2" required>
                </div>
            </div>


            <div>
                <h3 class="text-lg font-bold mb-2">Payment Information</h3>

                <div class="mb-4">
                    <label class="block mb-1">Credit/Debit Card</label>
                    <div>
                        <label for="card-name" class="block">Name on Card</label>
                        <input type="text" id="card-name" name="card_name" placeholder="Enter name as shown on card" class="border rounded w-full p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="card-number" class="block">Card Number</label>
                        <input type="text" id="card-number" name="card_number" placeholder="1234 5678 9012 3456" class="border rounded w-full p-2" required>
                    </div>
                    <div class="flex justify-between">
                        <div class="w-1/2 mr-1">
                            <label for="expiry" class="block">Expiry Date (MM/YY)</label>
                            <input type="text" id="expiry" name="expiry" placeholder="MM/YY" class="border rounded w-full p-2" required>
                        </div>
                        <div class="w-1/2 ml-1">
                            <label for="cvv" class="block">CVV</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123" class="border rounded w-full p-2" required>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-6">
            <h3 class="text-lg font-bold mb-2">Order Summary</h3>
            <div class="bg-gray-100 p-4 rounded shadow">
                <div>
                    <?php foreach ($cart as $item): ?>
                        <div class="flex justify-between mb-2">
                            <div><?= htmlspecialchars($item['name']) ?> (Qty: <?= intval($item['qty']) ?>)</div>
                            <div>$<?= number_format($item['price'] * $item['qty'], 2) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="border-t border-gray-300 mt-4 pt-2 flex justify-between">
                    <div>Subtotal:</div>
                    <div>$<?= number_format($total, 2) ?></div>
                </div>
                <div class="flex justify-between">
                    <div>Shipping:</div>
                    <div>$<?= number_format($shipping, 2) ?></div>
                </div>
                <div class="flex justify-between">
                    <div>Tax (7%):</div>
                    <div>$<?= number_format($tax, 2) ?></div>
                </div>
                <div class="border-t border-gray-300 mt-4 pt-2 flex justify-between">
                    <div class="font-bold">Total:</div>
                    <div class="font-bold">$<?= number_format($finalTotal, 2) ?></div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Place Order</button>
                </div>
            </div>
        </div>

    </form> 

</div>


<?php

$content = ob_get_clean();

require __DIR__ . '/layouts/main.php';