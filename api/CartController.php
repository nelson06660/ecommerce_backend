<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept, Accept-Language, Accept-Encoding");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

//require '../config/database.php';

// Define database connection variables
$db_host = 'localhost'; // Replace with your database host
$db_name = 'nelson'; // Replace with your database name
$db_username = 'root'; // Replace with your database username
$db_password = ''; // Replace with your database password

// Create a new database connection
$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);

class ProductController2 {
  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function getProducts() {
    $query = "SELECT * FROM products";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if the result is an array
    if (is_array($result)) {
      return $result;
    } else {
      // Return an empty array if the result is not an array
      return [];
    }
  }

  // Other methods related to user actions
}

// Create a new instance of the ProductController class
$productController = new ProductController2($conn);

// Get the products
$products = $productController->getProducts();
echo json_encode($products);
?>