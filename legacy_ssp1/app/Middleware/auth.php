<?php

session_start();

function checkAuth() {
    return isset($_SESSION['user']);
}

function requireAuth() {
    if (!checkAuth()) {
        header('Location: index.php?route=login');
        exit;
    }
}

function requireRole($role) {
    if (!checkAuth()) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: index.php?route=login");
    exit;
}
}
function isAdmin() {
    return checkAuth() && ($_SESSION['user']['role'] ?? '') === 'admin';
}

