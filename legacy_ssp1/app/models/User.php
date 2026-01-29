<?php

require_once __DIR__ . '/../../config/db.php';

class User {
    public static function findByEmail($email) {
        $pdo = new PDO('mysql:host=localhost;dbname=los_pawlos', 'root', '');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $email, $hashedPassword) {
        $pdo = new PDO('mysql:host=localhost;dbname=los_pawlos', 'root', '');
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword]);
    }
}
