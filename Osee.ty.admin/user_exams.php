<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "osee_school_calendar";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch examination data
$sql = "SELECT * FROM examinations ORDER BY semester, start_date";
$result = $conn->query($sql);

$examinations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $examinations[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($examinations);
?>
