<?php
    // Include the database connection file
    require_once 'connection.php';

    // Fetch the data from the "students" table and insert it into the "accounts" table
    $sql = "INSERT IGNORE INTO accounts (user, password, user_type)
            SELECT regno, regno, 'student' as user_type FROM students";
    if(mysqli_query($conn, $sql)) {
        // Fetch the data from the "staff" table and insert it into the "accounts" table
        $sql = "INSERT IGNORE INTO accounts (user, password, user_type)
                SELECT staffno, staffno, 'staff' as user_type FROM staff";
        if(mysqli_query($conn, $sql)) {
            // Fetch the data from the "admin" table and insert it into the "accounts" table
            $sql = "INSERT IGNORE INTO accounts (user, password, user_type)
                    SELECT user, user, 'Admin' as user_type FROM admins";
            if(mysqli_query($conn, $sql)) {
                // Display success message
                echo "All accounts have been updated.";
            } else {
                // Display error message
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            // Display error message
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Display error message
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
?>
