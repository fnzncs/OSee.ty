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
    <title>Admin - Homepage</title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="./css/homepage.css">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body>


<!-- SIDE BAR-->
<div class="wrapper">
    <div id="sidebar">
        <div class="title"><a href="homepage.php"><img src="./image/Logo new 2.png" alt="Logo"></a></div>
        <ul class="list-items">
            <li><a href="homepage.php"> Home </a></li>
            <li><a href="dashboard.php"> Events </a></li>
            <li><a href="notification.php"> Pending Notification </a></li>
            <li><a href="history.php"> History </a></li>
            <li><a href="event.php"> Venue </a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>


    <div class="content">

        <!-- LEFT SIDE CONTENT LIKE SLIDESHOW AND WELCOME ADMIN-->
        <div class="left-side-content">

            <!-- USER INFO LIKE WELCOME ADMIN-->
            <div class="user-info">
                <span class="welcome-message" id="welcomeMessage"></span><br>
                <span class="current-date" id="currentDate"></span><br>
            </div>

            <!-- SLIDE SHOW OF GALLERY-->
            <div class="gallery">
                <div class="scroll-gallery" id="scrollGallery"></div>
            </div>


            <!-- NOTIFICATIONS -->
            <div class="notification">
                <h2>Notification</h2>
                <div id="notify">
                    <!-- Notifications will be dynamically added here -->
                </div>
            </div>

        </div>

        <!-- FOR RIGHT SIDE CONTENT LIKE HIGHLIGHTS AND BUTTON MODAL-->
        <div class="right-side-content">

            <!-- TITLE HIGHLIGHTS-->
            <h1 class="title-highlights">Highlights</h1>

            <!-- SEMESTER EXAMINATION BUTTON-->
            <div class="midterm" onclick="openModal('midtermModal')">
                <h4>Semester Examination</h4>
            </div>

            <!-- HOLIDAYS BUTTON -->
            <div class="holidays" onclick="openModal('holidaysModal')">
                <h4>Holidays List</h4>
            </div>

        </div>


    </div>


</div>


<!-- Modal for Semester Examination -->
<div id="midtermModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('midtermModal')">&times;</span>
        <h2>Edit Semester Examination</h2>
        <form id="examScheduleForm">
            <input type="hidden" id="id" name="id">
            <table>
                <tr>
                    <th>Semester</th>
                    <th>Exam Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Year Level</th>
                </tr>
                <tr>
                    <td>
                        <select id="semester" name="semester">
                            <option value="">-----</option>
                            <option value="First">First Semester</option>
                            <option value="Second">Second Semester</option>
                        </select>
                    </td>
                    <td>
                        <select id="exam_type" name="exam_type">
                            <option value="">-----</option>
                            <option value="Preliminary">Preliminary</option>
                            <option value="Midterm">Midterm</option>
                            <option value="Finals">Finals</option>
                        </select>
                    </td>
                    <td><input type="date" id="start_date" name="start_date"></td>
                    <td><input type="date" id="end_date" name="end_date" ></td>
                    <td>
                        <select id="year_level" name="year_level" >
                            <option value="">-----</option>
                            <option value="All Level">All Level</option>
                            <option value="Freshman">Freshman</option>
                            <option value="Sophomore">Sophomore</option>
                            <option value="Junior">Junior</option>
                            <option value="Senior">Senior</option>
                        </select>
                    </td>
                </tr>
            </table>
            <button type="button" class="modal-btn" onclick="saveExamSchedule()">Save Changes</button>
        </form>
    </div>
</div>


<!-- Holiday Modal -->
<div id="holidaysModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('holidaysModal')">&times;</span>
        <h2>Edit Holiday</h2>
        <form id="holidayForm" action="update_holidays.php" method="POST" class="form-modal">
            <input type="hidden" id="id" name="id">
            <table>
                <tr>
                    <th>Holiday Name</th>
                    <th>Holiday Date</th>
                </tr>
                <tr>
                    <td><input type="text" id="holiday_name" name="holiday_name"></td>
                    <td><input type="date" id="holiday_date" name="holiday_date"></td>
                </tr>
            </table>

            <button type="button" onclick="saveHoliday()"
            class="modal-btn">Save Changes</button>
        </form>
    </div>
</div>

<script>
    /* FOR MODAL FUNCTION*/

    function openExamModal(examData) {
    console.log("Exam Data Received:", examData); // Debugging

    if (!examData.id) {
        console.error("Error: Missing exam ID!");
        return;
    }

    document.getElementById("id").value = examData.id;
    document.getElementById("semester").value = examData.semester;
    document.getElementById("exam_type").value = examData.exam_type;
    document.getElementById("start_date").value = examData.start_date;
    document.getElementById("end_date").value = examData.end_date;
    document.getElementById("year_level").value = examData.year_level;

    openModal("midtermModal");
    }

    function saveExamSchedule() {
    const id = document.getElementById("exam_id").value;
    const semester = document.getElementById("semester").value;
    const exam_type = document.getElementById("exam_type").value;
    const start_date = document.getElementById("start_date").value;
    const end_date = document.getElementById("end_date").value;
    const year_level = document.getElementById("year_level").value;

    console.log("Exam Data Before Submission:", {id, semester, exam_type, start_date, end_date, year_level}); // Debugging

    if (!id || !semester || !exam_type || !start_date || !end_date || !year_level) {
        alert("All fields are required.");
        return;
    }

    fetch("update_exam.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}&semester=${semester}&exam_type=${exam_type}&start_date=${start_date}&end_date=${end_date}&year_level=${year_level}`
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server Response:", data);
        alert(data);
        location.reload();
    })
    .catch(error => console.error("Error:", error));
}

    // Open Holiday Modal and populate fields
    function openHolidayModal(holidayData) {
    console.log("Received Holiday Data:", holidayData); // Debugging

    if (!holidayData || !holidayData.id) {
        console.error("Missing holiday ID!");
        alert("Error: Missing holiday ID!");
        return;
    }

    document.getElementById("id").value = holidayData.id;
    document.getElementById("holiday_name").value = holidayData.holiday_name;
    document.getElementById("holiday_date").value = holidayData.holiday_date;

    console.log("Modal Input Values:", {
        id: document.getElementById("id").value,
        holiday_name: document.getElementById("holiday_name").value,
        holiday_date: document.getElementById("holiday_date").value
    });

    openModal("holidaysModal");
    }

    // Save holiday changes (send update request)
    function saveHoliday() {
    const id = document.getElementById("id").value.trim();
    const holiday_name = document.getElementById("holiday_name").value.trim();
    const holiday_date = document.getElementById("holiday_date").value.trim();

    console.log("Saving Holiday Data:", { id, holiday_name, holiday_date });

    if (!id || !holiday_name || !holiday_date) {
        alert("All fields are required.");
        return;
    }

    fetch("update_holidays.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}&holiday_name=${holiday_name}&holiday_date=${holiday_date}`
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server Response:", data);
        alert(data);
        location.reload();
    })
    .catch(error => console.error("Error:", error));
    }



    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    /* END OF MODAL FUNCTION*/

</script>


<script>

    const date = new Date();
    const month = date.getMonth();
    const day = date.getDate();
    const year = date.getFullYear();
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    document.addEventListener("DOMContentLoaded", async function () {
        const today = `${months[month]} ${day}, ${year}`;

        const galleryImages = [
            "image/COMLAB2.png",
            "image/COMLAB3.png",
            "image/AVR.png",
            "image/CIRCULATION READING AREA.png",
            "image/FGRS.png",
            "image/GYM.png",
            "image/OPEN COURT.png"
        ];

        const userData = {
            name: '<?php echo $_SESSION['username']; ?>',
            email: 'user@example.com' // Replace with dynamic email if available
        };

        document.getElementById("welcomeMessage").textContent = "Welcome, " + userData.name + "!";
        document.getElementById("currentDate").textContent = today;

        function displayGallery() {
            const scrollGallery = document.getElementById("scrollGallery");
            scrollGallery.innerHTML = '';
            galleryImages.forEach(image => {
                const imgElement = document.createElement("img");
                imgElement.classList.add("imgslider")
                imgElement.src = image;
                scrollGallery.appendChild(imgElement);
            });
        }

        displayGallery();

        let currentImageIndex = 0;
        setInterval(() => {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            const images = document.querySelectorAll('.scroll-gallery img');
            images.forEach((img, index) => {
                if (index === currentImageIndex) {
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
            });
        }, 3000);

        async function fetchNotifications() {
            try {
                const response = await fetch('fetch_notifications.php');
                const notifications = await response.json();

                const notifyElement = document.getElementById('notify');
                notifyElement.innerHTML = '';

                if (notifications.length > 0) {
                    notifications.forEach(notification => {
                        const notificationDiv = document.createElement('div');
                        notificationDiv.classList.add('notification-item');

                        if (notification.title) {
                            notificationDiv.textContent = `${notification.title} is pending.`;
                        } else if (notification.id) {
                            notificationDiv.textContent = `Cancellation request (ID: ${notification.id}) on ${notification.request_date}: ${notification.reason}`;
                        }

                        notifyElement.appendChild(notificationDiv);
                    });
                } else {
                    notifyElement.textContent = 'No new notifications.';
                }
            } catch (error) {
                console.error('Error fetching notifications:', error);
                document.getElementById('notify').textContent = 'Error loading notifications.';
            }
        }

        fetchNotifications();
    });

    async function openExamModal() {
        try {
            const response = await fetch('user_exams.php'); // Fetch exam data from database
            const data = await response.json(); // Convert response to JSON

            if (data) {
                document.getElementById('exam_id').value = data.id || ''; // Ensure ID is set
                document.getElementById('semester').value = data.semester || '';
                document.getElementById('exam_type').value = data.exam_type || '';
                document.getElementById('start_date').value = data.start_date || '';
                document.getElementById('end_date').value = data.end_date || '';
                document.getElementById('year_level').value = data.year_level || '';
            } else {
                console.error("No data received for exams.");
            }

            openModal('midtermModal'); // Open the modal after data is set
        } catch (error) {
            console.error('Error fetching exam schedule:', error);
        }
    }

    async function openHolidaysModal(id) {
        fetch(`user_holidays.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                openHolidayModal(data);
            })
            .catch(error => console.error('Error fetching holiday details:', error));

        openModal('holidaysModal');
    }

</script>
</body>
</html>