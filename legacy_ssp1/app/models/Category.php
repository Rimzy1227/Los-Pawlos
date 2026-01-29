<?php

require_once 'Model.php';  

class Category extends Model {
    // get all categories
    public function all() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // find category by ID
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // create new category
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null
        ]);
    }

    // update existing category
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $id
        ]);
    }

    // delete category by ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
