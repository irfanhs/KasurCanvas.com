<?php
/**
 * KasurCanvas.com - Inquiry & RFQ Submission API
 */
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$productName = trim($_POST['product_name'] ?? 'General Canvas Inquiry');
$customerName = trim($_POST['customer_name'] ?? '');
$companyName = trim($_POST['company_name'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone = trim($_POST['phone'] ?? '');
$country = trim($_POST['country'] ?? 'Pakistan');
$quantity = trim($_POST['quantity'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($customerName)) {
    echo json_encode(['success' => false, 'message' => 'Please enter your full name.']);
    exit;
}

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid business email address.']);
    exit;
}

if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please include your requirements or questions in the message.']);
    exit;
}

try {
    $pdo = get_db();
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO `inquiries` 
        (`product_name`, `customer_name`, `company_name`, `email`, `phone`, `country`, `quantity`, `message`, `ip_address`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $productName,
        $customerName,
        $companyName,
        $email,
        $phone,
        $country,
        $quantity,
        $message,
        $ipAddress
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you, ' . htmlspecialchars($customerName) . '! Your inquiry for ' . htmlspecialchars($productName) . ' has been received. Our export team will contact you within 2-4 business hours.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error recording inquiry. Please contact our export desk directly via WhatsApp at ' . COMPANY_PHONE . '.'
    ]);
}
