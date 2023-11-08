<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Department Registration Form</title>
  <link rel="stylesheet" href="add_student.css">
  <style>
    .error-message {
      color: red;
    }
  </style>
  <script>
    function validateForm() {
      var nameInput = document.getElementById("name");
      var hodInput = document.getElementById("HOD");
      var emailInput = document.getElementById("depemail");

      var nameError = document.getElementById("name-error");
      var hodError = document.getElementById("hod-error");
      var emailError = document.getElementById("email-error");

      nameError.innerHTML = "";
      hodError.innerHTML = "";
      emailError.innerHTML = "";

      var namePattern = /^[A-Za-z]{3,}$/;

      if (!namePattern.test(nameInput.value)) {
        nameError.innerHTML = "Error: Department name should contain at least 3 characters.";
        return false;
      }

      if (!namePattern.test(hodInput.value)) {
        hodError.innerHTML = "Error: Head of Department name should contain at least 3 characters.";
        return false;
      }

      var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

      if (!emailPattern.test(emailInput.value)) {
        emailError.innerHTML = "Error: Invalid email format.";
        return false;
      }
    }
  </script>
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>University Name</h1>
    </div>
    <div class="form">
      <h2>Department Registration Form</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateForm();">
        <div class="form-group">
          <label for="name">Department name</label>
          <input type="text" id="name" name="name" pattern="[A-Za-z ]+" title="Only characters are allowed" required>
          <div class="error-message" id="name-error"></div>
        </div>
        <div class="form-group">
          <label for="Depcode">Department code</label>
          <input type="text" id="Depcode" name="Depcode" required>
        </div>
        <div class="form-group">
          <label for="HOD">Head Of Department</label>
          <input type="text" id="HOD" name="HOD" pattern="[A-Za-z ]+" title="Only characters are allowed" required>
          <div class="error-message" id="hod-error"></div>
        </div>
        <div class="form-group">
          <label for="staffno">Staff number</label>
          <input type="text" id="staffno" name="staffno" required>
        </div>
        <div class="form-group">
          <label for="depemail">Department Email</label>
          <input type="email" id="depemail" name="depemail" required>
          <div class="error-message" id="email-error"></div>
        </div>
        <div class="form-group">
          <label for="depphone">Department Phone Number</label>
          <input type="tel" id="depphone" name="depphone" pattern="[0-9]{10}" required>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

  <?php
  // Establish a connection to the database
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "admin_database";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Process form submission
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Retrieve form data
      $name = $_POST["name"];
      $Depcode = $_POST["Depcode"];
      $HOD = $_POST["HOD"];
      $staffno = $_POST["staffno"];
      $depemail = $_POST["depemail"];
      $depphone = $_POST["depphone"];

      // Input validations
      $namePattern = "/^[A-Za-z ]+$/";
      if (!preg_match($namePattern, $name)) {
          echo "<script>document.getElementById('name-error').innerHTML = 'Error: Department name should contain only characters.';</script>";
          exit;
      }

      if (!preg_match($namePattern, $HOD)) {
          echo "<script>document.getElementById('hod-error').innerHTML = 'Error: Head of Department name should contain only characters.';</script>";
          exit;
      }

      if (!filter_var($depemail, FILTER_VALIDATE_EMAIL)) {
          echo "<script>document.getElementById('email-error').innerHTML = 'Error: Invalid email format.';</script>";
          exit;
      }

      // Check if the staff with matching staffno and HOD name exists in the staff table
      $staffQuery = "SELECT * FROM staff WHERE staffno = '$staffno' AND name = '$HOD'";
      $staffResult = mysqli_query($conn, $staffQuery);

      if (mysqli_num_rows($staffResult) == 0) {
          echo "Error: Staff with staff number $staffno and HOD name $HOD does not exist.";
      } else {
          // Prepare and execute SQL query to insert department data
          $sql = "INSERT INTO departments (name, Depcode, HOD, staffno, depemail, depphone)
                  VALUES ('$name', '$Depcode', '$HOD', '$staffno', '$depemail', '$depphone')";

          if (mysqli_query($conn, $sql)) {
            echo '<span style="color: green;">Department created successfully</span>';
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }

      // Close database connection
      mysqli_close($conn);
  }
  ?>
</body>
</html>
