<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Student Records</title>
  <link rel="stylesheet" href="view_student.css">
  <style>
    .home-button {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: darkorange;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <a href="admin.php" class="home-button">Home</a>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>Catholic University of East Africa</h1>
    </div>
    <div class="search-container">
      <form action="view_student.php" method="get">
        <label for="search">Search by Registration Number:</label>
        <input type="text" id="search" name="search">
        <button type="submit">Search</button>
      </form>
    </div>
    <div class="table-container">
      <?php
        // Connect to the database
        require_once 'connection.php';
        $db = new mysqli("localhost", $username, $password, $database);

        if ($db->connect_error) {
          die("Connection failed: " . $db->connect_error);
        }
        
        // Retrieve the student records from the database for students who stayed more than 4 years
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $currentYear = date("Y");
        if ($search != '') {
          $sql = "SELECT * FROM students WHERE regno = '$search' AND ($currentYear - year_entry) > 4";
        } else {
          $sql = "SELECT * FROM students WHERE ($currentYear - year_entry) > 4";
        }
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
          // Display the records in a table
          echo "<table>";
          echo "<tr><th>Index</th><th>Name</th><th>Registration Number</th><th>Faculty</th><th>Department</th><th>Gender</th><th>Email</th><th>Phone Number</th><th>Year of Entry</th><th>Expected Year of Exit</th></tr>";
          $index = 1;
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$index."</td>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["regno"]."</td>";
            echo "<td>".$row["faculty"]."</td>";
            echo "<td>".$row["department"]."</td>";
            echo "<td>".$row["gender"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["phone"]."</td>";
            echo "<td>".$row["year_entry"]."</td>";
            echo "<td>".$row["year_exit"]."</td>";
            echo "</tr>";
            $index++;
          }
          echo "</table>";
        } else {
          echo "No records found";
        }
        // Close the database connection
        $db->close();
      ?>
    </div>
  </div>
</body>
</html>
