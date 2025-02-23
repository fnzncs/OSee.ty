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

// Fetch data for daily and monthly reports
$dailyReport = $pdo->query("SELECT status, COUNT(*) as count FROM historyschedule_list WHERE DATE(start_datetime) = CURDATE() GROUP BY status")->fetchAll();
$monthlyReport = $pdo->query("SELECT DATE(date) as date, COUNT(*) as count FROM historyschedule_list WHERE MONTH(start_datetime) = MONTH(CURRENT_DATE()) AND YEAR(start_datetime) = YEAR(CURRENT_DATE()) GROUP BY DATE(date)")->fetchAll();

$status = ['ACCEPTED', 'DENIED', 'CANCELLED'];
$statusCounts = array_fill_keys($status, 0);

foreach ($dailyReport as $row) {
    $statusCounts[$row['status']] = $row['count'];
}

$data = [
    'dailyReport' => $statusCounts,
    'monthlyReport' => $monthlyReport
];

echo json_encode($data);
?>
