<?php
require './connect/conn_school_calendar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Log received data
    file_put_contents("debug_log.txt", json_encode($_POST) . PHP_EOL, FILE_APPEND);

    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("Error: Missing or invalid 'id'. Received: " . json_encode($_POST));
    }

    $id = $_POST['id'];
    $semester = $_POST['semester'];
    $exam_type = $_POST['exam_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $year_level = $_POST['year_level'];

    if (empty($semester) || empty($exam_type) || empty($start_date) || empty($end_date) || empty($year_level)) {
        die("All fields are required. Received: " . json_encode($_POST));
    }

    $query = "UPDATE examinations SET semester=?, exam_type=?, start_date=?, end_date=?, year_level=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $semester, $exam_type, $start_date, $end_date, $year_level, $id);

    if ($stmt->execute()) {
        echo "Exam schedule updated successfully!";
    } else {
        echo "Error updating exam schedule.";
    }
}
?>
