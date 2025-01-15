<?php
// Start the session and handle form submission
session_start();
$conn = new mysqli('localhost', 'root', '', 'registration');
$errorMsg = "";

// Check for database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $levels = $_POST["levels"];
    $awards = $_POST["awards"];
    $indexNo = $_POST["indexNo"];
    $email = $_POST["email"];
    $countryCode = $_POST["countryCode"];
    $phoneNo = $_POST["phoneNo"];

    // Concatenate country code and phone number to generate the password
    // Password Generation Logic
    $fullPhone = '0' . $phoneNo; // Prepend '0' to the phone number for the password
    $password = password_hash($fullPhone, PASSWORD_BCRYPT); // Hash the password

    // Check if a user with the same email or indexNo already exists
    $checkUserQuery = "SELECT * FROM register WHERE email = '$email' OR indexNo = '$indexNo'";
    $result = $conn->query($checkUserQuery);

    if ($result->num_rows > 0) {
        $errorMsg = "A user with the same email or index number already exists.";
    } else {
        // Insert user data into the database if no duplicate is found
        $sql = "INSERT INTO register (levels, awards, indexNo, email, countryCode, phoneNo, password) 
                VALUES ('$levels', '$awards', '$indexNo', '$email', '$countryCode', '$phoneNo', '$password')";

        if ($conn->query($sql) === TRUE) {
            $user_id = $conn->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['registration_success'] = true;  // Set session variable for success
            header('Location: register.php');  // Redirect to prevent form resubmission
            exit();
        } else {
            $errorMsg = "Error: " . $sql . "<br>" . $conn->error;  // Set error message if an issue occurs
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJUIT-OAS</title>
    <link rel="stylesheet" href="register-style.css" />
</head>

<body>
    <!-- Heading section -->
    <header id="header">
        <section class="title">
            <img src="img/flogo.png" />
            <div class="title-2">
                <h1>ST. JOSEPH UNIVERSITY IN TANZANIA (SJUIT)</h1>
                <h2>
                    Online Application System<br />
                    (OAS)
                </h2>
            </div>
        </section>
        <section class="nav-links">
            <div class="nav-links1">
                <a href="soas.html">
                    <img src="img/University (1).png" />
                </a>
            </div>
            <div class="nav-link2">
                <a class="active" href="register.php">Register</a>
            </div>
        </section>
    </header>
    <!-- Main section -->
    <main id="main">
        <?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success'] === true): ?>
            <!-- Display success message if registration is successful -->
            <div class="success-message">
                <h2>Registration successful! <a href="login.php">Login here</a></h2>
            </div>
            <?php unset($_SESSION['registration_success']); ?>
        <?php else: ?>
            <!-- Display the registration form if not submitted yet -->
            <section class="form">
                <div class="form-1">
                    <form action="" method="post" id="registrationForm" autocomplete="off">
                        <h1>Registration Form</h1>
                        <hr>

                        <?php if (!empty($errorMsg)): ?>
                            <div class="error-message">
                                <p><?php echo $errorMsg; ?></p>
                            </div>
                        <?php endif; ?>

                        <!-- Level of study -->
                        <label for="levels" class="levels">Choose the level of study you are applying for:</label><br />
                        <div class="radio">
                            <input type="radio" name="levels" value="Masters" required> Master Degree<br />
                            <input type="radio" name="levels" value="Degree" required> Bachelor Degree<br />
                            <input type="radio" name="levels" value="Diploma" required> Diploma<br />
                        </div>

                        <!-- Secondary education -->
                        <label for="S-Education">Secondary Education:</label><br />
                        <select name="awards" required>
                            <option value="" selected hidden>Select from here</option>
                            <option value="CSEE Awards">CSEE Award from NECTA</option>
                            <option value="Foreign/Equivalent">Foreign Certificate / Equivalent</option>
                        </select><br />

                        <!-- Index No -->
                        <label for="index-No">Form IV index No:</label><br />
                        <input type="text" id="index-No" placeholder="S1722/0039/2020" required name="indexNo"><br />

                        <!-- Email -->
                        <label for="email">Email Address:</label><br />
                        <input type="email" id="email" name="email" placeholder="example@gmail.com" required><br />

                        <!-- Phone number -->
                        <label for="phone_no">Active Phone Number:</label><br />
                        <input
                            type="country_code"
                            id="country_code"
                            name="countryCode"
                            pattern="^\+\d{3}$"
                            maxlength="4"
                            placeholder="+255"
                            required />
                        <input
                            type="tel"
                            id="phoneNo"
                            name="phoneNo"
                            pattern="^\d{9}$"
                            maxlength="9"
                            required
                            placeholder="759000000" /><br />

                        <!-- Password -->
                        <label for="password">Password:</label><br />
                        <input type="text" id="pwd" name="password" placeholder="Auto-filled" required readonly><br />

                        <!-- Submit button -->
                        <input type="submit" id="Register" value="Register">
                        <hr>
                        <div class="login">
                            <h3>If you already have an account</h3>
                            <a href="login.php">Login</a>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2024 All Rights Reserved, SJUIT</p>
    </footer>
    <!-- javascript -->
    <script>
        const phoneNoInput = document.getElementById('phoneNo');
        const passwordInput = document.getElementById('pwd');

        function updatePassword() {
            const fullPhone = '0' + phoneNoInput.value; // Always prefix '0' to phone number
            passwordInput.value = fullPhone;
        }

        phoneNoInput.addEventListener('input', updatePassword);
    </script>
</body>

</html>