<?php
// Connect to the database
require_once 'connection.php';
$db = new mysqli("localhost", $username, $password, $database);

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

// Retrieve the updated account record
$user = $_POST['user'];
$user_type = $_POST['user_type'];
$password = $_POST['password'];
//$username = $_post['username']

// Update the account record in the database
$sql = "UPDATE accounts SET  password='$password' WHERE user='$user'";

if ($db->query($sql) === TRUE) {
  // Redirect to view_accounts.php with updated record
  header("Location: view_accounts.php?id=$user");
  exit();
} else {
  echo "Error updating record: " . $db->error;
}

// Close the database connection
$db->close();
?>
