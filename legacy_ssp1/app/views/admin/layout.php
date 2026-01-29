<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title ?? 'Admin Panel' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md min-h-screen p-4">
        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
        <nav class="space-y-2">
            <a href="index.php?route=admin.dashboard" class="block px-4 py-2 rounded hover:bg-gray-200">Dashboard Overview</a>
            <a href="index.php?route=admin.products" class="block px-4 py-2 rounded hover:bg-gray-200">Products</a>
            <a href="index.php?route=admin.categories" class="block px-4 py-2 rounded hover:bg-gray-200">Categories</a>
            <a href="index.php?route=admin.orders" class="block px-4 py-2 rounded hover:bg-gray-200">Orders</a>
            <a href="index.php?route=admin.customers" class="block px-4 py-2 rounded hover:bg-gray-200">Customers</a>
            <a href="index.php?route=admin.analytics" class="block px-4 py-2 rounded hover:bg-gray-200">Analytics</a>
            <a href="index.php?route=admin.settings" class="block px-4 py-2 rounded hover:bg-gray-200">Settings</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-8"><?= $title ?? 'Dashboard' ?></h1>
        <?= $content ?? '' ?>
    </main>

</body>
</html>
