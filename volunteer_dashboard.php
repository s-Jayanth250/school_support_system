<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? '') !== 'volunteer') {
    header("Location: auth.html"); exit;
}
$name = htmlspecialchars($_SESSION['name']);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Volunteer Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="navbar">
    <div class="nav-left">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="profile-icon">
      <span class="brand">SchoolConnect</span>
    </div>
    <nav class="nav-links">
      <span class="welcome">Welcome, <?php echo $name; ?></span>
      <a href="index.html">Home</a>
      <a href="backend/logout.php">Logout</a>
    </nav>
  </header>

  <main style="padding:24px;">
    <h1>Available Opportunities</h1>
    <div id="browseContainer" class="posts-container">Loading...</div>
  </main>

<script src="js/volunteer.js"></script>
</body>
</html>
