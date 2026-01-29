<?php
$isEdit = isset($category);
$action = $isEdit ? "index.php?route=admin.categories.update" : "index.php?route=admin.categories.store";
ob_start();
?>

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-8">
  <h2 class="text-2xl mb-4"><?= $isEdit ? 'Edit Category' : 'Create Category' ?></h2>
  <form method="post" action="<?= $action ?>">
    <?php if($isEdit): ?>
      <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
    <?php endif; ?>
    <label class="block mb-2">Name
      <input type="text" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>" class="w-full p-2 border rounded">
    </label>
    <label class="block mb-4">Description
      <textarea name="description" class="w-full p-2 border rounded"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
    </label>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
      <?= $isEdit ? 'Update' : 'Create' ?>
    </button>
  </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/main.php';
