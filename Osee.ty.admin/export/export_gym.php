<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'database/connection.php'; // Adjust this path to your actual DB connection

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=GYM_Booking_Report.xls");

$venue = 'gym';
$output = fopen("php://output", "w");

// === Export History Schedule ===
fputcsv($output, ['History Schedule Bookings']); // Section Title
fputcsv($output, ['ID', 'Full Name', 'Email', 'Company Name', 'Title', 'Venue', 'Description', 'Start Date', 'End Date']); // Column Headers

$query1 = "SELECT id, fullname, email, company_name, title, venue, description, start_datetime, end_datetime FROM historyschedule_list WHERE venue = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("s", $venue);
$stmt1->execute();
$result1 = $stmt1->get_result();

while ($row = $result1->fetch_assoc()) {
    fputcsv($output, $row);
}

fputcsv($output, []); // Blank row for separation

// === Export Process Schedule ===
fputcsv($output, ['Process Schedule Bookings']); // Section Title
fputcsv($output, ['ID', 'Full Name', 'Email', 'Company Name', 'Title', 'Venue', 'Description', 'Contact', 'Start Date', 'End Date', 'Status']); // Column Headers

$query2 = "SELECT id, fullname, email, company_name, title, venue, description, contact, start_datetime, end_datetime, status FROM processschedule_list WHERE venue = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("s", $venue);
$stmt2->execute();
$result2 = $stmt2->get_result();

while ($row = $result2->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$stmt1->close();
$stmt2->close();
$conn->close();
?>
