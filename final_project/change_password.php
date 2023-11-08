<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>change password</title>
  <link rel="stylesheet" href="edit_student.css">
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>change password</h1>
    </div>
    <div class="form-container">
    <?php


session_start();
// Connect to the database
require_once 'connection.php';

$db = new mysqli("localhost", $username, $password, $database);

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

if (!isset($_SESSION['user'])) {
  header('Location: login2.php'); // Redirect to login page if user is not logged in
  exit;
}

// Retrieve the 'regno' based on the user input
$user = $_SESSION['user']['user']; // Access the user value from the session variable
$sql = "SELECT * FROM accounts WHERE user='$user'";
$result = $db->query($sql);

if ($result->num_rows == 1) {
  // Display the student record in a form for editing
  $row = $result->fetch_assoc();
  echo '<form action="login2.php" method="post">';
  echo '<input type="hidden" name="user" value="' . $row["user"] . '">';

  // Add input for viewing the current password
  echo '<label for="current_password">Current Password:</label>';
  echo '<input type="password" name="current_password" value="' . $row["password"] . '" disabled>';
  
  // Add password input field with HTML5 validation
  echo '<label for="password">Enter new password:</label>';
  echo '<input type="password" name="password" pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$" title="Password must be at least 6 characters long and contain at least one letter, one number, and one special character." required>';

  // Add password confirmation input field
  echo '<label for="confirm_password">Confirm new password:</label>';
  echo '<input type="password" name="confirm_password" pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$" title="Password must be at least 6 characters long and contain at least one letter, one number, and one special character." required>';

  echo '<button type="submit">Change password</button>';
  echo '</form>';
} else {
  echo "No record found";
}
// Close the database connection
$db->close();
?>


    </div>
    </body>
    </html>