<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student Record</title>
  <link rel="stylesheet" href="edit_student.css">
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>Edit Department Record</h1>
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
        $Depcode = $_GET['id'];
        $sql = "SELECT * FROM departments WHERE Depcode='$Depcode'";
        $result = $db->query($sql);

        if ($result->num_rows == 1) {
          // Display the student record in a form for editing
          $row = $result->fetch_assoc();
          echo '<form action="update_department.php" method="post">';
          echo '<input type="hidden" name="Depcode" value="'.$row["Depcode"].'">';
          echo '<label for="name">Department name:</label>';
          echo '<input type="text" name="name" value="'.$row["name"].'" required>';
          echo '<label for="HOD">Head of Department:</label>';
          echo '<input type="text" name="HOD" value="'.$row["HOD"].'" required>';
          echo '<label for="staffno">Staff number:</label>';
          echo '<input type="text" name="staffno" value="'.$row["staffno"].'" required>';
          echo '<label for="depemail">Department Email:</label>';
          echo '<input type="email" name="depemail" value="'.$row["depemail"].'" required>';
          echo '<label for="depphone">Department Phone Number:</label>';
          echo '<input type="tel" name="depphone" value="'.$row["depphone"].'" required>';
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