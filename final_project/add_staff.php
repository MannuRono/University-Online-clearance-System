<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Adding Staff form</title>
  <link rel="stylesheet" href="add_student.css">
  <style>
    .error-message {
      color: red;
    }
  </style>
  <script>
    function validateForm() {
      var nameInput = document.getElementById("name");
      var departmentInput = document.getElementById("department");
      var yearEntryInput = document.getElementById("year_entry");

      var nameError = document.getElementById("name-error");
      var departmentError = document.getElementById("department-error");
      var yearEntryError = document.getElementById("year_entry-error");

      nameError.innerHTML = "";
      departmentError.innerHTML = "";
      yearEntryError.innerHTML = "";

      var namePattern = /^[A-Za-z\s]{3,}$/;
      var currentYear = new Date().getFullYear();

      if (!namePattern.test(nameInput.value)) {
        nameError.innerHTML = "<span class='error-message'>Error: Name should contain at least 3 characters and only letters and spaces.</span>";
        return false;
      }

      if (!namePattern.test(departmentInput.value)) {
        departmentError.innerHTML = "<span class='error-message'>Error: Department should contain at least 3 characters and only letters and spaces.</span>";
        return false;
      }

      if (parseInt(yearEntryInput.value) > currentYear) {
        yearEntryError.innerHTML = "<span class='error-message'>Error: Year of Entry cannot be in the future.</span>";
        return false;
      }

      if (parseInt(yearEntryInput.value) < 1900 || isNaN(yearEntryInput.value)) {
        yearEntryError.innerHTML = "<span class='error-message'>Error: Invalid Year of Entry.</span>";
        return false;
      }
    }
  </script>
</head>
<body>
  <div class="card">
    <div class="form">
      <h2>Staff Registration Form</h2>
      <form action="" method="POST" onsubmit="return validateForm();">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required>
          <div class="error-message" id="name-error"></div>
        </div>
        <div class="form-group">
          <label for="staffno">Staff Number</label>
          <input type="text" id="staffno" name="staffno" required>
        </div>
        <div class="form-group">
          <label for="faculty">Faculty</label>
          <select id="faculty" name="faculty" required>
            <option value="">-- Select Faculty --</option>
            <option value="Engineering">Engineering</option>
            <option value="Science">Science</option>
            <option value="Arts">Arts</option>
            <option value="Law">Law</option>
          </select>
        </div>
        <div class="form-group">
          <label for="department">Department</label>
          <select id="department" name="department" required>
            <option value="">-- Select Department --</option>
            <option value="Finance">Finance</option>
            <option value="Science">Science</option>
            <option value="Arts">Arts</option>
            <option value="Library">Library</option>
            <option value="Clubs">Clubs</option>
            <option value="Law">Law</option>
          </select>
        </div>
        <div class="form-group">
          <label for="gender">Gender</label>
          <input type="radio" id="male" name="gender" value="male" required>
          <label for="male">Male</label>
          <input type="radio" id="female" name="gender" value="female" required>
          <label for="female">Female</label>
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
          <label for="year_entry">Year of Entry</label>
          <input type="number" id="year_entry" name="year_entry" required>
          <div class="error-message" id="year_entry-error"></div>
        </div>
        <button type="submit">Submit</button>
      </form>
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
  $staffno = $_POST["staffno"];
  $faculty = $_POST["faculty"];
  $department = $_POST["department"];
  $gender = $_POST["gender"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $year_entry = $_POST["year_entry"];

  // Validate the year of entry on the server side
  $currentYear = date("Y");
  if ($year_entry > $currentYear || $year_entry < 1900 || !is_numeric($year_entry)) {
    echo "<span class='error-message'>Error: Invalid Year of Entry.</span>";
    exit; // Stop execution
  }

  // Prepare and execute SQL query
  $sql = "INSERT INTO staff (name, staffno, faculty, department, gender, email, phone, year_entry)
          VALUES ('$name', '$staffno', '$faculty', '$department', '$gender', '$email', '$phone',  '$year_entry')";

  if ($db->query($sql) === TRUE) {
    echo "Staff record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db->error;
  }

  // Close database connection
  $db->close();
}
?>
</html>
