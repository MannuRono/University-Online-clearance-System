<?php
session_start(); // Start the session
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login2.php'); // Redirect to login page if user is not logged in
    exit;
}

require_once 'connection.php'; // Connect to the database
// Initialize the user profile variable
$userProfile = '';

// Check if the display button is clicked
if (isset($_POST['displayButton'])) {
    // Retrieve the staffno from the session
    if (isset($_SESSION['user']['user'])) {
        $staffno = $_SESSION['user']['user'];

        // Fetch the user details from the hods table
        $query = "SELECT * FROM hods WHERE staffno = '$staffno'";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            // Build the user profile table
            $row = mysqli_fetch_assoc($result);
            $userProfile .= "<h2>User Profile</h2>";
            $userProfile .= "<table>";
            $userProfile .= "<tr><td>Name:</td><td>" . $row['name'] . "</td></tr>";
            $userProfile .= "<tr><td>Staff Number:</td><td>" . $row['staffno'] . "</td></tr>";
            $userProfile .= "<tr><td>Department:</td><td>" . $row['department'] . "</td></tr>";
            $userProfile .= "<tr><td>Gender:</td><td>" . $row['gender'] . "</td></tr>";
            $userProfile .= "<tr><td>Email:</td><td>" . $row['email'] . "</td></tr>";
            $userProfile .= "<tr><td>Phone Number:</td><td>" . $row['phone'] . "</td></tr>";
           
            $userProfile .= "</table>";
        } else {
            $userProfile = "No user profile found.";
        }
    } else {
        $userProfile = "No user profile found.";
    }

    // Set the session variable to display or hide the profile
    $_SESSION['displayProfile'] = true;
}

// Check if the hide button is clicked
if (isset($_POST['hideButton'])) {
    // Unset the session variable to hide the profile
    unset($_SESSION['displayProfile']);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>CUEA Online Clearance System - HOD Page</title>
	<link rel="stylesheet" type="text/css" href="student.css">
	<style>
       
       
	   #profileDisplay {
		   display: <?php echo isset($_SESSION['displayProfile']) ? 'block' : 'none'; ?>;
	   }
			   
   </style>

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
						<li><a href="registry_clearance_request.php">Check clearance request</a></li>
						<li><a href="registry_declined_report.php">declined clearance reports</a></li>
                        <li><a href="registry_accepted_report.php">Approved clearance reports</a></li>

					</ul>
				</li>
               
				
			</ul>
		</nav>
		<section>
          <h2>Welcome <?php echo $_SESSION['user']['user'] ?></h2>
			<p>Select a task from the sidebar to get started.</p>
		</section>
		<section>
            <?php if (isset($_SESSION['displayProfile'])) : ?>
            <form method="POST" action="">
                <button type="submit" name="hideButton">Hide Profile</button>
            </form>
            <div id="profileDisplay">
                <?php echo $userProfile; ?>
            </div>
            <?php else : ?>
            <form method="POST" action="">
                <button type="submit" name="displayButton">Display Profile</button>
            </form>
            <?php endif; ?>
        </section>
	</main>
	<footer>
        <p>&copy; 2023 CUEA Online Clearance System</p>
    </footer>
</body>
</html>
