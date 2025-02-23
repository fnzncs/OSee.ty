<?php
// Email Notification Script (send_email.php)
function sendBookingEmail($fullname, $email, $company_name, $title, $venue, $description, $start_datetime, $end_datetime, $status) {
    $admin_email = "franzkennethnaces@gmail.com"; // Change this to the actual admin email
    $subject = "New Booking Alert: $title";

    // Email message
    $message = "
        <h3>New Booking Received</h3>
        <p><strong>Booked by:</strong> $fullname</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Company/Department:</strong> $company_name</p>
        <p><strong>Event Title:</strong> $title</p>
        <p><strong>Venue:</strong> $venue</p>
        <p><strong>Description:</strong> $description</p>
        <p><strong>Start:</strong> $start_datetime</p>
        <p><strong>End:</strong> $end_datetime</p>
        <p><strong>Status:</strong> $status</p>
    ";

    // Email Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: franzkenneth.naces@olivarezcollege.edu.ph" . "\r\n";  // Change this to a valid sender email

    // Send Email
    mail($admin_email, $subject, $message, $headers);
}
?>
