<?php
  // Connect to the database
  require_once 'connection.php';
  $db = new mysqli("localhost", $username, $password, $database);

  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  // Get the updated department information from the form
  $Depcode = $_POST['Depcode'];
  $name = $_POST['name'];
  $HOD = $_POST['HOD'];
  $staffno = $_POST['staffno'];
  $depemail = $_POST['depemail'];
  $depphone = $_POST['depphone'];

  // Update the department record in the database
  $sql = "UPDATE departments SET name='$name', HOD='$HOD', staffno='$staffno', depemail='$depemail', depphone='$depphone' WHERE Depcode='$Depcode'";
  if ($db->query($sql) === TRUE) {
    // Redirect the user to view_department.php
    header("Location: view_department.php");
    exit;
  } else {
    echo "Error updating record: " . $db->error;
  }

  // Close the database connection
  $db->close();
?>
