<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "osee_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Fetch pending schedule notifications
$sql = "SELECT title, venue, start_datetime, end_datetime, status FROM schedule_list WHERE status = 'pending'";
$result = $conn->query($sql);

$notifications = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

// Fetch cancellation request notifications
$sql_cancel = "SELECT title, venue, start_datetime, end_datetime FROM cancellation_requests WHERE status = 'Request'";
$result_cancel = $conn->query($sql_cancel);

if ($result_cancel->num_rows > 0) {
    while($row_cancel = $result_cancel->fetch_assoc()) {
        $notifications[] = $row_cancel;
    }
}

$conn->close();

echo json_encode($notifications);
?>
