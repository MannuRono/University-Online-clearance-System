<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Registration Form</title>
  <link rel="stylesheet" href="add_student.css">
  <style>
    .error-message {
      color: red;
    }
    .success-message {
      color: green;
    }
  </style>
  
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="logo">
        <img src="logo.png" alt="University Logo">
      </div>
      <div class="title">
        <h1>Catholic University of Eastern Africa</h1>
      </div>
      <div class="form">
        <h2>Student Registration Form</h2>
        <form action="" method="POST" onsubmit="return validateForm();">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            <div class="error-message" id="name-error"></div>
          </div>
          <div class="form-group">
            <label for="regno">Registration Number</label>
            <input type="text" id="regno" name="regno" required>
            <div class="error-message" id="regno-error"></div>
          </div>
          <div class="form-group">
            <label for="faculty">Faculty</label>
            <select id="faculty" name="faculty" required>
              <option value="">-- Select Faculty --</option>
              <option value="Law">Law</option>
              <option value="Commerce">Commerce</option>
              <option value="Science">Science</option>
              <option value="Theology">Theology</option>
              <option value="Arts & Social Sciences">Arts and Social Sciences</option>
              <option value="Justice & Peace">Justice and Peace</option>
              
            </select>
          </div>
          <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department" required>
              <option value="">-- Select Department --</option>
              <option value="Community Health & Development">Community Health and Development</option>
              <option value="Computer Science & Information Science">Computer Science and Information Science</option>
              <option value="Mathematics & Actuarial Science">Mathematics and Actuarial Science</option>
              <option value="Arts & Social Sciences">Arts and Natural Sciences</option>
              <option value="Social Sciences and Development Studies">Social Sciences and Development Studies</option>
              <option value="Humanities">Humanities</option>
              <option value="Accounting & Finance">Accounting and Finance</option>
              <option value="Law">Law</option>

            </select>
            <div class="error-message" id="department-error"></div>
          </div>
          <div class="form-group">
            <label for="gender">Gender</label>
            <div class="radio-group">
              <input type="radio" id="male" name="gender" value="male" required>
              <label for="male">Male</label>
              <input type="radio" id="female" name="gender" value="female" required>
              <label for="female">Female</label>
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
          </div>
          <div class="form-group">
            <label for="mode">Mode of Study</label>
            <select id="mode" name="mode" required>
              <option value="">-- Select Mode of Study --</option>
              <option value="Full-Time">Full-Time</option>
              <option value="Part-Time">Part-Time</option>
            </select>
          </div>
          <div class="form-group">
            <label for="year_entry">Year of Entry</label>
            <input type="number" id="year_entry" name="year_entry"  required>
          </div>
          <div class="form-group">
            <label for="year_exit">Year of Exit</label>
            <input type="number" id="year_exit" name="year_exit"  required>
          </div>
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
</body>
<?php

// Establish a connection to the database
require_once 'connection.php';
$db = new mysqli("localhost", $username, $password, $database);

if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}




// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $name = $_POST["name"];
    $regno = $_POST["regno"];
    $faculty = $_POST["faculty"];
    $department = $_POST["department"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $mode = $_POST["mode"];
    $year_entry = $_POST["year_entry"];
    $year_exit = $_POST["year_exit"];


  // Additional validation for year of entry and exit
  $currentYear = date("Y");
  if ($year_entry > $currentYear) {
    echo '<div class="error-message">Error: Year of Entry cannot be in the future.</div>';
  } else if ($year_exit < ($year_entry + 3)) {
    echo '<div class="error-message">Error: Year of Exit should be at least 3 years after the Year of Entry.</div>';
  } else {
    // Prepare and execute SQL query
    $sql = "INSERT INTO students (name, regno, faculty, department, gender, email, phone, mode, year_entry, year_exit)
            VALUES ('$name', '$regno', '$faculty', '$department', '$gender', '$email', '$phone', '$mode', '$year_entry', '$year_exit')";

    if (mysqli_query($conn, $sql)) {
      echo '<div class="success-message">Student record created successfully</div>';
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
  }
}

?>
<script>
   function validateForm() {
  var nameInput = document.getElementById("name");
  var regnoInput = document.getElementById("regno");
  var departmentInput = document.getElementById("department");
  var yearEntryInput = document.getElementById("year_entry");
  var yearExitInput = document.getElementById("year_exit");

  var nameError = document.getElementById("name-error");
  var regnoError = document.getElementById("regno-error");
  var departmentError = document.getElementById("department-error");
  var yearEntryError = document.getElementById("year_entry-error");
  var yearExitError = document.getElementById("year_exit-error");

  nameError.innerHTML = "";
  regnoError.innerHTML = "";
  departmentError.innerHTML = "";
  yearEntryError.innerHTML = "";
  yearExitError.innerHTML = "";

  var namePattern = /^[A-Za-z\s]{3,}$/;
  var regnoPattern = /^[A-Za-z0-9]{3,}$/;
  var currentYear = new Date().getFullYear();

  if (!namePattern.test(nameInput.value)) {
    nameError.innerHTML = "Error: Name should contain at least 3 characters and only letters and spaces.";
    return false;
  }

  if (!regnoPattern.test(regnoInput.value)) {
    regnoError.innerHTML = "Error: Registration Number should contain at least 3 characters and only letters and numbers.";
    return false;
  }

  if (!namePattern.test(departmentInput.value)) {
    departmentError.innerHTML = "Error: Department should contain at least 3 characters and only letters and spaces.";
    return false;
  }

  c

  if (parseInt(yearExitInput.value) < 1900 || isNaN(yearExitInput.value) || parseInt(yearExitInput.value) < (parseInt(yearEntryInput.value) + 3)) {
    yearExitError.innerHTML = "Error: Year of Exit should be at least 3 years after the Year of Entry.";
    return false;
  }

  // Ensure year of entry is not in the future
  if (parseInt(yearEntryInput.value) > currentYear) {
    yearEntryError.innerHTML = "Error: Year of Entry cannot be in the future.";
    return false;
  }

  return true;
}

  </script>
</html>
