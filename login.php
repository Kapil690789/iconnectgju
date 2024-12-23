<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";  // Update with your DB username
$password = "Kapil123@";  // Update with your DB password
$dbname = "event_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_id = $_POST["unique_id"] ?? '';
    $password = $_POST["password"] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE unique_id = ?");
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $user_id;
            header("Location: dashboard.php");  // Redirect to dashboard or home page
            exit;
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "Unique ID not found!";
    }

    $stmt->close();
}

$conn->close();
?>
