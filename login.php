<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "Kapil123@";
$dbname = "event_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_id = $_POST["unique_id"] ?? '';
    $password = $_POST["password"] ?? '';

    $stmt = $conn->prepare("SELECT password FROM users WHERE unique_id = ?");
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["logged_in"] = true;
            $_SESSION["unique_id"] = $unique_id;
            header("Location: index.php");
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
