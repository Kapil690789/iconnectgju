<?php
session_start();
header('Content-Type: application/json');
if (isset($_SESSION['unique_id'])) {
    echo json_encode(['logged_in' => true, 'unique_id' => $_SESSION['unique_id']]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>
