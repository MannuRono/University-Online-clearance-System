<?php
// Connect to the database
require_once 'connection.php';
$db = new mysqli("localhost", $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Retrieve the student record to be declined
$regno = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT * FROM library_clearancerequest WHERE regno='$regno'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Fetch the student's details
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $department = $row['department'];
    $faculty = $row['faculty'];
    $gender = $row['gender'];
    $email = $row['email'];

    // Check if the student is already cleared
    $checkQuery = "SELECT * FROM library_cleared WHERE regno='$regno'";
    $checkResult = $db->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $message = "<span style='color: red;'>The student has already been cleared.</span>";
    } else {
        // Insert the student's details into the library_declined table
        $insertQuery = "INSERT INTO library_declined (regno, name, department, faculty, gender, email) VALUES ('$regno', '$name', '$department', '$faculty', '$gender', '$email')";
        if ($db->query($insertQuery) === true) {
            // Delete the student record from library_clearancerequest table
            $deleteQuery = "DELETE FROM library_clearancerequest WHERE regno='$regno'";
            if ($db->query($deleteQuery) === true) {
                $message = "<span style='color: green;'>The student has been declined.</span>";
            } else {
                $message = "<span style='color: red;'>Error deleting student record: " . $db->error . "</span>";
            }
        } else {
            $message = "<span style='color: red;'>Error inserting student record: " . $db->error . "</span>";
        }
    }
} else {
    $message = "<span style='color: red;'>No student found with the provided registration number.</span>";
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Declined</title>
</head>
<body>
    <h1>Library Declined</h1>
    <p><?php echo $message; ?></p>
</body>
</html>
