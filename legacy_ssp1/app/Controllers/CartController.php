<?php

require_once __DIR__ . '/../Models/Product.php';
if(session_status() == PHP_SESSION_NONE) session_start();

class CartController {
    protected $product;
    public function __construct(){ $this->product = new Product(); }

   public function add() {
    $id = $_POST['product_id'] ?? null;
    if (!$id) {
        header('Location:index.php?route=products');
        exit;
    }

    $product = $this->product->find($id);

    if (!$product) {
        header('Location:index.php?route=products');
        exit;
    }


    $qty = 1;

    $_SESSION['cart'][$id] = [
        'product_id' => $id,
        'name'       => $product['name'],
        'price'      => $product['price'],
        'qty'        => ($_SESSION['cart'][$id]['qty'] ?? 0) + $qty,
        'image'      => $product['image'],
        'category'   => $product['category'],
    ];

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // Ajax request: return JSON
        $cartCount = array_sum(array_column($_SESSION['cart'], 'qty'));
        $_SESSION['cart_count'] = $cartCount;
        echo json_encode(['success' => true, 'cartCount' => $cartCount]);
        exit;
    } else {

        header('Location: index.php?route=cart');
        exit;
    }
}

    public function view() {
        $cart = $_SESSION['cart'] ?? [];
        require __DIR__ . '/../Views/cart.php';
    }

    public function remove() {
        $id = $_GET['id'] ?? null;
        if ($id && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: index.php?route=cart');
    }
}
