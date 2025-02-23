<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - History</title>
<link rel="website icon" type="png" href="image/Logo School.png">
<link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
<link rel="stylesheet" href="./css/history.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<style>
    .table-container {
        max-height: 600px; /* Adjust the height as needed */
        overflow-y: auto;
        overflow-x: auto;
    }
</style>
</head>
<body>

<div class="wrapper">
    <div id="sidebar">
        <div class="title"><a href="homepage.php"><img src="./image/Logo new 2.png" alt="Logo"></a></div>
        <ul class="list-items">
            <li><a href="homepage.php"> Home </a></li>
            <li><a href="dashboard.php"> Events </a></li>
            <li><a href="notification.php"> Pending Notification </a></li>
            <li><a href="history.php"> History </a></li>
            <li><a href="event.php"> Report </a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="text">
            <h1>History of Booking</h1>
        </div>
        <div class="table-container">
            <table border="1">
                <thead>
                    <th>Contact Person:</th>
                    <th>Email Address:</th>
                    <th>Course Department:</th>
                    <th>Event Name:</th>
                    <th>Event Venue:</th>
                    <th>Start Date:</th>
                    <th>End Date:</th>
                    <th>Status:</th>
                </thead>
                <tbody>
                    <?php
                        include('./connect/conn.php');
                        $currentMonth = date('m');
                        $query=mysqli_query($conn,"SELECT * FROM `historyschedule_list` WHERE MONTH(start_datetime) = $currentMonth");
                        while($row=mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['company_name']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['venue']; ?></td>
                        <td><?php echo $row['start_datetime']; ?></td>
                        <td><?php echo $row['end_datetime']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="export-button">
            <form action="export_excel.php" method="post">
                <button type="submit">Export to Excel</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>