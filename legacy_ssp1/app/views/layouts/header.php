<header class="shadow-md">
  <!-- topnav -->
<div class="bg-white px-6 py-3">
  <div class="flex items-center justify-between flex-wrap">

    <!-- logo -->
    <div class="flex items-center space-x-2 mb-2 sm:mb-0">
      <img src="assets/images/logo2.jpg" alt="Logo" class="h-10 w-10">
      <a class="text-xl font-bold text-gray-800" href="index.php?route=home">
        Los Pawlos Hermanos
      </a>
    </div>

    <!-- Search Bar -->
    <form action="index.php" method="get" class="flex flex-grow sm:flex-grow-0 items-center w-full sm:w-1/2 max-w-lg mb-2 sm:mb-0 sm:mx-4">
      <input type="hidden" name="route" value="products">
      <input 
        type="text" 
        name="q" 
        placeholder="Search products..." 
        class="flex-grow border border-black border-r-0 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
      >
      <button 
        type="submit" 
        class="border border-black border-l-0 bg-orange-400 text-white px-4 py-2 rounded-r-lg hover:bg-orange-600"
      >
        🔍
      </button>
    </form>

    <!-- Auth & Cart -->
    <div class="flex items-center space-x-4">
      <?php if (isset($_SESSION['user'])): ?>
        <a href="index.php?route=account" class="text-gray-700 hover:text-orange-500 font-semibold">
          <?= htmlspecialchars($_SESSION['user']['name']) ?>
        </a>
        <a href="index.php?route=logout" class="text-gray-700 hover:text-orange-500">Logout</a>
      <?php else: ?>
        <a href="index.php?route=login" class="text-gray-700 hover:text-orange-500">Login</a>
        <a href="index.php?route=register" class="text-gray-700 hover:text-orange-500">Register</a>
      <?php endif; ?>

      <!-- Cart -->
      <a href="index.php?route=cart" class="relative text-gray-700 hover:text-orange-500 text-2xl">
        🛒
        <?php
          $cartQty = 0;
          if (!empty($_SESSION['cart'])) {
              foreach ($_SESSION['cart'] as $item) {
                  $cartQty += $item['qty'];
              }
          }
        ?>
        <?php if ($cartQty > 0): ?>
          <span id="cart-count" class="absolute -top-2 -right-3 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">
            <?= $cartQty ?>
          </span>
        <?php endif; ?>
      </a>
    </div>
  </div>
</div>


  <!-- 2ndnav -->
  <nav class="bg-orange-500 text-white">
    <ul class="flex justify-center space-x-8 py-3 text-sm font-semibold">
    <li><a href="index.php?route=products" class="hover:underline">All Products</a></li>
    <li><a href="index.php?route=food" class="hover:underline">Food</a></li>
    <li><a href="index.php?route=toys" class="hover:underline">Toys</a></li>
    <li><a href="index.php?route=grooming" class="hover:underline">Grooming</a></li>
    <li><a href="index.php?route=accessories" class="hover:underline">Accessories</a></li>
    </ul>
  </nav>
</header>
