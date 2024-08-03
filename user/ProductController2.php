<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow headers

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Database connection setup
require '../config/database.php';

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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Other methods related to user actions
}

// Create a new instance of the ProductController class
$productController = new ProductController2($conn);

// Get the products
$products = $productController->getProducts();
echo json_encode($products);

// Handle the /api/products route
if ($_SERVER['REQUEST_URI'] === '/user/products') {
    $products = $productController->getProducts();
    header('Content-Type: application/json');
    echo json_encode($products);
    exit;
  }
  
  // If the route is not /api/products, return a 404 error
  http_response_code(404);
  echo 'Not Foundssss';
  exit;
?>