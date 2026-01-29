<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Models/User.php';

class AuthController {
    public function login() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'customer'
                ];

                
                if ($_SESSION['user']['role'] === 'admin') {
                    header('Location: index.php?route=admin.dashboard');
                } else {
                    header('Location: index.php?route=home');
                }
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function showLogin() {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function register() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if ($password !== $confirm) {
                $error = "Passwords do not match.";
            } elseif (User::findByEmail($email)) {
                $error = "Email already registered.";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                User::create($name, $email, $hashed);
                header('Location: index.php?route=login');
                exit;
            }
        }

        require __DIR__ . '/../Views/auth/register.php';
    }

    public function showRegister() {
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
