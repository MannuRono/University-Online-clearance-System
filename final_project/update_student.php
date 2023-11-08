<?php
// Connect to the database
require_once 'connection.php';
$db = new mysqli("localhost", $username, $password, $database);

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

// Retrieve the updated student record
$regno = $_POST['regno'];
$name = $_POST['name'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$mode = $_POST['mode'];
$year_entry = $_POST['year_entry'];
$year_exit = $_POST['year_exit'];

// Update the student record in the database
$sql = "UPDATE students SET name='$name', faculty='$faculty', department='$department', gender='$gender', email='$email', phone='$phone', mode='$mode', year_entry='$year_entry', year_exit='$year_exit' WHERE regno='$regno'";

if ($db->query($sql) === TRUE) {
  // Redirect to view_student.php with updated record
  header("Location: view_student.php?id=$regno");
  exit();
} else {
  echo "Error updating record: " . $db->error;
}

// Close the database connection
$db->close();
?>
