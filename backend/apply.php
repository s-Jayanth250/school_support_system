<?php
session_start();
include 'db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success'=>false,'message'=>'Invalid method']); exit; }
if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? '') !== 'volunteer') { echo json_encode(['success'=>false,'message'=>'Please login as volunteer']); exit; }

$body = json_decode(file_get_contents('php://input'), true);
$opportunity_id = (int)($body['opportunity_id'] ?? 0);
$message = trim($body['message'] ?? '');

if (!$opportunity_id) { echo json_encode(['success'=>false,'message'=>'Invalid opportunity']); exit; }

$volunteer_id = $_SESSION['user_id'];

// prevent duplicate application
$check = $conn->prepare("SELECT id FROM applications WHERE opportunity_id = ? AND volunteer_id = ?");
$check->bind_param("ii", $opportunity_id, $volunteer_id);
$check->execute();
$cr = $check->get_result();
if ($cr->num_rows > 0) { echo json_encode(['success'=>false,'message'=>'You already applied']); exit; }

$stmt = $conn->prepare("INSERT INTO applications (opportunity_id, volunteer_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $opportunity_id, $volunteer_id, $message);
if ($stmt->execute()) echo json_encode(['success'=>true,'message'=>'Applied successfully']);
else echo json_encode(['success'=>false,'message'=>'Error: '.$stmt->error]);
