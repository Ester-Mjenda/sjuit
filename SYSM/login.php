<?php
// Start the session
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "registration");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form input
    $indexNo = $_POST['indexNo'];
    $password = $_POST['password'];

    // Prepare SQL statement to select the user based on index number
    $sql = "SELECT * FROM register WHERE indexNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $indexNo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists with the entered index number
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate the expected password format for verification (0 + phone number)
        $fullPhone = '0' . $row['phoneNo']; // Add '0' to the stored phone number for verification
        if (password_verify($fullPhone, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];

            // Redirect to the next form based on their progress
            $checkStatusQuery = "SELECT * FROM status_db WHERE user_id = ?";
            $stmt = $conn->prepare($checkStatusQuery);
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $statusResult = $stmt->get_result();

            if ($statusResult->num_rows > 0) {
                // User has completed the status form, check if they have completed the choices form
                $checkChoicesQuery = "SELECT * FROM choices_db WHERE user_id = ?";
                $stmt = $conn->prepare($checkChoicesQuery);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $choicesResult = $stmt->get_result();

                if ($choicesResult->num_rows > 0) {
                    // User has completed the choices form, check if they have completed the additional info form
                    $checkAdditionalQuery = "SELECT * FROM additional_db WHERE user_id = ?";
                    $stmt = $conn->prepare($checkAdditionalQuery);
                    $stmt->bind_param("i", $_SESSION['user_id']);
                    $stmt->execute();
                    $additionalResult = $stmt->get_result();

                    if ($additionalResult->num_rows > 0) {
                        // User has completed the additional info form, redirect to the submission page
                        header("Location: submit.php");
                    } else {
                        // User has not completed the additional info form, redirect to the additional info form
                        header("Location: additional_info.html");
                    }
                } else {
                    // User has not completed the choices form, redirect to the choices form
                    header("Location: choices.html");
                }
            } else {
                // User has not completed the status form, redirect to the status form
                header("Location: status.html");
            }

            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that index number.";
        // Close the statement and connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SJUIT-OAS</title>
    <link rel="icon" type="image/x-icon" href="img/apple-touch-icon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="login-style.css" />
</head>

<body>
    <!-- Heading section -->
    <header id="header">
        <section class="logo">
            <div class="logo-1">
                <img src="img/flogo.png" />
            </div>
            <div class="logo-2">
                <h1>ST. JOSEPH UNIVERSITY IN TANZANIA (SJUIT)</h1>
                <h2>Online Application System<br /> (OAS)</h2>
            </div>
        </section>
        <section class="nav-links">
            <a href="soas.html">
                <img src="img/University (1).png" />
            </a>
            <div class="nav-link1">
                <a class="active" href="login.php">Login</a>
            </div>
        </section>
    </header>

    <!-- Main section -->
    <main id="main">
        <section class="form">
            <div class="form-1">
                <form action="login.php" method="post">
                    <h1>Login Form</h1>
                    <hr>
                    <!-- Error message display -->
                    <?php if (isset($error)) { ?>
                        <div class="error">
                            <p><?php echo $error; ?></p>
                        </div>
                    <?php } ?>

                    <!-- Form fields -->
                    <label for="index-No">Form IV Index No :</label><br />
                    <input type="text" id="index-No" name="indexNo" placeholder="S1722/0039/2020" autocomplete="off" required /><br />

                    <label for="password">Password :</label><br />
                    <input type="password" id="pwd" name="password" placeholder="********" autocomplete="off" required /><br />

                    <!-- Submit button -->
                    <input type="submit" id="login" value="Login" />


                </form>
            </div>
        </section>
    </main>

    <!-- Footer section -->
    <footer>
        <p>© 2024 All Rights Reserved, SJUIT</p>
    </footer>
</body>

</html>