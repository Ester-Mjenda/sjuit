<?php
// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'registration');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the user has already filled out the additional information
$checkQuery = "SELECT * FROM additional_db WHERE user_id = '$user_id'";
$result = $conn->query($checkQuery);

if ($result->num_rows > 0) {
    // If the user has already filled the form, redirect to the submission page
    header("Location: submision.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $region = $conn->real_escape_string($_POST["region"]);
    $district = $conn->real_escape_string($_POST["district"]);
    $dob = $conn->real_escape_string($_POST["dob"]);
    $name = $conn->real_escape_string($_POST["name"]);
    $countryCode = $conn->real_escape_string($_POST["countryCode"]);
    $phoneNo = $conn->real_escape_string($_POST["phoneNo"]);
    $location = $conn->real_escape_string($_POST["location"]);

    // Insert data into the database
    $sql = "INSERT INTO additional_db(user_id, region, district, dob, name, countryCode, phoneNo, location) 
            VALUES ('$user_id', '$region', '$district', '$dob', '$name', '$countryCode', '$phoneNo', '$location')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to submission page
        header("Location: submision.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
