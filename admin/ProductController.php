<?php
// Database connection setup
require '../config/database.php';

class ProductController {
  public function getProducts() {
    $query = "SELECT * FROM products";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Other CRUD methods for products
}
?>
