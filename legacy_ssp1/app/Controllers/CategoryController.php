<?php

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Middleware/auth.php';
require_once __DIR__ . '/../Models/Category.php';

class CategoryController {
    protected $category;

    public function __construct() {
        $this->category = new Category();
    }

    public function food() {
        $this->renderCategory('Food');
    }

    public function toys() {
        $this->renderCategory('Toys');
    }

    public function grooming() {
        $this->renderCategory('Grooming');
    }

    public function accessories() {
        $this->renderCategory('Accessories');
    }

    public function renderCategory($category) {
        $product = new Product();
        $products = $product->filterByCategory($category);

        ob_start();
        require __DIR__ . "/../Views/category.php";
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }
    public function categoryCreateForm() {
        requireRole('admin');
        require __DIR__ . '/../Views/admin/categoryform.php';
    }

    public function categoryStore() {
        requireRole('admin');

        $data = [
            'name'        => $_POST['name'],
            'description' => $_POST['description']
        ];

        $this->category->create($data);
        header('Location: index.php?route=admin.categories');
        exit;
    }

    public function categoryEditForm() {
        requireRole('admin');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Category not found.";
            return;
        }

        $category = $this->category->find($id);
        require __DIR__ . '/../Views/admin/categories/form.php';
    }

    public function categoryUpdate() {
        requireRole('admin');

        $id = $_POST['id'];
        $data = [
            'name'        => $_POST['name'],
            'description' => $_POST['description']
        ];

        $this->category->update($id, $data);
        header('Location: index.php?route=admin.categories');
        exit;
    }
    public function categoryDestroy() {
        requireRole('admin');
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->category->delete($id);
        }

        header('Location: index.php?route=admin.categories');
        exit;
    }
}
