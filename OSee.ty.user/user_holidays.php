<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "osee_school_calendar";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM holidays ORDER BY holiday_date";
$result = $conn->query($sql);

$holidays = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $holidays[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($holidays);
?>
