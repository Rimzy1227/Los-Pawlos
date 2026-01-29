<?php

ob_start();
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
<div class="max-w-2xl mx-auto mt-12 bg-white p-8 rounded shadow text-center">
  <div class="text-green-500 text-5xl mb-4">✅</div>
  <h1 class="text-3xl font-bold text-gray-800 mb-2">Order Placed Successfully!</h1>
  <p class="text-gray-600 mb-6">
    Thank you for shopping with <strong>Los Pawlos Hermanos</strong>. Your order has been received and is now being processed.
  </p>

  <div class="bg-gray-100 rounded p-6 text-left">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Order Summary</h2>
    <?php
    $cart = $_SESSION['last_order'] ?? [];
    $total = 0;
    $tax = 0;
    if (!empty($cart)):
    ?>
      <ul class="space-y-3">
        <?php foreach ($cart as $item): 
          $subtotal = $item['price'] * $item['qty'];
          $total += $subtotal;
        ?>
          <li class="flex justify-between text-gray-700">
            <span><?= htmlspecialchars($item['name']) ?> × <?= $item['qty'] ?></span>
            <span>$<?= number_format($subtotal, 2) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="border-t mt-4 pt-4 text-gray-800">
        <div class="flex justify-between mb-2">
          <span>Subtotal</span>
          <span>$<?= number_format($total, 2) ?></span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Tax (7%)</span>
          <span>$<?= number_format($tax = $total * 0.07, 2) ?></span>
        </div>
        <div class="flex justify-between font-bold text-lg">
          <span>Total</span>
          <span>$<?= number_format($total + $tax, 2) ?></span>
        </div>
      </div>
    <?php else: ?>
      <p>No order details available.</p>
    <?php endif; ?>
  </div>

  <a href="index.php?route=products" class="inline-block mt-6 bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600 transition">
    🛒 Continue Shopping
  </a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/main.php';
