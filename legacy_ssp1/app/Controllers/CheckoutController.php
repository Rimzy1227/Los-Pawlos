<?php

if (session_status() === PHP_SESSION_NONE) session_start();

class CheckoutController
{
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];

       
        require __DIR__ . '/../Views/checkout.php';
    }

    public function submit()
    {
        $requiredFields = ['full_name', 'street', 'city', 'state', 'zip', 'card_name', 'card_number', 'expiry', 'cvv'];

        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                die("Missing field: " . htmlspecialchars($field));
            }
        }

        $_SESSION['last_order'] = $_SESSION['cart'] ?? [];

        // clear cart
        unset($_SESSION['cart']);

        // Redirect to success page
        header('Location: index.php?route=checkout.success');
        exit;
    }

}
