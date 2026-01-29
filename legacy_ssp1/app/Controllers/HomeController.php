<?php

require_once __DIR__ . '/../Models/Product.php';
class HomeController {
    public function index() {
        $p = new Product();
        $products = $p->all();
        require __DIR__ . '/../Views/home.php';
    }
}
