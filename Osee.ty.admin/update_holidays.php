<?php
require './connect/conn_school_calendar.php';

// Log received POST data
file_put_contents("debug_holiday_log.txt", json_encode($_POST) . PHP_EOL, FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Log request method
    file_put_contents("debug_holiday_log.txt", "Request Method: " . $_SERVER["REQUEST_METHOD"] . PHP_EOL, FILE_APPEND);

    if (!isset($_POST['id']) || empty(trim($_POST['id']))) {
        die("Error: Missing or invalid 'id'. Received: " . json_encode($_POST));
    }

    $id = trim($_POST['id']);
    $holiday_name = trim($_POST['holiday_name']);
    $holiday_date = trim($_POST['holiday_date']);

    if (empty($holiday_name) || empty($holiday_date)) {
        die("All fields are required. Received: " . json_encode($_POST));
    }

    $query = "UPDATE holidays SET holiday_name=?, holiday_date=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $holiday_name, $holiday_date, $id);

    if ($stmt->execute()) {
        echo "Holiday updated successfully!";
    } else {
        echo "Error updating holiday.";
    }

    $stmt->close();
    $conn->close();
}
?>
