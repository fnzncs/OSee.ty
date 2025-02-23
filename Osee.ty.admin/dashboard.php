<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
require_once("./connect/conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="./css/bootstrap2.min.css">
    <link rel="stylesheet" href="./fullcalendar/lib/main.min2.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <script src="./js/script.js"></script>
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 80%;
            width: 100%;
            font-family: Apple Chancery, cursive;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }

        #calendar {
            margin-top: -520px;
            margin-left: 30px;
            width: 90%; /* Adjust as needed */
        }
        .card-header{
            margin-top:-520px;
        }
        .status-accepted {
            color: green;
            font-weight: bold;
        }
        .status-denied {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div id="sidebar">
        <div class="title"><a href="homepage.php"><img src="image/Logo new 2.png" alt="Logo"></a></div>
        <link rel="stylesheet" href="./css/dashboard.css">
        <ul class="list-items">
            <li><a href="homepage.php"> Home </a></li>
            <li><a href="dashboard.php"> Events </a></li>
            <li><a href="notification.php"> Pending Notification </a></li>
            <li><a href="history.php"> History </a></li>
            <li><a href="event.php"> Report </a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                            <div class="card-header bg-gradient bg-primary text-light">
                                <h5 class="card-title">Schedule Form</h5>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <form action="booked_schedule.php" method="post" id="schedule-form">
                                        <input type="hidden" name="id" value="">
                                        <div class="form-group mb-2">
                                            <label for="fullname" class="control-label">Contact Person</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="fullname" id="fullname" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="email" class="control-label">Email Address</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="email" id="email" required></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="company_name" class="control-label">Course Department</label>
                                            <select id="company_name" name="company_name" class="form-control form-control-sm rounded-0" required>
                                                <option value="none">---</option>
                                                <option value="BSN">BSN</option>
                                                <option value="BSCRIM">BSCRIM</option>
                                                <option value="BEED">BEED</option>
                                                <option value="BSIT">BSIT</option>
                                                <option value="BSHM">BSHM</option>
                                                <option value="BSTM">BSTM</option>
                                                <option value="BSTM">THM</option>
                                                <option value="BSBA">BSBA</option>
                                                <option value="BSA">BSA</option>
                                                <option value="OSA">OSA</option>
                                                <option value="HOTEL">HOTEL</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="title" class="control-label">Event Name</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="venue" class="control-label">Event Venue</label>
                                            <select id="venue" name="venue" class="form-control form-control-sm rounded-0" required>
                                            <option value="none">---</option>
                                                <option value="AVR">AVR</option>
                                                <option value="GYM">GYM</option>
                                                <option value="OPEN GYM">OPEN GYM</option>
                                                <option value="Convention">Convention</option>
                                                <option value="Amphi-Theater">Amphitheater</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="description" class="control-label">Event Details</label>
                                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="start_datetime" class="control-label">Start Date</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="end_datetime" class="control-label">End Date</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="status" class="control-label">Status</label>
                                            <select id="status" name="status" class="form-control form-control-sm rounded-0" required>
                                            <option value="none">---</option>
                                            <option value="accepted">Accepted</option>
                                            <option value="denied">Denied</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                    <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Status</dt>
                            <dd id="status" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class=""></dd>
                            <dt class="text-muted">Company Name</dt>
                            <dd id="company_name" class=""></dd>
                            <dt class="text-muted">Venue</dt>
                            <dd id="venue" class=""></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button-excel">
    <a href="export_calendar.php" class="button-export">Export to Excel</a>
    </div>
</div>
<!-- Event Details Modal -->
<?php 
$schedules = $conn->query("SELECT * FROM `historyschedule_list`");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}
?>
<?php 
if(isset($conn)) $conn->close();
?>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="./js/script.js"></script>
</html>
