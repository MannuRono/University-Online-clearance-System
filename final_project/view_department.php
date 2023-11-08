<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View departments Records</title>
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
      <form action="view_department.php" method="get">
        <label for="search">Search by Department name:</label>
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
        
        // Retrieve the student records from the database
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        if ($search != '') {
          $sql = "SELECT * FROM departments WHERE name = '$search'";
        } else {
          $sql = "SELECT * FROM departments";
        }
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
          // Display the records in a table
          echo "<table>";
          echo "<tr><th>Index</th><th>Department Name</th><th>Department Code</th><th>HOD</th><th>Staff NO</th><th>Department Email</th><th>Department Phone</th><th>Action</th></tr>";
          $index = 1;
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$index."</td>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["Depcode"]."</td>";
            echo "<td>".$row["HOD"]."</td>";
            echo "<td>".$row["staffno"]."</td>";
            echo "<td>".$row["depemail"]."</td>";
            echo "<td>".$row["depphone"]."</td>";
     
            echo '<td><a href="edit_department.php?id='.$row["Depcode"].'" class="edit">Edit</a> | <a href="delete_department.php?id='.$row["Depcode"].'" class="delete">Delete</a></td>';
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
