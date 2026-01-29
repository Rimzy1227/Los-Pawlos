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

<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow mt-8">

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

    <div>
      <img src="assets/images/<?= strtolower($product['category']) ?>/<?= htmlspecialchars($product['image'] ?? 'placeholder.jpg') ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-auto rounded-lg shadow" />
    </div>

    <div>
      <h2 class="text-3xl font-bold"><?= htmlspecialchars($product['name']) ?></h2>

      <div class="flex items-center mt-2">
        <span class="text-yellow-500 text-xl"><?= str_repeat('★', floor($product['rating'])) ?></span>
        <span class="text-gray-600 ml-2">(<?= htmlspecialchars($product['reviews_count']) ?> reviews)</span>
      </div>

      <p class="text-2xl mt-4 font-semibold text-green-600">$<?= number_format($product['price'], 2) ?></p>
      <p class="mt-4 text-gray-700"><?= htmlspecialchars($product['description']) ?></p>

      <form method="post" action="index.php?route=cart.add" class="mt-6 flex items-center">
        <label for="quantity" class="mr-2 font-medium">Quantity:</label>
        <input type="number" id="quantity" name="qty" value="1" min="1" class="border rounded w-20 p-2 mr-4" />
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>" />
        <button
            type="submit"
            class="bg-green-500 text-white text-sm px-4 py-1.5 rounded hover:bg-green-600 transition"
        >
            Add to Cart
        </button>
        </form>


      <h3 class="mt-6 text-lg font-bold">Product Features</h3>
      <ul class="list-disc list-inside mt-2 text-gray-700">
        <?php if (!empty($product['features']) && is_array($product['features'])): ?>
          <?php foreach ($product['features'] as $feature): ?>
            <li><?= htmlspecialchars($feature) ?></li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No features listed.</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <h3 class="mt-12 text-xl font-bold">Customer Reviews</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
    <?php
    $reviews = [
        ['name' => 'Sarah M.', 'time' => '2 days ago', 'text' => 'Excellent quality! My dog loves it.'],
        ['name' => 'Mike L.', 'time' => '1 week ago', 'text' => 'Good value for money; fast delivery.'],
        ['name' => 'Lisa K.', 'time' => '2 weeks ago', 'text' => 'Perfect for my cat. Highly recommended!'],
        ['name' => 'John D.', 'time' => '3 weeks ago', 'text' => 'Great product, exactly as described.']
    ];
    foreach ($reviews as $review): ?>
      <div class="border border-gray-200 rounded p-4 shadow-sm">
        <strong><?= htmlspecialchars($review['name']) ?></strong>
        <span class="text-gray-500 text-sm"> - <?= htmlspecialchars($review['time']) ?></span>
        <p class="mt-1 text-gray-700"><?= htmlspecialchars($review['text']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>

  <h3 class="mt-12 text-xl font-bold text-center">Related Products</h3>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-4">
    <?php foreach ($product['related_products'] as $related): ?>
    <?php
        $image = !empty($related['image']) 
            ? $related['image'] 
            : 'default.jpg';  
    ?>
    <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
        <img 
            src="assets/images/<?= strtolower($related['category'] ?? $product['category']) ?>/<?= htmlspecialchars($image) ?>" 
            alt="<?= htmlspecialchars($related['name']) ?>" 
            class="w-full h-32 object-contain rounded mb-2" 
        />
        <h4 class="font-semibold"><?= htmlspecialchars($related['name']) ?></h4>
        <p class="text-gray-600">$<?= number_format($related['price'], 2) ?></p>
        <a href="index.php?route=product.detail&id=<?= $related['id'] ?>" class="text-blue-600 hover:underline text-sm">View</a>
    </div>
<?php endforeach; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/main.php';
