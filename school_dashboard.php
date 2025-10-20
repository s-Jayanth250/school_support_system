<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_type'] ?? '') !== 'school') {
    header("Location: auth.html"); exit;
}
include 'backend/db_connect.php';
$school_id = $_SESSION['user_id'];
$school_name = htmlspecialchars($_SESSION['name']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>School Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="navbar">
  <div class="nav-left">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="profile-icon">
    <span class="brand">SchoolConnect</span>
  </div>
  <nav class="nav-links">
    <span class="welcome">Welcome, <?php echo $school_name;?></span>
    <a href="index.html">Home</a>
    <a href="backend/logout.php">Logout</a>
  </nav>
</header>

<main style="padding:22px;">
  <h1>Your School Dashboard</h1>

  <section class="card">
    <h3>Post a need</h3>
    <form id="postForm" action="backend/post_opportunity.php" method="POST">
      <input name="title" placeholder="Need title (e.g. Math Tutor)" required>
      <textarea name="description" placeholder="Describe the need" rows="3" required></textarea>
      <input name="category" placeholder="Category (Teaching, Events...)" required>
      <input name="location" placeholder="Location (city/area)" required>
      <input name="num_volunteers" type="number" min="1" value="1" required>
      <button type="submit">Post Need</button>
    </form>
  </section>

  <section class="card">
    <h3>Your Posted Needs & Applicants</h3>
    <div id="schoolPosts">Loading...</div>
  </section>
</main>

<script src="js/school.js"></script>
</body>
</html>
