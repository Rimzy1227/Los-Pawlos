<?php

require_once 'Model.php';

class Order extends Model {
    public function create($user_id, $total) {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->execute([$user_id, $total]);
        return $this->db->lastInsertId(); 
    }

    public function addItem($order_id, $product_id, $qty, $price) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$order_id, $product_id, $qty, $price]);
    }

    public function all() {
        $sql = "SELECT o.id, o.total, o.status, o.created_at AS order_date,
                       u.name AS customer_name
                FROM orders o
                JOIN users u ON o.user_id = u.id
                ORDER BY o.created_at DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getItems($order_id) {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
