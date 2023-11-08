<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit account Record</title>
  <link rel="stylesheet" href="edit_student.css">
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>Edit account Record</h1>
    </div>
    <div class="form-container">
      <?php
        // Connect to the database
        require_once 'connection.php';
        $db = new mysqli("localhost", $username, $password, $database);

        if ($db->connect_error) {
          die("Connection failed: " . $db->connect_error);
        }

        // Retrieve the student record to be edited
        $user = $_GET['id'];
        $sql = "SELECT * FROM accounts WHERE user='$user'";
        $result = $db->query($sql);

        if ($result->num_rows == 1) {
          // Display the student record in a form for editing
          $row = $result->fetch_assoc();
          echo '<form action="update_account.php" method="post">';
          echo '<input type="hidden" name="user" value="'.$row["user"].'">';
          echo '<label for="user_type">user type:</label>';
          echo '<input type="text" name="name" value="'.$row["user_type"].'" required>';
          echo '<label for="password">password:</label>';
          echo '<input type="text" name="password" value="'.$row["password"].'" required>';
          
          echo '<button type="submit">Update Record</button>';
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