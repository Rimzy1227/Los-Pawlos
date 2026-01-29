<?php

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Middleware/auth.php';

class ProductController {
    protected $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function index() {
        $cat = $_GET['cat'] ?? null;
        $q   = $_GET['q'] ?? null;
        
        if ($cat) {
            $products = $this->product->filterByCategory($cat);
        } elseif ($q) {
            $products = $this->product->search($q);
        } else {
            $products = $this->product->all();
        }

        require __DIR__ . '/../Views/products/index.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Product ID is missing.";
            return;
        }

        // Fetch product from DB
        $product = $this->product->find($id);

        if (!$product) {
            echo "Product not found.";
            return;
        }
        
        $product['rating'] = $product['rating'] ?? 0;
        $product['reviews_count'] = $product['reviews_count'] ?? 0;

        // Decode features JSON if present
        $product['features'] = json_decode($product['features'] ?? '[]', true);
        if (!is_array($product['features'])) {
            $product['features'] = [];
        }
        // Fetch related products
        $related = $this->product->getRelated($product['category'], $id);
        $product['related_products'] = $related;

        // Load view
        require __DIR__ . '/../Views/product_detail.php';
    }

    // admin only create form
    public function createForm() {
        requireRole('admin');
        require __DIR__ . '/../Views/products/form.php';
    }

    // save new product
    public function store() {
        requireRole('admin');

        $data = [
            'name'        => $_POST['name'],
            'description' => $_POST['description'],
            'price'       => $_POST['price'],
            'stock'       => $_POST['stock'],
            'category'    => $_POST['category'],
            'image'       => $_POST['image'] ?? null
        ];

        $this->product->create($data);
        header('Location: index.php?route=admin.dashboard');
        exit;
    }

    // show edit form
    public function editForm() {
        requireRole('admin');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Product not found.";
            return;
        }

        $product = $this->product->find($id);
        require __DIR__ . '/../Views/products/form.php';
    }

    // update existing product
    public function update() {
        requireRole('admin');
        
        $id = $_POST['id'];
        $data = [
            'name'        => $_POST['name'],
            'description' => $_POST['description'],
            'price'       => $_POST['price'],
            'stock'       => $_POST['stock'],
            'category'    => $_POST['category'],
            'image'       => $_POST['image'] ?? null
        ];

        $this->product->update($id, $data);
        header('Location: index.php?route=admin.dashboard');
        exit;
    }

    // delete product
    public function destroy() {
        requireRole('admin');
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->product->delete($id);
        }

        header('Location: index.php?route=admin.dashboard');
        exit;
    }
}
