<?php
session_start();

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// If the user is not logged in, redirect to the login page with a return URL
if (!isLoggedIn()) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI']; // Save the current URL to redirect after login
    header('Location: login.php');
    exit();
}
?>
