<!DOCTYPE html>
<html>
<head>
	<title>CUEA Online Clearance System - Admin Page</title>
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
					<button>Manage Departments</button>
					<ul class="submenu">
						<li><a href="view_department.php">View All Departments</a></li>
						<li><a href="add_department.php">Add New Department</a></li>
					</ul>
				</li>
				<li class="manage">
					<button>Manage Staff</button>
					<ul class="submenu">
						<li><a href="view_staff.php">View All Staff</a></li>
						<li><a href="add_staff.php">Add New Staff</a></li>
					</ul>
				</li>
				<li class="manage">
					<button>Manage accounts</button>
					<ul class="submenu">
						<li><a href="view_accounts.php">View All accounts</a></li>
						<li><a href="add_account.php">Add New accounts</a></li>
					</ul>
				</li>
				<li class="manage">
					<button>Manage Students</button>
					<ul class="submenu">
						<li><a href="view_student.php">View All Students</a></li>
						<li><a href="add_student.php">Add New Student</a></li>
						<li><a href="Overstayed_students.php">Over Stayed Students</a></li>

					</ul>
				</li>
			</ul>
		</nav>
		<section>
			<h2>Welcome Admin</h2>
			<p>Select a task from the side bar to get started.</p>
		</section>
		
	</main>
	<footer>
		<p>&copy; 2023 CUEA Online Clearance System.</p>
	</footer>
</body>
</html>
