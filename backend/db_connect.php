<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'school_volunteer_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Connection failed: '.$conn->connect_error);
}
?>
