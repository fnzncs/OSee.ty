<?php
session_start();

// Logic for accepting or denying booking requests by the admin

if($booking_accepted) {
    $_SESSION['message'] = "Your booking with ID: " . $id . " has been accepted."; // Updated to use 'id' field
} elseif($booking_denied) {
    $_SESSION['message'] = "Your booking with ID: " . $id . " has been denied."; // Updated to use 'id' field
}

header('Location: homepage.php');
exit();
?>