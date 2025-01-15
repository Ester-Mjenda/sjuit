<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'registration');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Initialize variables
$indexNo = "N/A";
$choices = ["N/A", "N/A", "N/A", "N/A", "N/A"];

// Fetch user index number and program choices
$sql_verify = "SELECT s.indexNo, c.st1, c.nd2, c.rd3, c.th4, c.th5
               FROM status_db s
               JOIN choices_db c ON s.user_id = c.user_id
               WHERE s.user_id = '$user_id'";
$result_verify = $conn->query($sql_verify);

// Check for SQL errors
if ($result_verify === false) {
    die("SQL error: " . $conn->error);
}

if ($result_verify->num_rows > 0) {
    $row = $result_verify->fetch_assoc();

    // Assign values from the fetched data
    $indexNo = $row['indexNo'];
    $choices = [$row['st1'], $row['nd2'], $row['rd3'], $row['th4'], $row['th5']];
} else {
    echo "Error: No data found for this user. Please ensure your details are correct.";
    exit();
}
// Handle form submission (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that the index number and all choices are filled
    if (!empty($indexNo) && !in_array("N/A", $choices)) {
        // Check if the user has already submitted
        $result_check = $conn->query("SELECT * FROM submit WHERE user_id='$user_id'");
        if ($result_check === false) {
            die("SQL error on check: " . $conn->error);
        }
        if ($result_check->num_rows > 0) {
            // Update submission status to 'complete'
            $sql_update = "UPDATE submit SET status='complete' WHERE user_id='$user_id'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Submission is successful!";
                exit();
            } else {
                echo "Error updating submission status: " . $conn->error;
            }
        } else {
            // Insert new submission record
            $sql_insert = "INSERT INTO submit (user_id, status) VALUES ('$user_id', 'complete')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Submission is successful!";
                exit();
            } else {
                echo "Error submitting application: " . $conn->error;
            }
        }
    } else {
        // For GET requests, show the current status
        if ($result_check->num_rows == 0) {
            // Insert initial pending status if no record exists
            $sql_insert = "INSERT INTO submit (user_id, status) VALUES ('$user_id', 'pending')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Application started. Status: Pending.";
            } else {
                echo "Error starting application: " . $conn->error;
            }
        } else {
            // Fetch the current submission status
            $row = $result_check->fetch_assoc();
            echo "Current application status: " . $row['status'];
            exit();
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SJUIT-OAS Submission</title>
    <link rel="icon" type="image/x-icon" href="Img/favicon.ico" />
    <link rel="stylesheet" href="submision-style.css" />
</head>

<body>
    <!-- Header Section -->
    <header id="header">
        <section class="logo">
            <div class="logo-1">
                <img src="img/flogo.png" alt="SJUIT Logo" />
            </div>
            <div class="logo-2">
                <h1>ST. JOSEPH UNIVERSITY IN TANZANIA (SJUIT)</h1>
                <h2>Online Application System (OAS)</h2>
            </div>
        </section>
        <section class="nav-links">
            <div class="nav-link1">
                <a href="status.html">Step 1</a>
                <a href="choices.html">Step 2</a>
                <a href="additional_info.html">Step 3</a>
                <a class="active" href="submision.php">Step 4</a>
                <a href="#" onclick="if (confirm('Are you sure you want to log out?')) document.getElementById('logoutForm').submit();">Log Out</a>
                <form id="logoutForm" action="logout.php" method="POST" style="display: none">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>" />
                </form>
            </div>
        </section>
    </header>

    <!-- Main Section -->
    <main id="main">
        <section class="form">
            <form action="submit.php" method="post" autocomplete="off">
                <h2>Submission</h2>
                <hr>
                <h4><strong>Verify your information before submission:</strong></h4>
                <p id="status">
                    <strong>Index Number:</strong>
                    <?php

                    // Display the index number
                    if ($indexNo !== "N/A") {
                        echo htmlspecialchars($indexNo) . '<br />';
                    } else {
                        echo "No index number found.<br />";
                    }
                    ?>
                    <br />
                    <strong>Your Selected Choices:</strong><br />
                    <?php
                    // Display the choices
                    foreach ($choices as $index => $choice) {
                        if ($choice !== "N/A") {
                            echo ($index + 1) . ". " . htmlspecialchars($choice) . "<br />";
                        } else {
                            echo "No choices selected.<br />";
                        }
                    }
                    ?>
                </p>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>© 2024 All Rights Reserved, SJUIT</p>
    </footer>
</body>

</html>