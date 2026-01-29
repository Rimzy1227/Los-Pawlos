<?php

ob_start();
$isEdit = !empty($product);
?>
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-8">
  <h2 class="text-2xl mb-4"><?= $isEdit ? 'Edit Product' : 'Create Product' ?></h2>
  <form method="post" action="index.php?route=<?= $isEdit ? 'admin.product.update' : 'admin.product.store' ?>">
    <?php if($isEdit): ?>
      <input type="hidden" name="id" value="<?=htmlspecialchars($product['id'])?>">
    <?php endif; ?>
    <label class="block mb-2">Name<input type="text" name="name" value="<?=htmlspecialchars($product['name'] ?? '')?>" class="w-full p-2 border rounded"></label>
    <label class="block mb-2">Category<input type="text" name="category" value="<?=htmlspecialchars($product['category'] ?? '')?>" class="w-full p-2 border rounded"></label>
    <label class="block mb-2">Price<input type="number" step="0.01" name="price" value="<?=htmlspecialchars($product['price'] ?? '')?>" class="w-full p-2 border rounded"></label>
    <label class="block mb-2">Stock<input type="number" name="stock" value="<?=htmlspecialchars($product['stock'] ?? '')?>" class="w-full p-2 border rounded"></label>
    <label class="block mb-2">Description<textarea name="description" class="w-full p-2 border rounded"><?=htmlspecialchars($product['description'] ?? '')?></textarea></label>
    <label class="block mb-2">
  Image Filename
  <input type="text" name="image" value="<?= htmlspecialchars($product['image'] ?? '') ?>" class="w-full p-2 border rounded" placeholder="e.g. product.jpg">
</label>

    <button class="bg-indigo-600 text-white px-4 py-2 rounded"><?= $isEdit ? 'Update' : 'Create' ?></button>
  </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
