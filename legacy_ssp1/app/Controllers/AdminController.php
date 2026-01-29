<?php

require_once __DIR__ . '/../Middleware/auth.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';

class AdminController {
    public function dashboard() {
        requireRole('admin');  // its stop open if user is not admin
        $p = new Product();
        $products = $p->all();
        require __DIR__ . '/../Views/admin/dashboard.php';
    }
    public function products() {
        requireRole('admin');
        $p = new Product();
        $products = $p->all();
        require __DIR__ . '/../Views/admin/products.php';  // create this view file
    }
    public function categories() {
    requireRole('admin');
    $categoryModel = new Category();
    $categories = $categoryModel->all();

    require __DIR__ . '/../Views/admin/categories.php'; // create this view file
}

}
