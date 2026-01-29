<?php

?>

<table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-100 border-b border-gray-200">
        <tr>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">ID</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Name</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Email</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Created At</th>
            <th class="text-left py-3 px-6 font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $customer): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-4 px-6 whitespace-nowrap"><?= htmlspecialchars($customer['id'] ?? '') ?></td>
                    <td class="py-4 px-6 whitespace-nowrap"><?= htmlspecialchars($customer['name'] ?? '') ?></td>
                    <td class="py-4 px-6 whitespace-nowrap"><?= htmlspecialchars($customer['email'] ?? '') ?></td>
                    <td class="py-4 px-6 whitespace-nowrap">
                        <?= htmlspecialchars($customer['created_at'] ?? 'N/A') ?>
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap">
                        <a href="index.php?route=admin.customers.view&id=<?= urlencode($customer['id'] ?? '') ?>" class="text-blue-600 hover:text-blue-800 font-medium mr-4">View</a>
                        <a href="index.php?route=admin.customers.delete&id=<?= urlencode($customer['id'] ?? '') ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:text-red-800 font-medium">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center py-4">No customers found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();

require __DIR__ . '/layout.php';
