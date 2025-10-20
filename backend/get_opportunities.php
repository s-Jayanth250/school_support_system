<?php
include 'db_connect.php';
header('Content-Type: application/json');

$sql = "SELECT o.id,o.title,o.description,o.category,o.location,o.num_volunteers,o.date_posted,s.name AS school_name,
        (SELECT COUNT(*) FROM applications a WHERE a.opportunity_id = o.id) AS applied_count
        FROM opportunities o
        JOIN schools s ON o.school_id = s.id
        ORDER BY o.date_posted DESC";
$res = $conn->query($sql);
$out = [];
while ($row = $res->fetch_assoc()) $out[] = $row;
echo json_encode($out);
