<?php

require_once 'Model.php'; // Ensure this provides $this->db as PDO instance

class Product extends Model {
    // get all products
    public function all() {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // get a single product by ID
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // get related product
    public function getRelated($category, $excludeId) {
        $stmt = $this->db->prepare("
            SELECT * FROM products 
            WHERE category = ? AND id != ? 
            ORDER BY RAND() 
            LIMIT 4
        ");
        $stmt->execute([$category, $excludeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // create new product
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, description, price, stock, image, category) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['image'] ?? null,
            $data['category']
        ]);
    }

    // update existing product
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE products 
            SET name = ?, description = ?, price = ?, stock = ?, image = ?, category = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['image'] ?? null,
            $data['category'],
            $id
        ]);
    }

    // delete product
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // filter products by category
    public function filterByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // search products by name or description
    public function search($term) {
        $like = "%" . $term . "%";
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
