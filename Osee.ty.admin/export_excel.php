<?php
// Database connection
include('./connect/conn.php');

// Query to fetch data
$currentMonth = date('m');
$query = mysqli_query($conn, "SELECT * FROM `historyschedule_list` WHERE MONTH(start_datetime) = $currentMonth");

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="booking_history_' . date('YmdHis') . '.xls"');

// Start creating Excel content
echo '<table border="1">';
echo '<thead>';
echo '<tr>';
echo '<th>Contact Person</th>';
echo '<th>Email Address</th>';
echo '<th>Course Department</th>';
echo '<th>Event Name</th>';
echo '<th>Event Venue</th>';
echo '<th>Start Date</th>';
echo '<th>End Date</th>';
echo '<th>Status</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Fetch data from database and output rows
while ($row = mysqli_fetch_array($query)) {
    echo '<tr>';
    echo '<td>' . $row['fullname'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['company_name'] . '</td>';
    echo '<td>' . $row['title'] . '</td>';
    echo '<td>' . $row['venue'] . '</td>';
    echo '<td>' . $row['start_datetime'] . '</td>';
    echo '<td>' . $row['end_datetime'] . '</td>';
    echo '<td>' . $row['status'] . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

// Close database connection
mysqli_close($conn);
?>
