<?php
// cancel_event.php

require_once('configdb.php');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'No data to save.']);
    $conn->close();
    exit;
}

// Get data from POST request
$id = isset($_POST['id']) ? $_POST['id'] : '';
$reason = isset($_POST['reason']) ? $_POST['reason'] : '';

// Debugging output
error_log("Received ID: " . print_r($id, true)); // Log received ID
error_log("Received Reason: " . print_r($reason, true)); // Log received Reason

// Check if both id and reason are received correctly
if (empty($id) || empty($reason)) {
    error_log("Missing ID or Reason. ID: " . print_r($id, true) . ", Reason: " . print_r($reason, true));
    echo json_encode(['status' => 'error', 'message' => 'Missing id or reason.']);
    $conn->close();
    exit;
}

// Check if the event exists in historyschedule_list and fetch details
$check_sql = "SELECT * FROM `historyschedule_list` WHERE `id` = ?";
error_log("SQL Query: " . $check_sql . " with ID: " . $id); // Log the SQL query being executed

$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param('i', $id);
$check_stmt->execute();
$result = $check_stmt->get_result();

// Check if the event exists
if ($result->num_rows === 0) {
    error_log("Event with ID $id not found in historyschedule_list.");
    echo json_encode(['status' => 'error', 'message' => 'Event not found in history.']);
    $conn->close();
    exit;
}

// Check if a cancellation request already exists for this event
$check_request_sql = "SELECT * FROM `cancellation_requests` WHERE `id` = ?";
$check_request_stmt = $conn->prepare($check_request_sql);
$check_request_stmt->bind_param('i', $id);
$check_request_stmt->execute();
$request_result = $check_request_stmt->get_result();

if ($request_result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'A cancellation request for this event has already been submitted.']);
    $conn->close();
    exit;
}

// Fetch the event details
$event = $result->fetch_assoc();
$title = $event['title'];
$fullname = $event['fullname'];
$email = $event['email'];
$company_name = $event['company_name'];
$start_datetime = $event['start_datetime'];
$end_datetime = $event['end_datetime'];
$venue = $event['venue'];
$description = $event['description'];

// Set status to 'REQUEST' for new bookings
$status = 'REQUEST';

// Prepare SQL statement to insert cancellation request
$insert_sql = "INSERT INTO `cancellation_requests` (`id`, `title`, `fullname`, `email`, `company_name`, `start_datetime`, `end_datetime`, `venue`, `reason`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param('isssssssss', $id, $title, $fullname, $email, $company_name, $start_datetime, $end_datetime, $venue, $reason, $status);

// Execute SQL statement
if ($insert_stmt->execute()) {
    error_log("Cancellation request inserted successfully.");
    echo json_encode(['status' => 'success']);
} else {
    error_log("Error inserting cancellation request: " . $insert_stmt->error);
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit cancellation request.']);
}

$conn->close();
?>
