<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Kapil123@";
$dbname = "event_registration_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data from POST request
    $unique_id = uniqid(); // Generate a unique ID
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['firstname'] . " " . $_POST['lastname'];

    // Check if email already exists
    $check_email = $conn->prepare("SELECT * FROM user WHERE email=?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists!";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO user (unique_id, email, password, full_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $unique_id, $email, $password, $full_name);
        if ($stmt->execute()) {
            echo "User registered successfully!";
            header("Location: login.html");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>