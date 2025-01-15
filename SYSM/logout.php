<?php
// Start the session
session_start();

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'registration');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and the form was submitted
if (isset($_SESSION['user_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];

    // Delete the user from the register table
    // $deleteUserQuery = "DELETE FROM register WHERE user_id = '$user_id'";
    $deleteStatusQuery = "DELETE FROM status_db WHERE user_id = '$user_id'";

    if ($conn->query($deleteStatusQuery) === TRUE) {
        // Optionally, delete user data from other related tables
        $deleteChoicesQuery = "DELETE FROM choices_db WHERE user_id = '$user_id'";
        $deleteAdditionalQuery = "DELETE FROM additional_db WHERE user_id = '$user_id'";
        $deleteSubmitQuery = "DELETE FROM submit WHERE user_id = '$user_id'";
        // $conn->query($deleteStatusQuery);
        $conn->query($deleteChoicesQuery);
        $conn->query($deleteAdditionalQuery);
        $conn->query($deleteSubmitQuery);



        // Destroy the session to log out the user
        session_destroy();

        // Redirect to the registration page or a confirmation page
        header("Location: soas.html");
        exit();
    } else {
        echo "Error deleting account: " . $conn->error;
    }
} else {
    echo "Error: User not logged in or invalid request.";
}

// Close the connection
$conn->close();
