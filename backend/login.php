<?php
session_start();
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$user_type = $_POST['user_type'] ?? 'volunteer';

if (!$email || !$password) { echo "Missing"; exit; }

if ($user_type === 'school') {
    $stmt = $conn->prepare("SELECT id,name,password FROM schools WHERE email = ?");
} else {
    $stmt = $conn->prepare("SELECT id,name,password FROM volunteers WHERE email = ?");
}
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows !== 1) { echo "Invalid credentials"; exit; }
$user = $res->fetch_assoc();
if (!password_verify($password, $user['password'])) { echo "Invalid credentials"; exit; }

// login ok
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_type'] = $user_type;
$_SESSION['name'] = $user['name'];
// redirect
if ($user_type === 'school') header("Location: ../school_dashboard.php");
else header("Location: ../volunteer_dashboard.php");
exit;
