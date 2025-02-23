<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "osee_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `title`, `company_name`, `start_datetime`, `end_datetime` FROM `historyschedule_list` WHERE status='accepted'";
$result = $conn->query($sql);

$events = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = array(
            'title' => $row['title'],
            'company_name' => $row['company_name'],
            'start_datetime' => $row['start_datetime'], 
            'end_datetime' => $row['end_datetime']
        );
    }
}

$conn->close();
echo json_encode($events);
?>
