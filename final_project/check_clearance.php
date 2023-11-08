<?php
session_start(); // Start the session
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login2.php'); // Redirect to login page if user is not logged in
    exit;
}

require_once 'connection.php'; // Connect to the database
$db = new mysqli("localhost", $username, $password, $database);


// Retrieve the registration number of the logged-in student
$regno = $_SESSION['user']['user'];

// Initialize the clearance progress array
$clearanceProgress = array();

// Check clearance progress in the finance_clearancerequest table
$sql = "SELECT * FROM finance_clearancerequest WHERE regno = '$regno'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $clearanceProgress['Finance'] = '<span class="pending">Pending</span>';
} else {
    // Check finance_declined table
    $sql = "SELECT * FROM finance_declined WHERE regno = '$regno'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $clearanceProgress['Finance'] = '<span class="declined">Declined</span>';
    } else {
        // Check finance_cleared table
        $sql = "SELECT * FROM finance_cleared WHERE regno = '$regno'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $clearanceProgress['Finance'] = '<span class="cleared">Cleared</span>';
        } else {
            $clearanceProgress['Finance'] = 'No clearance records found';
        }
    }
}

// Check clearance progress in the registry_clearancerequest table
$sql = "SELECT * FROM registry_clearancerequest WHERE regno = '$regno'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $clearanceProgress['Registry'] = '<span class="pending">Pending</span>';
} else {
    // Check registry_declined table
    $sql = "SELECT * FROM registry_declined WHERE regno = '$regno'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $clearanceProgress['Registry'] = '<span class="declined">Declined</span>';
    } else {
        // Check registry_cleared table
        $sql = "SELECT * FROM registry_cleared WHERE regno = '$regno'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $clearanceProgress['Registry'] = '<span class="cleared">Cleared</span>';
        } else {
            $clearanceProgress['Registry'] = 'No clearance records found';
        }
    }
}

// Check clearance progress in the library_clearancerequest table
$sql = "SELECT * FROM library_clearancerequest WHERE regno = '$regno'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $clearanceProgress['Library'] = '<span class="pending">Pending</span>';
} else {
    // Check library_declined table
    $sql = "SELECT * FROM library_declined WHERE regno = '$regno'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $clearanceProgress['Library'] = '<span class="declined">Declined</span>';
    } else {
        // Check library_cleared table
        $sql = "SELECT * FROM library_cleared WHERE regno = '$regno'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $clearanceProgress['Library'] = '<span class="cleared">Cleared</span>';
        } else {
            $clearanceProgress['Library'] = 'No clearance records found';
        }
    }
}

// Check clearance progress in the clubs_clearancerequest table
$sql = "SELECT * FROM clubs_clearancerequest WHERE regno = '$regno'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $clearanceProgress['Clubs'] = '<span class="pending">Pending</span>';
} else {
    // Check clubs_declined table
    $sql = "SELECT * FROM clubs_declined WHERE regno = '$regno'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $clearanceProgress['Clubs'] = '<span class="declined">Declined</span>';
    } else {
        // Check clubs_cleared table
        $sql = "SELECT * FROM clubs_cleared WHERE regno = '$regno'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $clearanceProgress['Clubs'] = '<span class="cleared">Cleared</span>';
        } else {
            $clearanceProgress['Clubs'] = 'No clearance records found';
        }
    }
}

// Check clearance progress in the dean_clearancerequest table
$sql = "SELECT * FROM dean_clearancerequest WHERE regno = '$regno'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $clearanceProgress['Dean'] = '<span class="pending">Pending</span>';
} else {
    // Check dean_declined table
    $sql = "SELECT * FROM dean_declined WHERE regno = '$regno'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $clearanceProgress['Dean'] = '<span class="declined">Declined</span>';
    } else {
        // Check dean_cleared table
        $sql = "SELECT * FROM dean_cleared WHERE regno = '$regno'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $clearanceProgress['Dean'] = '<span class="cleared">Cleared</span>';
        } else {
            $clearanceProgress['Dean'] = 'No clearance records found';
        }
    }
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CUEA Online Clearance System - Check Clearance Progress</title>
    <link rel="stylesheet" type="text/css" href="check_clearance.css">
    <style>
        .pending {
            color: orange;
        }

        .declined {
            color: red;
        }

        .cleared {
            color: darkgreen;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="CUEA Logo">
            <h1>CUEA Online Clearance System</h1>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </header>
    <main>
        <section>
            <h2>Welcome <?php echo $_SESSION['user']['user'] ?></h2>
            <form method="post" action="">
                <table>
                    <tr>
                        <th>Department</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($clearanceProgress as $department => $status): ?>
                        <tr>
                            <td><?php echo $department; ?></td>
                            <td><?php echo $status; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </section>
        <section class="contact-info">
    <h2>Contact Information</h2>
    <p>If you have any issues or inquiries, please feel free to contact the respective departments:</p>
    <ul>
        <li>Finance Department  :  <a href="mailto:finance@cuea.edu">finance@cuea.edu</a></li>
        <li>Registry Department :  <a href="mailto:registry@cuea.edu">registry@cuea.edu</a></li>
        <li>Library Department  :  <a href="mailto:library@cuea.edu">library@cuea.edu</a></li>
        <li>Clubs Department    :  <a href="mailto:clubs@cuea.edu">clubs@cuea.edu</a></li>
        <li>Dean's Office       :  <a href="mailto:dean@cuea.edu">dean@cuea.edu</a></li>
    </ul>
</section>

    </main>
</body>
</html>
