<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// User is logged in
echo "Welcome to your dashboard!";
?>