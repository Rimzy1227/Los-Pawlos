<?php

require_once __DIR__ . '/../Middleware/auth.php';

class AnalyticsController {
    public function __construct() {
        // Start session and check admin role for all methods
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        requireRole('admin');
    }

    public function index() {
        // Fetch or calculate analytics data here
        // For now, just show a placeholder message
        echo "<h1>Admin Analytics Dashboard</h1>";
        echo "<p>This is where you would display analytics reports and charts.</p>";

        // Or load a view instead:
        // require __DIR__ . '/../Views/admin/analytics.php';
    }
}
