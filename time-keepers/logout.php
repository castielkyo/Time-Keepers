<?php
session_start();
require 'config.php';

// Set timezone to Philippine Time
date_default_timezone_set('Asia/Manila');

// Check if the user is logged in
if (isset($_SESSION["login"]) && $_SESSION["login"]) {
    $email = $_SESSION["email"];
    $logout_time = date('Y-m-d H:i:s');

    // Update the logout time in customer_logs
    $update_log = "UPDATE customer_logs SET logout_time = '$logout_time' WHERE email = '$email' AND logout_time IS NULL";
    mysqli_query($conn, $update_log);

    // End the session
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
} else {
    header('Location: login.php');
    exit();
}
?>
