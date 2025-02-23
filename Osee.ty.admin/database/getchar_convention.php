<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'osee_booking';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

// Get the venue from the query parameter
$venue = $_GET['venue'] ?? 'Convention';

// Fetch data for daily, weekly, and monthly reports
$dailyReport =  $pdo->prepare("SELECT status, COUNT(*) as count FROM historyschedule_list WHERE MONTH(start_datetime) = MONTH(CURRENT_DATE()) AND YEAR(start_datetime) = YEAR(CURRENT_DATE()) AND venue = ? GROUP BY status");
$dailyReport->execute([$venue]);
$dailyReportResults = $dailyReport->fetchAll();

$weeklyReport = $pdo->prepare("SELECT DATE(start_datetime) as date, COUNT(*) as count FROM processschedule_list WHERE WEEK(start_datetime) = WEEK(CURRENT_DATE()) AND venue = ? GROUP BY DATE(start_datetime)");
$weeklyReport->execute([$venue]);
$weeklyReportResults = $weeklyReport->fetchAll();

$monthlyReport = $pdo->prepare("SELECT DATE(start_datetime) as date, COUNT(*) as count FROM historyschedule_list WHERE MONTH(start_datetime) = MONTH(CURRENT_DATE()) AND YEAR(start_datetime) = YEAR(CURRENT_DATE()) AND venue = ? GROUP BY DATE(start_datetime)");
$monthlyReport->execute([$venue]);
$monthlyReportResults = $monthlyReport->fetchAll();

$status = ['ACCEPTED', 'DENIED', 'CANCELLED'];
$statusCounts = array_fill_keys($status, 0);

foreach ($dailyReportResults as $row) {
    $statusCounts[$row['status']] = $row['count'];
}

$data = [
    'dailyReport' => $statusCounts,
    'weeklyReport' => $weeklyReportResults,
    'monthlyReport' => $monthlyReportResults
];

echo json_encode($data);
?>
