<?php
session_start();
include 'db_connect.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? '') !== 'school') { echo json_encode(['posts'=>[]]); exit; }
$school_id = $_SESSION['user_id'];

// fetch posts for this school
$stmt = $conn->prepare("SELECT id,title,description,num_volunteers,date_posted FROM opportunities WHERE school_id = ? ORDER BY date_posted DESC");
$stmt->bind_param("i", $school_id);
$stmt->execute();
$res = $stmt->get_result();
$posts = [];
while ($p = $res->fetch_assoc()) {
    $postId = $p['id'];
    // fetch applicants for this post
    $stmt2 = $conn->prepare("SELECT a.id,a.message,a.applied_at,a.status,v.name AS volunteer_name,v.email AS volunteer_email FROM applications a JOIN volunteers v ON a.volunteer_id = v.id WHERE a.opportunity_id = ? ORDER BY a.applied_at DESC");
    $stmt2->bind_param("i",$postId);
    $stmt2->execute();
    $r2 = $stmt2->get_result();
    $applicants = [];
    while($a = $r2->fetch_assoc()) $applicants[] = $a;

    // count applied
    $applied_count = count($applicants);

    $posts[] = [
        'id' => $p['id'],
        'title' => $p['title'],
        'description' => $p['description'],
        'num_volunteers' => $p['num_volunteers'],
        'date_posted' => $p['date_posted'],
        'applied_count' => $applied_count,
        'applicants' => $applicants
    ];
}
echo json_encode(['posts'=>$posts]);
