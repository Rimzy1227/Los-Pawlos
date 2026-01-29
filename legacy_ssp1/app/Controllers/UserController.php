<?php

class UserController {
    public function account() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?route=login");
            exit;
        }

        $user = $_SESSION['user'];

        
        if (($user['role'] ?? '') === 'admin') {
            header("Location: index.php?route=admin.dashboard");
            exit;
        }

        ob_start();
        require __DIR__ . '/../Views/account.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layouts/main.php';
    }

    public function edit() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?route=login");
            exit;
        }

        $user = $_SESSION['user'];
        ob_start();
        require __DIR__ . '/../Views/account.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layouts/main.php';
    }

    public function update() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?route=login");
            exit;
        }

        $id = $_SESSION['user']['id'];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($name && $email) {
            $pdo = new PDO('mysql:host=localhost;dbname=los_pawlos', 'root', '');
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $email, $id]);

            
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;

            header("Location: index.php?route=account");
            exit;
        } else {
            echo "Name and email are required.";
        }
    }
}
