<?php

ob_start(); 
?>
<!-- Back Button -->
<div class="mb-6">
  <a 
    href="<?= $_SERVER['HTTP_REFERER'] ?? 'index.php?route=products' ?>" 
    onclick="document.getElementById('loading-overlay').style.display = 'flex';"
    class="inline-flex items-center px-4 py-2 border border-black rounded-md bg-white text-black hover:bg-black hover:border-black hover:text-white transition duration-200"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </a>
</div>

<h1 class="text-4xl font-extrabold text-center text-gray-800 mb-2">Our Products</h1>
<p class="text-center text-gray-500 text-sm mb-8"><?= count($products) ?> products found</p>


<div class="flex flex-col md:flex-row gap-8">

  <!-- sidebar -->
<aside class="w-full md:w-1/4 bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm self-start">   
   <h2 class="text-xl font-bold text-gray-800 mb-5">Filters</h2>

    <div class="mb-6">
      <h3 class="text-sm font-semibold text-gray-700 mb-2">Categories</h3>
      <ul class="space-y-1">
        <?php 
        $categories = ['all' => 'All Products', 'food' => 'Food', 'toys' => 'Toys', 'grooming' => 'Grooming', 'accessories' => 'Accessories'];
        foreach ($categories as $key => $label): ?>
          <li>
            <a href="?category=<?= $key ?>" class="text-blue-600 hover:text-blue-800 hover:underline transition duration-150">
              <?= $label ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="mb-6">
      <h3 class="text-sm font-semibold text-gray-700 mb-2">Availability</h3>
      <label class="inline-flex items-center space-x-2 text-sm text-gray-600">
        <input type="checkbox" class="accent-blue-600" name="availability" />
        <span>Show out of stock</span>
      </label>
    </div>

    <div>
      <h3 class="text-sm font-semibold text-gray-700 mb-2">Price Range</h3>
      <input type="range" name="price" min="0" max="100" class="w-full accent-blue-600" />
      <div class="flex justify-between text-xs text-gray-500 mt-1">
        <span>$0</span>
        <span>$100</span>
      </div>
    </div>
  </aside>

  <div class="w-full md:w-3/4">
    <div class="flex justify-center mb-6">
      <form method="get" action="index.php" class="flex w-full max-w-xl">
        <input
          type="text"
          name="search"
          placeholder="Search products..."
          class="w-full border border-gray-300 px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700 transition"
        >
          Search
        </button>
      </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($products as $p): ?>
        <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition duration-300">
          <img
            src="assets/images/<?= strtolower($p['category']) ?>/<?= htmlspecialchars($p['image'] ?? 'placeholder.jpg') ?>"
            alt="<?= htmlspecialchars($p['name']) ?>"
            class="w-full h-48 object-contain rounded-t bg-gray-100"
          />
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($p['name']) ?></h3>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($p['category']) ?></p>
            <p class="text-xl font-bold text-green-600 mt-2">$<?= number_format($p['price'], 2) ?></p>

            <div class="mt-4 flex justify-between items-center">
              <a
                href="index.php?route=product.detail&id=<?= $p['id'] ?>"
                class="text-blue-600 hover:text-blue-800 hover:underline text-sm"
              >
                View Details
              </a>
              <form method="post" action="index.php?route=cart.add">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>" />
                <button
                  type="submit"
                  class="bg-green-500 text-white text-sm px-4 py-1.5 rounded hover:bg-green-600 transition"
                >
                  Add to Cart
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>



<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
