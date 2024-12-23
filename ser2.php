<?php
// User's email address (received during registration)
$user_email = "kapil19092003@gmail.com"; // Replace this with the dynamic email from the registration process

// Email configuration
$to = $user_email; // Send email to the user's email address
$subject = "Welcome to Our Service!"; // Email subject
$message = "
<h1>Welcome to Our Service</h1>
<p>Dear User,</p>
<p>Thank you for registering. Here are your registration details:</p>
<ul>
    <li><strong>Email:</strong> $user_email</li>
    <li><strong>Account Created On:</strong> " . date("Y-m-d H:i:s") . "</li>
</ul>
<p>We hope you enjoy using our service!</p>
"; // Email body

// Email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: icgjust@iconnectgjust.in" . "\r\n";

// SMTP settings
ini_set("SMTP", "smtp.iconnectgjust.in"); // Replace with your SMTP host
ini_set("smtp_port", "587"); // SMTP port (587 for TLS, 465 for SSL)
ini_set("sendmail_from", "icgjust@iconnectgjust.in"); // Your email address

// Send email
if (mail($to, $subject, $message, $headers)) {
    echo "Registration details sent to $user_email successfully.";
} else {
    echo "Failed to send email to $user_email.";
}
?>
