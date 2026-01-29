<?php
$title = 'Admin Analytics';

// Capture the content in a buffer
ob_start();
?>
<h1 class="text-2xl font-bold mb-4">Analytics Overview</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="font-semibold text-lg mb-2">Total Sales</h2>
        <p class="text-3xl font-bold text-green-600">$<?= number_format($analytics['total_sales'], 2) ?></p>
    </div>
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="font-semibold text-lg mb-2">Total Orders</h2>
        <p class="text-3xl font-bold text-blue-600"><?= number_format($analytics['total_orders']) ?></p>
    </div>
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="font-semibold text-lg mb-2">New Customers</h2>
        <p class="text-3xl font-bold text-purple-600"><?= number_format($analytics['new_customers']) ?></p>
    </div>
</div>

<!-- Add more charts or data as needed -->

<?php
$content = ob_get_clean();

require __DIR__ . '/layout.php';
