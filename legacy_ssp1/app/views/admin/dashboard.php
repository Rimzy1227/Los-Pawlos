<?php

ob_start();
?>

<div class="flex min-h-screen bg-gray-100">
  <!-- sidebar -->
  <aside class="w-64 bg-white shadow-md">
    <div class="p-4 text-center border-b">
      <h1 class="text-xl font-bold text-gray-800">Los Pawlos Hermanos</h1>
      <p class="text-sm text-gray-500">Admin Panel</p>
    </div>
    <nav class="mt-4">
      <a href="index.php?route=admin.dashboard" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Dashboard Overview</a>
      <a href="index.php?route=admin.products" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Products</a>
      <a href="index.php?route=admin.categories" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Categories</a>
      <a href="index.php?route=admin.orders" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Orders</a>
      <a href="index.php?route=admin.customers" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Customers</a>
      <a href="index.php?route=admin.analytics" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Analytics</a>
      <a href="index.php?route=admin.settings" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Settings</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <!-- Top Bar -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
      <a href="index.php?route=logout" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Total Sales</p>
        <h3 class="text-2xl font-bold">$12,234</h3>
        <p class="text-green-600 text-sm">+12% from last month</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Products</p>
        <h3 class="text-2xl font-bold"><?= count($products) ?></h3>
        <p class="text-green-600 text-sm">+5% from last month</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Orders</p>
        <h3 class="text-2xl font-bold">89</h3>
        <p class="text-green-600 text-sm">+23% from last month</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Customers</p>
        <h3 class="text-2xl font-bold">567</h3>
        <p class="text-green-600 text-sm">+8% from last month</p>
      </div>
    </div>

    <!-- Product Management -->
    <div class="bg-white p-6 rounded shadow">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Product Management</h3>
        <a href="index.php?route=admin.product.create" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Product</a>
      </div>

      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b">
            <th class="p-2">Product</th>
            <th class="p-2">Category</th>
            <th class="p-2">Price</th>
            <th class="p-2">Stock</th>
            <th class="p-2">Status</th>
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($products as $p): ?>
          <tr class="border-b hover:bg-gray-50">
            <td class="p-2 flex items-center space-x-2">
              <span class="w-6 h-6">🐾</span>
              <span><?= htmlspecialchars($p['name']) ?></span>
            </td>
            <td class="p-2"><?= htmlspecialchars($p['category']) ?></td>
            <td class="p-2 font-bold">$<?= number_format($p['price'],2) ?></td>
            <td class="p-2"><?= intval($p['stock']) ?></td>
            <td class="p-2">
              <?php if ($p['stock'] > 20): ?>
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">In Stock</span>
              <?php elseif ($p['stock'] > 0): ?>
                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Low Stock</span>
              <?php else: ?>
                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Out of Stock</span>
              <?php endif; ?>
            </td>
            <td class="p-2">
              <a href="index.php?route=admin.product.edit&id=<?= $p['id'] ?>" class="text-blue-600 mr-2">✏️</a>
              <a href="index.php?route=admin.product.delete&id=<?= $p['id'] ?>" class="text-red-600" onclick="return confirm('Delete product?')">🗑️</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
