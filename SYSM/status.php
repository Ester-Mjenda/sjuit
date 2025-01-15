<?php
// Start the session
session_start();

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'registration');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$checkQuery = "SELECT * FROM status_db WHERE user_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User already filled this step, redirect to choices
    header("Location: choices.html");
    exit();
} else {
    // If the user has not filled this information, process the form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $f4s = $conn->real_escape_string($_POST['f4s']);  // Number of form four seats
        $indexNumbers = [];  // Initialize an empty array to store index numbers

        // Loop through the form four index numbers and store them in the array
        for ($i = 1; $i <= $f4s; $i++) {
            $indexNoField = 'indexNo' . $i;  // Get dynamic field name like indexNo1, indexNo2, etc.
            if (isset($_POST[$indexNoField])) {
                $indexNo = $conn->real_escape_string($_POST[$indexNoField]);
                $indexNumbers[] = $indexNo;  // Add the index number to the array
            }
        }

        // Concatenate all index numbers into a single string, separated by commas
        $indexNoString = implode(',', $indexNumbers);
        $indexNumbersArray = explode(',', $row['indexNo']);


        // Insert the concatenated string into the 'status_db' table in one row
        $insertQuery = "INSERT INTO status_db(user_id, f4s, indexNo) VALUES(?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iss", $user_id, $f4s, $indexNoString);

        if ($stmt->execute() === TRUE) {
            header("Location: choices.html");
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $stmt->error;
        }
    }
}
