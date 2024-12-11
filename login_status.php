<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    echo '<p>Logged in as <b>' . htmlspecialchars($_SESSION['unique_id']) . '</b>.</p>';
    echo '<a href="logout.php" class="btn btn-primary">Logout</a>';
} else {
    echo '<a href="registration.html" class="btn btn-primary">Login / Sign Up</a>';
}
?>
