<?php

if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Los Pawlos Hermanos</title>
  <script src="https://cdn.tailwindcss.com"></script>
   <style>
    .btn-brand {
      background-image: linear-gradient(90deg, #6b8cff, #ff7a18);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      font-weight: 600;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: all .2s ease;
    }
    .btn-brand:hover {
      opacity: .9;
      transform: translateY(-2px);
    }
    .card {
      background-color: white;
      padding: 1rem;
      border-radius: 0.75rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: all 0.2s ease;
    }
    .card:hover {
      box-shadow: 0 6px 14px rgba(0,0,0,0.15);
      transform: translateY(-3px);
    }
  </style>
</head>
<body class="bg-gray-300 text-gray-800 flex flex-col min-h-screen">

  <!-- HEADER -->
<?php require __DIR__ . '/header.php'; ?>

  <div class="max-w-4xl mx-auto mt-4 px-4">
    <?php if (!empty($_SESSION['flash_error'])): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <?= htmlspecialchars($_SESSION['flash_error']) ?>
        <?php unset($_SESSION['flash_error']); ?>
      </div>
    <?php endif; ?>
  </div>
  <main class="flex-1">
    <?= $content ?? '' ?>
  </main>

 <?php require __DIR__ . '/footer.php'; ?>


<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const productId = this.dataset.productId;

    fetch('index.php?route=cart.add', {
  method: 'POST',
  headers: { 
    'Content-Type': 'application/x-www-form-urlencoded',
    'X-Requested-With': 'XMLHttpRequest' 
  },
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

</body>
</html>
