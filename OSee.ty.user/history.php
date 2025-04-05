<?php
session_start();

// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php?error=session_expired");
    exit();
}

require_once('./conn/conn.php');
$username = $_SESSION['user']['username'];

$sql_company = "SELECT DISTINCT company_name FROM schedule_list WHERE company_name = ? 
                UNION 
                SELECT DISTINCT company_name FROM processschedule_list WHERE company_name = ?";
$stmt_company = $conn->prepare($sql_company);
$stmt_company->bind_param("ss", $username, $username);
$stmt_company->execute();
$result_company = $stmt_company->get_result();

if ($result_company->num_rows > 0) {
    $company_data = $result_company->fetch_assoc();
    $company_name = $company_data['company_name'];
} else {
    $company_name = null;
}

$stmt_company->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> History </title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <link rel="stylesheet" href="./css/historypage.css">
</head>
<body>
  <nav>
    <div class="logo">
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

  <div class="history">
    <div class="contents">
        <div class="table-container">
            <div class="table">
                <h2>Pending Booking </h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Contact Person</th>
                            <th>Course Department</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Event Venue</th>
                            <th>Event Details</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($company_name) {
                            $sql = "SELECT * FROM `schedule_list` WHERE `status` = 'Pending' AND `company_name` = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $company_name);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $venue_labels = [
                                'Open Court' => 'Open Court',
                                'Avr' => 'AVR',
                                'Gym' => 'Gym',
                                'Convention' => 'Convention',
                                'Ampi-Theater' => 'Ampi-Theater'
                            ];

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $venue = isset($venue_labels[$row['venue']]) ? $venue_labels[$row['venue']] : $row['venue'];
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['start_datetime']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_datetime']); ?></td>
                                <td><?php echo htmlspecialchars($venue); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No pending bookings no data founded</td></tr>";
                                }
                            } else { 
                                // This will run if $company_name is empty
                                echo "<tr><td colspan='8'>No pending bookings for your department</td></tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-container2">
            <div class="table2">
                <h2>Denied Booking</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Contact Person</th>
                            <th>Course Department</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Event Venue</th>
                            <th>Event Details</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($company_name) {
                            $sql_cancellation = "SELECT * FROM `processschedule_list` WHERE `status` = 'Cancelled' AND `company_name` = ?";
                            $stmt_cancel = $conn->prepare($sql_cancellation);
                            $stmt_cancel->bind_param('s', $company_name);
                            $stmt_cancel->execute();
                            $result_cancellation = $stmt_cancel->get_result();

                            if ($result_cancellation->num_rows > 0) {
                                while ($row_cancel = $result_cancellation->fetch_assoc()) {
                                    $venue_cancel = isset($venue_labels[$row_cancel['venue']]) ? $venue_labels[$row_cancel['venue']] : $row_cancel['venue']; 
                        ?>
                             <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['start_datetime']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_datetime']); ?></td>
                                <td><?php echo htmlspecialchars($venue); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='8'>No cancelled for your department</td></tr>";
                            }
                        } else { 
                            // This will run if $company_name is empty
                            echo "<tr><td colspan='8'></td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</body>
</html>
