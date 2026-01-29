<?php
// app/Controllers/CustomerController.php

require_once __DIR__ . '/../Middleware/auth.php';

class CustomerController {
    public function index() {
        requireRole('admin'); // Only admin can access

        // Dummy data with 'created_at' included
        $customers = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'created_at' => '2025-09-20 14:35:00'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'created_at' => '2025-09-21 09:15:00'
            ],
        ];

        require __DIR__ . '/../Views/admin/customers.php'; // Your admin customers view
    }
}
