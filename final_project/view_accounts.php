<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View accounts Records</title>
  <link rel="stylesheet" href="view_student.css">
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>Catholic University of East Africa</h1>
    </div>
    <div class="search-container">
      <form action="view_department.php" method="get">
        <label for="search">Search by User:</label>
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
          $sql = "SELECT * FROM accounts WHERE user = '$search'";
        } else {
          $sql = "SELECT * FROM accounts";
        }
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
          // Display the records in a table
          echo "<table>";
          echo "<tr><th>Index</th><th>User</th><th>User type</th><th>password</th><th>Action</th></tr>";
          $index = 1;
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$index."</td>";
            echo "<td>".$row["user"]."</td>";
            echo "<td>".$row["user_type"]."</td>";
            echo "<td>".$row["password"]."</td>";

           
            echo '<td><a href="edit_account.php?id='.$row["user"].'" class="edit">Edit</a> </td>';
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
