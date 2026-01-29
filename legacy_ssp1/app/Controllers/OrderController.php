<?php

require_once __DIR__ . '/../Models/Order.php';  // 

class OrderController {
    public function index() {
        $orderModel = new Order();  // 
        $orders = $orderModel->all();

        require __DIR__ . '/../Views/admin/orders.php';
    }
}
