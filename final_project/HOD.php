<?php
session_start(); // Start the session
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login2.php'); // Redirect to login page if user is not logged in
    exit;
}

require_once 'connection.php'; // Connect to the database
?>

<!DOCTYPE html>
<html>
<head>
	<title>CUEA Online Clearance System - HOD Page</title>
	<link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
	<header>
		<div class="logo">
			<img src="logo.png" alt="CUEA Logo">
			<h1>CUEA Online Clearance System</h1>
		</div>
		<div class="logout">
			<a href="logout.php">Logout</a>
		</div>
	</header>
	<main>
		<nav>
			<ul>
				<li class="manage">
					<button>Clearance</button>
					<ul class="submenu">
						<li><a href="clearance_request.php">Check clearance request</a></li>
						<li><a href="finance_declined_report.php">declined clearance reports</a></li>
                        <li><a href="finance_accepted_report.php">Approved clearance reports</a></li>

					</ul>
				</li>
				<li class="manage">
					<button>Profile</button>
					<ul class="submenu">
						<li><a href="#">Check your profile</a></li>
						

					</ul>
				</li>
			</ul>
		</nav>
		<section>
          <h2>Welcome <?php echo $_SESSION['user']['user'] ?></h2>
			<p>Select a task from the sidebar to get started.</p>
		</section>
	</main>
</body>
</html>
