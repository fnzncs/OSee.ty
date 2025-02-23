<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "osee_booking";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
  die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Fetch daily data
$dailyResult = $mysqli->query(" SELECT HOUR(start_datetime) as hour, COUNT(*) as count FROM historyschedule_list  WHERE venue = 'AVR' AND DATE(start_datetime) <= CURDATE() AND DATE(end_datetime) >= CURDATE() GROUP BY HOUR(start_datetime)");
$dailyData = [['Time', 'Bookings']];
while ($row = $dailyResult->fetch_assoc()) {
  $dailyData[] = [$row['hour'], (int)$row['count']];
}

// Fetch monthly data
$monthlyResult = $mysqli->query(" SELECT DAY(start_datetime) as day, COUNT(*) as count FROM historyschedule_list  WHERE venue = 'AVR' AND MONTH(start_datetime) <= MONTH(CURDATE()) AND MONTH(end_datetime) >= MONTH(CURDATE()) AND YEAR(start_datetime) <= YEAR(CURDATE()) AND YEAR(end_datetime) >= YEAR(CURDATE()) GROUP BY DAY(start_datetime)");
$monthlyData = [['Date', 'Bookings']];
while ($row = $monthlyResult->fetch_assoc()) {
  $monthlyData[] = [$row['day'], (int)$row['count']];
}

$mysqli->close();

echo json_encode(['daily' => $dailyData, 'monthly' => $monthlyData]);
?>
