<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is logged in, so destroy the session and log them out
    session_destroy(); // Destroy all session data
    header("Location: login.php"); // Redirect to the login page or any other desired page
    exit();
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: login2.php");
    exit();
}
?>
