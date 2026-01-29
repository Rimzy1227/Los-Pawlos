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

<div class="max-w-6xl mx-auto py-10">
  <h1 class="text-3xl font-bold mb-6 text-center"><?= htmlspecialchars($category) ?></h1>

  <?php if (empty($products)): ?>
    <p>No products found in this category.</p>
  <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
      <?php foreach ($products as $p): ?>
        <div class="card">
          <img src="assets/images/<?= strtolower($p['category']) ?>/<?= htmlspecialchars($p['image'] ?? 'placeholder.jpg') ?>" class="w-full h-48 object-contain rounded-t bg-gray-100">
          <h3 class="font-semibold"><?= htmlspecialchars($p['name']) ?></h3>
          <p class="text-sm text-gray-600"><?= htmlspecialchars($p['description']) ?></p>
          <div class="flex justify-between items-center mt-3">
            <a class="text-blue-600" href="index.php?route=product.detail&id=<?= $p['id'] ?>">View</a>
            <span class="font-bold">$<?= htmlspecialchars($p['price']) ?></span>
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
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<script>
  document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const productId = this.dataset.productId;

      fetch('index.php?route=cart.add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${encodeURIComponent(productId)}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          updateCartCount(data.cartCount);
          alert('Product added to cart!');
        } else {
          alert('Failed to add product to cart.');
        }
      })
      .catch(() => {
        alert('Error adding product to cart.');
      });
    });
  });

  function updateCartCount(count) {
    const cartCountElem = document.getElementById('cart-count');
    if (cartCountElem) {
      cartCountElem.textContent = count;
      cartCountElem.style.display = count > 0 ? 'inline-block' : 'none';
    }
  }
</script>
