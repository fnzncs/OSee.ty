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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Avr Report</title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <link rel="stylesheet" href="./css/place.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);
        function drawCharts() {
            fetch('./database/getchar_avr.php?venue=avr')
                .then(response => response.json())
                .then(data => {
                    // Column Chart for AVR bookings (Monthly)
                    var monthlyData = google.visualization.arrayToDataTable([
                        ['Date', 'Bookings'],
                        ...data.monthlyReport.map(row => [row.date, row.count])
                    ]);

                    var monthlyOptions = {
                        title: 'AVR Bookings (Monthly)',
                        hAxis: {title: 'Date'},
                        vAxis: {title: 'Number of Bookings'}
                    };

                    var monthlyChart = new google.visualization.ColumnChart(document.getElementById('avr_monthly_chart'));
                    monthlyChart.draw(monthlyData, monthlyOptions);

                    // Column Chart for AVR bookings (Weekly)
                    var weeklyData = google.visualization.arrayToDataTable([
                        ['Date', 'Bookings'],
                        ...data.weeklyReport.map(row => [row.date, row.count])
                    ]);

                    var weeklyOptions = {
                        title: 'AVR Bookings (Weekly)',
                        hAxis: {title: 'Date'},
                        vAxis: {title: 'Number of Bookings'}
                    };

                    var weeklyChart = new google.visualization.ColumnChart(document.getElementById('avr_weekly_chart'));
                    weeklyChart.draw(weeklyData, weeklyOptions);

                    // Pie Chart for booking statuses (Daily)
                    var statusData = new google.visualization.DataTable();
                    statusData.addColumn('string', 'Department');
                    statusData.addColumn('number', 'Bookings');

                    for (const department in data.dailyReport) {
                        statusData.addRow([department, data.dailyReport[department]]);
                    }

                    var statusOptions = {
                        title: 'AVR Booking Statuses (Monthly)',
                        pieHole: 0.4,
                    };

                    var statusChart = new google.visualization.PieChart(document.getElementById('avr_status_chart'));
                    statusChart.draw(statusData, statusOptions);
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <div id="sidebar">
            <div class="title">
                <a href="homepage.php"><img src="./image/Logo new 2.png" alt="Logo"></a>
            </div>
            <ul class="list-items">
                <li><a href="homepage.php"> Home </a></li>
                <li><a href="dashboard.php"> Events </a></li>
                <li><a href="notification.php"> Pending Notification </a></li>
                <li><a href="history.php"> History </a></li>
                <li><a href="event.php"> Report </a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="main_body">
            <div class="title">
                <h1>Olivarez College Tagaytay</h1>
                <h2>AVR Map</h2>
                <div class="dropdownmap">
                    <button class="dropbtnmap">Venue</button>
                    <div class="dropdown-contentmap">
                        <a href="avr.php">Avr</a>
                        <a href="open_court.php">Open Court</a>
                        <a href="gym.php">Gym</a>
                        <a href="convention.php">Convention</a>
                        <a href="ampi_theater.php">Amphi-Theater</a>
                    </div>
                </div>
            </div>
            <div class="report daily_report">
                <h3>Booking Report</h3>
                <div id="avr_status_chart" style="width: 100%; height: 500px;"></div>

                <form action="./export/export_avr.php" method="POST" style="margin-top: 20px;">
                    <input type="hidden" name="venue" value="avr"> 
                    <button type="submit" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer;">
                        Export to Excel
                    </button>
                </form>
            </div>
            <div class="report weekly_report">
                <h3>Weekly Report</h3>
                <div id="avr_weekly_chart" style="width: 100%; height: 500px;"></div>
            </div>
            <div class="report monthly_report">
                <h3>Monthly Report</h3>
                <div id="avr_monthly_chart" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
</body>
</html>
