<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php?error=session_expired");
    exit();
}
require_once("configdb.php");
$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reservation </title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="./css/bootstrap2.min.css">
    <link rel="stylesheet" href="./fullcalendar/lib/main.min2.css">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 80%;
            width: 100%;
            font-family: "century-gothic",  sans-serif;
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

        .status-accepted {
            color: green;
            font-weight: bold;
        }

        .status-denied {
            color: red;
            font-weight: bold;
        }

        .status-canceled {
            color: darkgoldenrod;
            font-weight: bold;
        }

        #customerButton {
            background-color: #007f45; /* Green background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 15px 32px; /* Some padding */
            text-align: center; /* Centered text */
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Make the container fit the button */
            font-size: 16px; /* Increase font size */
            margin: 4px 2px; /* Some margin */
            cursor: pointer; /* Pointer/hand icon */
            border-radius: 12px; /* Rounded corners */
        }

        #customerButton:hover {
            background-color: #007f45; /* Darker green */
        }
    </style>
</head>
<header>
<nav>
    <div class="logo">
        <link rel="stylesheet" href="./css/reservations.css" />
        <a href="homepage.php"><img src="image/Logo new 2.png" alt="Logo" /></a>
    </div>
    <div class="links">
      <ul>
        <li class="home"><a href="homepage.php">Home</a></li>
        <li class="map"><a href="map.php">Map</a></li>
        <li class="calendar"><a href="calendar.php">Reservation</a></li>
        <li class="customerservice"><a href="customerservice.php">Customer Service</a></li>
      </ul>
    </div>
    <div class="dropdown">
      <button class="dropbtn">
        <div class="profile-info">
          <span><?php echo htmlspecialchars($username); ?>'s Account</span>
        </div>
      </button>
      <div class="dropdown-content">
        <a href="history.php">History</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </nav>
</header>
<body>
<div class = "content">
    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar">
                </div>
            </div>
            <div class="col-md-3">
                <div class="side">
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
                                                <option value="BSTM">OSA</option>
                                                <option value="BSN">BSN</option>
                                                <option value="BSCRIM">BSCRIM</option>
                                                <option value="BEED">BEED</option>
                                                <option value="BSIT">BSIT</option>
                                                <option value="BSBA">BSBA</option>
                                                <option value="BSA">BSA</option>
                                                <option value="BSHM">BSHM</option>
                                                <option value="BSTM">BSTM</option>
                                                <option value="BSTM">THM</option>
                                                <option value="BSTM">HOTEL</option>
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
                                                <option value="Avr">Avr</option>
                                                <option value="Gym">Gym</option>
                                                <option value="Opencourt">Open Court</option>
                                                <option value="Convention">Convention</option>
                                                <option value="Ampi-Theater">Ampi-Theater</option>
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
                                            <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                                </form>
                            </div>
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
                            <!-- Display the status here -->
                            <dd id="status" class="fw-bold fs-4"></dd>
                            <!-- Other event details -->
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class=""></dd>
                            <dt class="text-muted">Contact Person</dt>
                            <dd id="fullname" class=""></dd>
                            <dt class="text-muted">Company Name</dt>
                            <dd id="company_name" class=""></dd>
                            <dt class="text-muted">Venue</dt>
                            <dd id="venue" class=""></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>
                            <!-- Separate section for cancellation reason -->
                            <dt class="text-muted">Cancellation Reason</dt>
                            <dd id="reason" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                    </div>
                    <div class="modal-footer rounded-0">
                        <div class="text-end" id="footer-buttons">
                            <!-- Close button will always be present -->
                            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>

                    <script>
                    // Function to handle book status and show/hide the Cancel Event button
                    function updateButton(status) {
                        const footer = document.getElementById('footer-buttons');

                        // Remove any previous cancel event button to ensure it's not present when denied
                        const cancelButton = document.getElementById('cancel-event');
                        if (cancelButton) {
                            cancelButton.remove();
                        }

                        if (status === 'accepted') {
                            // Only add the Cancel Event button if the status is 'accepted'
                            const cancelButton = document.createElement('button');
                            cancelButton.type = 'button';
                            cancelButton.classList.add('btn', 'btn-danger', 'btn-sm', 'rounded-0');
                            cancelButton.id = 'cancel-event';
                            cancelButton.textContent = 'Cancel Event';
                            footer.insertBefore(cancelButton, footer.firstChild);
                        }
                    }

                    // Example of updating the button based on book status
                    // Call this function with the appropriate status ('accepted' or 'denied')
                    updateButton('accepted');  // This will show the "Cancel Event" button
                    updateButton('denied');  // This will hide the "Cancel Event" button (button will not be added)
                    </script>

            </div>
        </div>
        <!-- Cancellation Request Modal -->
        <div class="modal fade" id="cancel-request-modal" tabindex="-1" aria-labelledby="cancelRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelRequestModalLabel">Cancellation Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="cancel-request-form" method="POST" action="cancel_event.php">
                            <div class="form-group">
                                <label for="reason" class="form-label">Reason for Cancellation</label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
                            </div>
                            <input type="hidden" id="cancel-event-id" name="id">
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Event Details Modal -->
<?php 
// Fetch schedule details along with status
$schedules = $conn->query("SELECT * FROM `processschedule_list`");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}
if(isset($conn)) $conn->close();
?>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>');
</script>
<script src="./js/script.js"></script>
</html>
