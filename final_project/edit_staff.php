<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Staff Record</title>
  <link rel="stylesheet" href="edit_student.css">
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>Edit Staff Record</h1>
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
        $staffno = $_GET['id'];
        $sql = "SELECT * FROM staff WHERE staffno='$staffno'";
        $result = $db->query($sql);

        if ($result->num_rows == 1) {
          // Display the student record in a form for editing
          $row = $result->fetch_assoc();
          echo '<form action="update_staff.php" method="post">';
          echo '<input type="hidden" name="staffno" value="'.$row["staffno"].'">';
          echo '<label for="name">Name:</label>';
          echo '<input type="text" name="name" value="'.$row["name"].'" required>';
          echo '<label for="faculty">Faculty:</label>';
          echo '<input type="text" name="faculty" value="'.$row["faculty"].'" required>';
          echo '<label for="department">Department:</label>';
          echo '<input type="text" name="department" value="'.$row["department"].'" required>';
          echo '<label for="gender">Gender:</label>';
          echo '<input type="radio" name="gender" value="Male"'.($row["gender"] == "Male" ? ' checked' : '').'>Male';
          echo '<input type="radio" name="gender" value="Female"'.($row["gender"] == "Female" ? ' checked' : '').'>Female';
          echo '<label for="email">Email:</label>';
          echo '<input type="email" name="email" value="'.$row["email"].'" required>';
          echo '<label for="phone">Phone Number:</label>';
          echo '<input type="tel" name="phone" value="'.$row["phone"].'" required>';
          echo '<label for="year_entry">Year of Entry:</label>';
          echo '<input type="number" name="year_entry" value="'.$row["year_entry"].'" required>';
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