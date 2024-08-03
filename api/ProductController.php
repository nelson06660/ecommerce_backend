<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept, Accept-Language, Accept-Encoding");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Define database connection variables
$db_host = 'localhost'; // Replace with your database host
$db_name = 'nelson'; // Replace with your database name
$db_username = 'root'; // Replace with your database username
$db_password = ''; // Replace with your database password

// Create a new database connection
$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

class ProductController {
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

  public function addProduct($product) {
    $query = "INSERT INTO products (name, description, price, image_url) VALUES (:name, :description, :price, :image_url)";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':name', $product['name']);
    $stmt->bindParam(':description', $product['description']);
    $stmt->bindParam(':price', $product['price']);
    $stmt->bindParam(':image_url', $product['imageUrl']);

    if ($stmt->execute()) {
      return ['success' => true];
    } else {
      return ['success' => false];
    }
  }
}

$productController = new ProductController($conn);

try {
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the products
    $products = $productController->getProducts();
    echo json_encode($products);
  } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add a new product
    $data = json_decode(file_get_contents('php://input'), true);
    $result = $productController->addProduct($data);
    echo json_encode($result);
  }
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
}
?>
