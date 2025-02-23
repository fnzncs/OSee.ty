<?php
	include('./connect/conn.php');
	$id=$_GET['id'];
    $fullname=$_GET['fullname'];
	$email=$_GET['email'];
    $company_name=$_GET['company_name'];
    $title=$_GET['title'];
    $venue=$_GET['venue'];
    $description=$_GET['description'];
    $start_datetime=$_GET['start_datetime'];
    $end_datetime=$_GET['end_datetime'];

	mysqli_query($conn,"UPDATE `schedule_list` SET `fullname`='$fullname',`email`='$email',`company_name`='$company_name',`title`='$title`venue`='$venue',`description`='$description',`start_datetime`='$start_datetime',`end_datetime`='$end_datetime' WHERE id = '$id'");
	header('location:dashboard.php');
?>