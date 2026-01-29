<?php
$title = 'Admin Orders';

// Capture the content in a buffer
ob_start();
?>
<table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-100 border-b border-gray-200">
        <tr>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Order ID</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Customer</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Date</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Status</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Total</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($order['id']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($order['customer_name']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($order['order_date']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900"><?= htmlspecialchars($order['status']) ?></td>
            <td class="py-4 px-6 whitespace-nowrap text-gray-900">$<?= number_format($order['total'], 2) ?></td>
            <td class="py-4 px-6 whitespace-nowrap">
                <a href="index.php?route=admin.orders.view&id=<?= $order['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium mr-4">View</a>
                <a href="index.php?route=admin.orders.delete&id=<?= $order['id'] ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:text-red-800 font-medium">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();

require __DIR__ . '/layout.php';
