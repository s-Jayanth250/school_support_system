<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? '') !== 'school') { http_response_code(403); echo "Please login as school"; exit; }

$school_id = $_SESSION['user_id'];
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$category = trim($_POST['category'] ?? '');
$location = trim($_POST['location'] ?? '');
$num_volunteers = (int)($_POST['num_volunteers'] ?? 1);
if (!$title || !$description) { echo "Missing fields"; exit; }

$stmt = $conn->prepare("INSERT INTO opportunities (school_id, title, description, category, location, num_volunteers) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssi", $school_id, $title, $description, $category, $location, $num_volunteers);
if ($stmt->execute()) {
    header("Location: ../school_dashboard.php");
    exit;
} else {
    echo "Error: " . htmlspecialchars($stmt->error);
}
