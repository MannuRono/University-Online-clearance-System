<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CUEA clearance form</title>
  <link rel="stylesheet" href="edit_student.css">
  <style>
    .error-message {
      color: red;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="logo">
      <img src="logo.png" alt="University Logo">
    </div>
    <div class="title">
      <h1>Fill this clearance form</h1>
    </div>
    <div class="form-container">
      <?php
      session_start();
        // Connect to the database
        require_once 'connection.php';

        $db = new mysqli("localhost", $username, $password, $database);

        if ($db->connect_error) {
          die("Connection failed: " . $db->connect_error);
        }

        if (!isset($_SESSION['user'])) {
          header('Location: login2.php'); // Redirect to login page if user is not logged in
          exit;
        }

        // Retrieve the 'regno' based on the user input
        $user = $_SESSION['user']['user']; // Access the user value from the session variable
        $accountSql = "SELECT regno FROM students WHERE regno IN (SELECT user FROM accounts WHERE user='$user')";

        $accountResult = $db->query($accountSql);

        if ($accountResult->num_rows == 1) {
          $accountRow = $accountResult->fetch_assoc();
          $regno = $accountRow['regno'];

          // Check if the user has already submitted a clearance request
          $existingRequestSql = "SELECT * FROM clearance_request WHERE regno='$regno'";

          $existingRequestResult = $db->query($existingRequestSql);

          if ($existingRequestResult->num_rows > 0) {
            echo '<span class="error-message">You have already submitted a clearance request. Please check your clearance status in the dashboard.</span>';
          } else {
            // Retrieve the student record to be edited
            $studentSql = "SELECT * FROM students WHERE regno='$regno'";
            $studentResult = $db->query($studentSql);

            if ($studentResult->num_rows == 1) {
              // Check if the student has stayed for at least three years
              $studentRow = $studentResult->fetch_assoc();
              $yearEntry = $studentRow['year_entry'];

              $currentYear = date("Y");
              $yearsStudied = $currentYear - $yearEntry + 1; // Add 1 to include the current year

              if ($yearsStudied >= 3) {
                // Process the form submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  // Get the form data
                  $name = $_POST['name'];
                  $faculty = $_POST['faculty'];
                  $department = $_POST['department'];
                  $gender = $_POST['gender'];
                  $email = $_POST['email'];
                  $phone = $_POST['phone'];

                  // Insert the clearance request into the clearance_request table
                  $insertSql1 = "INSERT INTO clearance_request (regno, name, faculty, department, gender, email, phone) VALUES ('$regno', '$name', '$faculty', '$department', '$gender', '$email', '$phone')";

                  if ($db->query($insertSql1) === TRUE) {
                    // Insert the clearance request into the finance_clearancerequest table
                    $insertSql2 = "INSERT INTO finance_clearancerequest (regno, name, faculty, department, gender, email, phone) VALUES ('$regno', '$name', '$faculty', '$department', '$gender', '$email', '$phone')";

                    if ($db->query($insertSql2) === TRUE) {
                      // Insert the clearance request into the registry_clearancerequest table
                      $insertSql3 = "INSERT INTO registry_clearancerequest (regno, name, faculty, department, gender, email, phone) VALUES ('$regno', '$name', '$faculty', '$department', '$gender', '$email', '$phone')";

                      if ($db->query($insertSql3) === TRUE) {
                        // Insert the clearance request into the library_clearancerequest table
                        $insertSql4 = "INSERT INTO library_clearancerequest (regno, name, faculty, department, gender, email, phone) VALUES ('$regno', '$name', '$faculty', '$department', '$gender', '$email', '$phone')";

                        if ($db->query($insertSql4) === TRUE) {
                          // Insert the clearance request into the clubs_clearancerequest table
                          $insertSql5 = "INSERT INTO clubs_clearancerequest (regno, name, faculty, department, gender, email, phone) VALUES ('$regno', '$name', '$faculty', '$department', '$gender', '$email', '$phone')";

                          if ($db->query($insertSql5) === TRUE) {
                            // Insert the clearance request into the dean_clearancerequest table
                            $insertSql6 = "INSERT INTO dean_clearancerequest (regno, name, faculty, department, gender, email, phone) VALUES ('$regno', '$name', '$faculty', '$department', '$gender', '$email', '$phone')";

                            if ($db->query($insertSql6) === TRUE) {
                              echo '<span class="success-message">Clearance request submitted successfully!</span>';
                            } else {
                              echo '<span class="error-message">Error submitting the clearance request to dean_clearancerequest table: ' . $db->error . '</span>';
                            }
                          } else {
                            echo '<span class="error-message">Error submitting the clearance request to clubs_clearancerequest table: ' . $db->error . '</span>';
                          }
                        } else {
                          echo '<span class="error-message">Error submitting the clearance request to library_clearancerequest table: ' . $db->error . '</span>';
                        }
                      } else {
                        echo '<span class="error-message">Error submitting the clearance request to registry_clearancerequest table: ' . $db->error . '</span>';
                      }
                    } else {
                      echo '<span class="error-message">Error submitting the clearance request to finance_clearancerequest table: ' . $db->error . '</span>';
                    }
                  } else {
                    echo '<span class="error-message">Error submitting the clearance request to clearance_request table: ' . $db->error . '</span>';
                  }
                }

                // Display the form for requesting clearance
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="regno" value="'.$studentRow["regno"].'">';
                echo '<label for="name">Name:</label>';
                echo '<input type="text" name="name" value="'.$studentRow["name"].'" required>';
                echo '<label for="faculty">Faculty:</label>';
                echo '<input type="text" name="faculty" value="'.$studentRow["faculty"].'" required>';
                echo '<label for="department">Department:</label>';
                echo '<input type="text" name="department" value="'.$studentRow["department"].'" required>';
                echo '<label for="gender">Gender:</label>';
                echo '<input type="radio" name="gender" value="Male"'.($studentRow["gender"] == "Male" ? ' checked' : '').'>Male';
                echo '<input type="radio" name="gender" value="Female"'.($studentRow["gender"] == "Female" ? ' checked' : '').'>Female';
                echo '<label for="email">Email:</label>';
                echo '<input type="email" name="email" value="'.$studentRow["email"].'" required>';
                echo '<label for="phone">Phone Number:</label>';
                echo '<input type="tel" name="phone" value="'.$studentRow["phone"].'" required>';
                echo '<button type="submit">Request Clearance</button>';
                echo '</form>';
              } else {
                echo '<span class="error-message">You are not eligible to request clearance at this time.</span>';
              }
            } else {
              echo "No record found";
            }
          }
        } else {
          echo "User not found";
        }

        // Close the database connection
        $db->close();
      ?>
    </div>
  </div>
</body>
</html>
