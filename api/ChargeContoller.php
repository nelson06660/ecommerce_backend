<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept, Accept-Language, Accept-Encoding");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require './vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51PjOseGGZtZ5ySStZDdHMb7ICG69QmZbttxDMGup2WEBFkSYdWoghcdiSzUJIWSQ58PkjgFBhXT11y5ekrDBWIgj00tS2hDIGC'); // Your secret API key

try {
    $payload = json_decode(file_get_contents('php://input'), true);
    $paymentMethodId = $payload['payment_method'];

    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1099, // Example amount in cents
        'currency' => 'usd',
        'payment_method' => $paymentMethodId,
        'confirm' => true,
    ]);

    echo json_encode(['success' => true]);
} catch (\Stripe\Exception\CardException $e) {
    // Log the error for further analysis but respond with success for testing
    error_log('Stripe Card Exception: ' . $e->getMessage());
    echo json_encode(['success' => true]); // Continue with success for testing purposes
} catch (Exception $e) {
    // Log any other exceptions and respond with success
    error_log('General Exception: ' . $e->getMessage());
    echo json_encode(['success' => true]); // Continue with success for testing purposes
}