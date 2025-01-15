<?php
// Start session and connect to the database
session_start();
$conn = new mysqli('localhost', 'root', '', 'registration');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the user has already submitted their choices
$checkQuery = "SELECT * FROM choices_db WHERE user_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("i", $user_id);
$result = $stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If the user has already submitted their choices, redirect to the next step
    header("Location: additional_info.html");
    exit();
} else {
    // If the user has not filled this information, display the form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $st1 = $conn->real_escape_string($_POST["st1"]);
        $nd2 = $conn->real_escape_string($_POST["nd2"]);
        $rd3 = $conn->real_escape_string($_POST["rd3"]);
        $th4 = $conn->real_escape_string($_POST["th4"]);
        $th5 = $conn->real_escape_string($_POST["th5"]);

        // Corrected the insert query for the choices form
        $insertQuery = "INSERT INTO choices_db(user_id, st1, nd2, rd3, th4, th5) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("isssss", $user_id, $st1, $nd2, $rd3, $th4, $th5); // Correct binding


        if ($stmt->execute() === TRUE) {
            // Redirect to the next step after successful submission
            header("Location: additional_info.html");
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $stmt->error;
        }
    }
}
