<?php
$title = 'Admin Products';

// Capture the content in a buffer
ob_start();
?>
<div class="bg-white p-6 rounded shadow">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Product Management</h3>
        <a href="index.php?route=admin.product.create" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Product</a>
      </div>
<table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-100 border-b border-gray-200">
        <tr>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">ID</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Name</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Price</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Stock</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Category</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($product['id']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($product['name']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900">$<?= number_format($product['price'], 2) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($product['stock']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($product['category']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap">
                <a href="index.php?route=admin.products.edit&id=<?= $product['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium mr-4">Edit</a>
                <a href="index.php?route=admin.products.delete&id=<?= $product['id'] ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:text-red-800 font-medium">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();

require __DIR__ . '/layout.php';
