<?php
// Connect to the database
require_once 'connection.php';
$db = new mysqli("localhost", $username, $password, $database);

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  
  // Prepare and execute the DELETE query
  $stmt = $db->prepare("DELETE FROM staff WHERE staffno = ?");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  
  // Check if the query was successful
  if ($stmt->affected_rows > 0) {
    // Redirect back to the view staff records page with a success message
    header("Location: view_staff.php?message=success");
    exit();
  } else {
    // Redirect back to the view staff records page with an error message
    header("Location: view_staff.php?message=error");
    exit();
  }
} else {
  // Redirect back to the view staff records page with an error message
  header("Location: view_staff.php?message=error");
  exit();
}

// Close the database connection
$db->close();
?>
