<!DOCTYPE html>
<html>
<head>
	<title>CUEA Online Clearance - Login</title>
	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
	<div class="card">
		<div class="header">
			<h1>CUEA Online Clearance</h1>
			<img src="logo.png" alt="CUEA Logo">
		</div>
		<div class="body">
			<form>
				<h2>Login</h2>
				<label for="username">Username</label>
				<select id="login-type" name="login-type">
					<option value="admin">Admin</option>
					<option value="staff">Staff</option>
					<option value="student">Student</option>
				</select>
				<input type="text" id="username" name="username" required>
				<label for="password">Password</label>
				<input type="password" id="password" name="password" required>
				<button type="submit">Sign In</button>
			</form>
			<a href="#">Forgot Password?</a>
		</div>
	</div>

	<?php
require_once 'connection.php'
$db = new mysqli("localhost", $username, $password, $database);

if (!$con) {
  echo "Unable to establish connection " . mysqli_connect_error();
}
else {
  $db = mysqli_select_db($con, "clearance");

  if (!$db) {
    echo "Database not found " . mysqli_error($con);
  }
  else {
    if (isset($_POST['type']) && isset($_POST['regno']) && isset($_POST['pass'])) {
      $type = $_POST['type'];
      $regno = mysqli_real_escape_string($con, $_POST['regno']);
      $password = mysqli_real_escape_string($con, $_POST['pass']);

      $query = "SELECT * FROM login WHERE regno='$regno' AND password='$password' AND type='$type'";
      $result = mysqli_query($con, $query);

      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['type'] == 'Admin') {
          header("Location: admin.php");
        }
        elseif ($row['type'] == 'Student') {
          header("Location: student.php?regno=".$row['regno']);
        }
        elseif ($row['type'] == 'Staff') {
          header("Location: staff.php?staffno=".$row['regno']);
        }
      } else {
        echo "Invalid login credentials";
      }
    }
  }
}
?>

</body>

</html>
