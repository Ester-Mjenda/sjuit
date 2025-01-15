<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'registration');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $region = $_POST["region"];
    $district = $_POST["district"];
    $date = $_POST["date"];
    $name = $_POST["name"];
    $countryCode = $_POST["countryCode"];
    $phoneNo = $_POST["phoneNo"];
    $where = $_POST["where"];
    $sql = "INSERT INTO application (region, district, date, name, countryCode, phoneNo,where) VALUES ('$region', '$district', '$date', '$name', '$countryCode', '$phoneNo','$where')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        session_start();
        $_SESSION['region'] = $region;
        exit();
        header("Location:submision.html");
    } else {
        echo "Error: " . $sql . "<br />" .
            $conn->error;
    }
    $conn->close();
}
