<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$user_type = $_POST['user_type'] ?? 'volunteer';

if (!$name || !$email || strlen($password) < 6 || !in_array($user_type,['school','volunteer'])) {
    echo "Invalid input"; exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

if ($user_type === 'school') {
    $stmt = $conn->prepare("INSERT INTO schools (name,email,password) VALUES (?, ?, ?)");
} else {
    $stmt = $conn->prepare("INSERT INTO volunteers (name,email,password) VALUES (?, ?, ?)");
}
if (!$stmt) { echo "Prepare failed"; exit; }
$stmt->bind_param("sss", $name, $email, $hashed);

if ($stmt->execute()) {
    header("Location: ../auth.html");
    exit;
} else {
    echo "Error: " . htmlspecialchars($stmt->error);
}
?>
