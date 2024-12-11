<?php
session_start();

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    header("Location: login.html");
    exit;
}

echo "Welcome to the event registration page!";
?>
