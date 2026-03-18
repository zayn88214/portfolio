<?php
require_once '../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    // maybe form data instead of JSON
    $input = $_POST;
}

$firstName = trim($input['first_name'] ?? '');
$lastName = trim($input['last_name'] ?? '');
$email = trim($input['email'] ?? '');
$phone = trim($input['phone'] ?? '');
$message = trim($input['message'] ?? '');

if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Please fill all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email address.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO messages (first_name, last_name, email, phone, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $email, $phone, $message]);

    echo json_encode(['success' => true]);
}
catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: could not save message.']);
}
?>