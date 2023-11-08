<?php
// Connect to the database
require_once 'connection.php';
$db = new mysqli("localhost", $username, $password, $database);

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

// Retrieve the updated student record
$staffno = $_POST['staffno'];
$name = $_POST['name'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$year_entry = $_POST['year_entry'];

// Update the student record in the database
$sql = "UPDATE staff SET name='$name', faculty='$faculty', department='$department', gender='$gender', email='$email', phone='$phone',  year_entry='$year_entry' WHERE staffno='$staffno'";

if ($db->query($sql) === TRUE) {
  // Redirect to view_staff.php with updated record
  header("Location: view_staff.php?id=$staffno");
  exit();
} else {
  echo "Error updating record: " . $db->error;
}

// Close the database connection
$db->close();
?>
