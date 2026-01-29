<?php
$title = 'Admin Settings';

// Capture the content in a buffer
ob_start();
?>
<h1 class="text-2xl font-bold mb-6">Settings</h1>

<form action="index.php?route=admin.settings.update" method="POST" class="max-w-lg bg-white p-6 rounded shadow-md">
    <div class="mb-4">
        <label for="site_name" class="block text-gray-700 font-semibold mb-2">Site Name</label>
        <input type="text" id="site_name" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div class="mb-4">
        <label for="admin_email" class="block text-gray-700 font-semibold mb-2">Admin Email</label>
        <input type="email" id="admin_email" name="admin_email" value="<?= htmlspecialchars($settings['admin_email'] ?? '') ?>" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Add more settings fields here -->

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Settings</button>
</form>

<?php
$content = ob_get_clean();

require __DIR__ . '/layout.php';
