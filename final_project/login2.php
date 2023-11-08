<!DOCTYPE html>
<html>
<head>
	<title>Online Clearance - Login</title>
	<link rel="stylesheet" type="text/css" href="login2.css">
</head>
<body>
	<div class="card">
		<div class="header">
			<h1>Online Clearance system</h1>
			<img src="logo.png" alt="CUEA Logo">
		</div>
		<div class="body">
			<form method="POST" action="login2.php">
				<h2>Login</h2>
				<label for="login-type">User Type</label>
				<select id="login-type" name="login-type">
					<option value="admin">Admin</option>
					<option value="staff">Staff</option>
					<option value="student">Student</option>
				</select>
				<label for="username">Username</label>
				<input type="text" id="username" name="username" required>
				<label for="password">Password</label>
				<input type="password" id="password" name="password" required>
				<button type="submit" name="submit">Sign In</button> <!-- submit used to submit the form -->
			</form>
		</div>
	</div>
</body>
</html>

<?php
require_once 'connection.php';

session_start(); // Start the session

if (isset($_POST['submit'])) {     //isset checks if the form has been submitted
    $user_type = $_POST['login-type'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM accounts WHERE user_type='$user_type' AND user='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result); // Fetch the user data

        if ($user_type == 'admin') {
            $_SESSION['user'] = $user; // Store the user data in a session variable
            header('Location: admin.php');
            exit;
        } else if ($user_type == 'staff') {
            $hodQuery = "SELECT * FROM hods WHERE staffno='$username'"; // Retrieve HOD details based on staffno
            $hodResult = mysqli_query($conn, $hodQuery);

            if (mysqli_num_rows($hodResult) == 1) {
                $hod = mysqli_fetch_assoc($hodResult);
                $_SESSION['user'] = $user; // Store the HOD data in a session variable

                $department = $hod['department'];

                // Redirect HOD to specific department page
                switch ($department) {
                    case 'Finance':
                        header('Location: finance.php');
                        exit;
                    case 'Registry':
                        header('Location: registry.php');
                        exit;
                    case 'Library':
                        header('Location: library.php');
                        exit;
                    case 'Clubs':
                        header('Location: clubs.php');
                        exit;
                    case 'Dean':
                        header('Location: dean.php');
                        exit;
                    default:
                        echo "Invalid department for HOD";
                        exit;
                }
            } else {
                echo "HOD details not found";
            }
        } else if ($user_type == 'student') {
            $_SESSION['user'] = $user; // Store the user data in a session variable
            header('Location: student2.php');
            exit;
        }
    } else {
        echo "Invalid username or password";
    }
}
?>
