<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include PHPMailer
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$servername = "localhost";
$username = "kapil";
$password = "Kapilsharma123@";
$dbname = "event_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to increment alphabetic sequence
function incrementAlphabeticSequence($sequence) {
    $length = strlen($sequence);
    for ($i = $length - 1; $i >= 0; $i--) {
        if ($sequence[$i] < 'Z') {
            $sequence[$i] = chr(ord($sequence[$i]) + 1);
            return $sequence;
        }
        $sequence[$i] = 'A';
    }
    return str_repeat('A', $length);
}

// Validate and sanitize POST data
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch user input from POST data
    $firstname = sanitize_input($_POST["firstname"] ?? '');
    $lastname = sanitize_input($_POST["lastname"] ?? '');
    $email = sanitize_input($_POST["email"] ?? '');
    $mobile = "+91" . ltrim(sanitize_input($_POST["mobile"]), '0');
    $roll_no = sanitize_input($_POST["roll_no"] ?? '');
    $course = sanitize_input($_POST["course"] ?? '');
    $year = sanitize_input($_POST["year"] ?? '');
    $department = sanitize_input($_POST["department"] ?? '');
    $university = sanitize_input($_POST["university"] ?? '');

    // Check if the email already exists
    $emailCheckQuery = "SELECT email FROM users WHERE email = ?";
    $emailStmt = $conn->prepare($emailCheckQuery);
    $emailStmt->bind_param("s", $email);
    $emailStmt->execute();
    $emailStmt->store_result();

    if ($emailStmt->num_rows > 0) {
        echo "<script>alert('The email address you entered already exists. Please use a different email.'); window.location.href = 'registration.html';</script>";
        exit();
    }

    $emailStmt->close();

    // Generate unique ID with sequence
    $prefix = "REG2024";
    $result = $conn->query("SELECT unique_id FROM users WHERE unique_id LIKE '$prefix%' ORDER BY unique_id DESC LIMIT 1");

    if ($result && $row = $result->fetch_assoc()) {
        $lastId = $row['unique_id'];
        $lastSequence = substr($lastId, strlen($prefix));
        $newSequence = incrementAlphabeticSequence($lastSequence);
    } else {
        $newSequence = "AAAA";
    }

    $unique_id = $prefix . $newSequence;
    $otp = strval(rand(100000, 999999)); // 6-digit OTP

    // Insert the user details and OTP into the database
    $query = "INSERT INTO users (unique_id, firstname, lastname, email, mobile, roll_no, course, year, department, university, otp, verified) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssssssssss",
        $unique_id,
        $firstname,
        $lastname,
        $email,
        $mobile,
        $roll_no,
        $course,
        $year,
        $department,
        $university,
        $otp
    );

    if ($stmt->execute()) {
        // Send OTP email
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'p3plzcpnl506566.prod.phx3.secureserver.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'icgjust@iconnectgjust.in';
            $mail->Password = 'Kapilsharma123@';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email content
            $mail->setFrom('icgjust@iconnectgjust.in', 'Team iConnect');
            $mail->addAddress($email);
            $mail->Subject = 'Verify Your Email Address';
            $mail->isHTML(true);
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>
                    <h2 style='color: #4CAF50; text-align: center;'>Verify Your Email Address</h2>
                    <p style='text-align: center; font-size: 16px;'>Thank you for registering with us! Use the OTP below to verify your email:</p>
                    <div style='text-align: center; margin: 20px auto;'>
                        <div style='display: inline-block; padding: 15px 30px; background-color: #4CAF50; color: white; font-size: 24px; font-weight: bold; border-radius: 8px; letter-spacing: 5px;'>
                            $otp
                        </div>
                    </div>
                    <p style='text-align: center; font-size: 14px; color: #555;'>Please enter this OTP to verify your email.</p>
                </div>
            ";

            $mail->send();

            // Redirect to verification page
            header("Location: verify.php?email=" . urlencode($email));
            exit();
        } catch (Exception $e) {
            echo "Error sending OTP: " . $mail->ErrorInfo;
        }
    } else {
        echo "<p>Registration failed: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>





<!-- Add the following CSS for the popup -->
<style>
/* Popup Overlay */
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none; /* Hidden by default */
    z-index: 999;
}

/* Popup */
.popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    display: none; /* Hidden by default */
    z-index: 1000;
    text-align: center;
    max-width: 400px;
    width: 100%;
}

.popup h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.popup p {
    font-size: 18px;
}

.popup button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.popup button:hover {
    background-color: #45a049;
}

/* Responsive design */
@media (max-width: 768px) {
    .popup {
        width: 90%;
        max-width: 320px;
        padding: 15px;
    }

    .popup h2 {
        font-size: 20px;
    }

    .popup p {
        font-size: 16px;
    }

    .popup button {
        padding: 8px 16px;
    }
}

@media (max-width: 480px) {
    .popup {
        width: 90%;
        max-width: 280px;
        padding: 12px;
    }

    .popup h2 {
        font-size: 18px;
    }

    .popup p {
        font-size: 14px;
    }

    .popup button {
        padding: 8px 14px;
    }

    #copyBtn {
        margin-top: 10px;
        padding: 8px 14px;
    }
}
</style>

<!-- JavaScript for copying the Unique ID and redirecting to index.html -->
<script>
function copyUniqueId() {
    var uniqueId = document.getElementById("uniqueId").innerText;
    var textArea = document.createElement("textarea");
    textArea.value = uniqueId;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("copy");
    document.body.removeChild(textArea);
    alert("Unique ID copied to clipboard!");
    
    // Redirect to index.html after copying
    window.location.href = "index.html"; // Change this if you need to redirect to another page
}

function closePopup() {
    // Redirect to index.html when closing the popup
    window.location.href = "index.html"; // Change this if you need to redirect to another page
}
</script>