<!DOCTYPE html>
<html>
<head>
    <title>Registry cleared Report</title>
    <style>
        /* Card Styles */
        .card {
            position: relative;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin: 20px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: orange;
        }
        
        /* Logo and University Name */
        .logo {
            max-width: 100px;
        }
        
        .university {
            font-size: 24px;
            margin-top: 10px;
        }
        .home-button {
        position: absolute;
        top: 10px;
        right: 10px;
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
    <div class="card">
        <img src="logo.png" alt="Logo" class="logo">
        <h1 class="university">Catholic University of Eastern Africa</h1>
        <a href="registry.php" class="home-button">Home</a>

        
        <?php
        // Connect to the database
        require_once 'connection.php';
        $db = new mysqli("localhost", $username, $password, $database);

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Retrieve data from the registry_declined table
        $sql = "SELECT * FROM registry_declined";
        $result = $db->query($sql);

        // Check if there are records
        if ($result->num_rows > 0) {
            echo "<h2>Registry declined Report</h2>";
            echo "<table>";
            echo "<tr><th>Registration Number</th><th>Name</th><th>Department</th><th>Faculty</th><th>Gender</th><th>Email</th></tr>";

            // Loop through each row and display the data
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['regno'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['faculty'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No records found in the registry_declined table.";
        }

        // Close the database connection
        $db->close();
        ?>
    </div>
</body>
</html>
