<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust as necessary for your security requirements

$host = 'localhost';
$db = 'nelson';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    error_log($e->getMessage());
    exit('Database connection failed.');
}

// Handle GET request to fetch orders
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query('SELECT * FROM orders');
        $orders = $stmt->fetchAll();
        echo json_encode($orders);
    } catch (\PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch orders']);
    }
}
?>
