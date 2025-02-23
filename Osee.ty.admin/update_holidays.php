<?php
require './connect/conn_exam.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ID exists and is not empty
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("Error: Missing or invalid 'id'. Received: " . json_encode($_POST));
    }

    $id = $_POST['id'];
    $holiday_name = $_POST['holiday_name'];
    $holiday_date = $_POST['holiday_date'];

    // Prevent empty values
    if (empty($holiday_name) || empty($holiday_date)) {
        die("All fields are required.");
    }

    // Update the holiday in the database
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
