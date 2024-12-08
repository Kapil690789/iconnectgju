<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "kapil";
$password = "Kapilsharma123@";
$dbname = "event_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_id = uniqid("user_");
    $firstname = $_POST["firstname"] ?? '';
    $lastname = $_POST["lastname"] ?? '';
    $email = $_POST["email"] ?? '';
    $mobile = $_POST["mobile"] ?? '';
    $roll_no = $_POST["roll_no"] ?? '';
    $course = $_POST["course"] ?? '';
    $year = $_POST["year"] ?? '';
    $department = $_POST["department"] ?? '';
    $university = $_POST["university"] ?? '';

    $stmt = $conn->prepare("INSERT INTO users (unique_id, firstname, lastname, email, mobile, roll_no, course, year, department, university) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $unique_id, $firstname, $lastname, $email, $mobile, $roll_no, $course, $year, $department, $university);

    if ($stmt->execute()) {
        echo "Registration successful. Your Unique ID: $unique_id";
    } else {
        echo "Error: " . $stmt->error;
        
    }

    $stmt->close();
    $conn->close();
}
?>