<?php
require_once("./connect/conn.php");

// Fetch data from the database
$schedules = $conn->query("SELECT * FROM `historyschedule_list`");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
    $sched_res[] = $row;
}

// Close the database connection
if(isset($conn)) $conn->close();

// Generate CSV content
$csv_data = "`id`, `fullname`, `email`, `company_name`, `title`, `venue`, `description`, `start_datetime`, `end_datetime`, `status` \n";
foreach ($sched_res as $event) {
    $csv_data .= '"' . implode('","', $event) . '"' . "\n";
}

// Output headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=calendar_events.csv');

// Output CSV data
echo $csv_data;
?>
