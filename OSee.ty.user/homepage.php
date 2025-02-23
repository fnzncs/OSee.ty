<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user']['username'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Home</title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="css/home.css"/>
    <style>
        .Booking_button {
            text-align: center;
            margin-top: 20px;
        }

        #bookingButton {
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

        #bookingButton:hover {
            background-color: #007f45; /* Darker green */
        }

        /* Style for the scrollable event list */
        #eventList {
            max-height: 300px; /* Adjust height as needed */
            overflow-y: scroll;
            border: 1px solid #ccc; /* Optional: Add a border */
            padding: 10px; /* Optional: Add some padding */
        }

        .event-card {
            margin-bottom: 10px; /* Space between events */
        }

        .event-title {
            font-weight: bold;
        }

        .event-start-datetime,
        .event-end-datetime {
            font-size: 0.9em;
            color: black;
        }

        #notificationBox {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            transition: opacity 0.5s ease;
        }

        .notification-success {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        .notification-error {
            background-color: #f44336; /* Red */
            color: white;
        }

    </style>
</head>
<body>

<nav>
    <div class="logo">
        <a href="homepage.php"> <img src="image/Logo new 2.png" alt="Logo"/> </a>
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


<div class="main-banner">

    <div class="left-side-content">
        <div class="user-info">
            <span class="welcome-message" id="welcomeMessage">Welcome, <?php echo $username; ?>!</span><br>
            <span class="user-email" id="userEmail">Today's Date: <?php echo date("Y-m-d"); ?></span><br>
        </div>


        <div class="gallery">
            <div class="scroll-gallery" id="scrollGallery">
                <!-- Images will be dynamically added here -->
            </div>
        </div>

        <div class="events">
            <h2>Upcoming Events</h2>
            <div id="eventList">
                <!-- Events will be dynamically added here -->
            </div>
        </div>

    </div>

    <div class="right-side-content">
        <h1>Highlights</h1>

        <div class="r-side-modal-btn" onclick="openModal('midtermModal')">
            <h4>Semester Examination</h4>
        </div>

        <!-- HOLIDAYS BUTTON -->
        <div class="r-side-modal-btn" onclick="openModal('holidaysModal')">
            <h4>Holidays List</h4>
        </div>
    </div>


</div>

<!-- Modal for Semester Examination -->
<div id="midtermModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('midtermModal')">&times;</span>
        <h2>Semester Examination</h2>
        <table>
            <tr>
                <th>First Semester</th>
                <th>Second Semester</th>
            </tr>
            <tr>
                <td>Preliminary Examination (Sept 25-30 2023)</td>
                <td>Preliminary Examination (Feb 26 - March 2 2024)</td>
            </tr>
            <tr>
                <td>Midterm Examination (November 6-11 2023)</td>
                <td>Midterm Examination (April 5-8 & 11-13 2024)</td>
            </tr>
            <tr>
                <td>Finals Examination (Dec 11-16 2023)</td>
                <td>Finals Examination (May 13-18 2024) For 4th Year</td>
            </tr>
            <tr>
                <td></td>
                <td>Finals Examination (May 20-25 2024) For 1st-3rd Year</td>
            </tr>
        </table>
    </div>
</div>
<!-- Modal for Holidays List -->

<div id="holidaysModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('holidaysModal')">&times;</span>
        <h2>Holidays List</h2>
        <table>
            <tr>
                <td>Ninoy Aquino Day (August 21 2023)</td>
                <td>National Heroes Day (August 28 2023)</td>
                <td>Worlds teacher Day (October 5 2023)</td>
            </tr>
            <td>All Saint's Day (November 1 2023)</td>
            <td>All Soul's Day (November 2 2023)</td>
            <td>Bonifacio Day (November 27 2023)</td>
            </tr>
            <tr>
                <td>Institutional Christmas Party (December 18-19 2023)</td>
                <td>Chirstmas Eve (December 25 2023)</td>
                <td>People's Power Anniversary (February 25 2024)</td>
            </tr>
            <tr>
                <td>Foundation Week (March 18-23 2024)</td>
                <td>Holy Week (March 28-30)</td>
                <td>Araw ng Kagitingan (April 9 2024)</td>
            </tr>
            <tr>
                <td>Eid'l Fitr (April 10 2024)</td>
                <td>Labor Day (May 1 2024)</td>
                <td>Independence Day (June 12 2024)</td>
            </tr>
        </table>
    </div>
</div>


<script>
    // Function to open the modal
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    // Function to close the modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }
</script>
<div id="popupModal" class="popup-modal">
    <div class="popup-content">
        <span id="popupMessage" class="popup-message"></span>
    </div>
</div>





<script>
    document.addEventListener("DOMContentLoaded", async function () {
        fetch('fetch_user_data.php')
            .then(response => response.json())
            .then(userData => {
                const userName = userData.name; // Get user's name
                const todayDate = new Date().toDateString(); // Get today's date
                document.getElementById("welcomeMessage").textContent = "Welcome, " + userName + "!";
                document.getElementById("userEmail").textContent = "Today's Date: " + todayDate;
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                // Set a default value or message indicating error
                document.getElementById("welcomeMessage").textContent = "Welcome, Guest!";
                document.getElementById("userEmail").textContent = "Today's Date: " + new Date().toDateString();
            });

        // Display scroll gallery
        function displayGallery() {
            const scrollGallery = document.getElementById("scrollGallery");
            scrollGallery.innerHTML = ''; // Clear previous content

            const galleryImages = [
                "image/COMLAB2.png",
                "image/COMLAB3.png",
                "image/AVR.png",
                "image/CIRCULATION READING AREA.png",
                "image/FGRS.png",
                "image/GYM.png",
                "image/OPEN COURT.png"
            ];

            galleryImages.forEach(image => {
                const imgElement = document.createElement("img");
                imgElement.src = image;
                scrollGallery.appendChild(imgElement);
            });

            // Automatically change images in the gallery every 3 seconds
            let currentImageIndex = 0;
            setInterval(() => {
                currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
                const images = document.querySelectorAll('#scrollGallery img');
                images.forEach((img, index) => {
                    img.style.display = index === currentImageIndex ? 'block' : 'none';
                });
            }, 3000);
        }

        // Display events
        function fetchEvents() {
            fetch('fetch_events.php')
                .then(response => response.json())
                .then(eventsData => {
                    const eventList = document.getElementById("eventList");
                    eventList.innerHTML = '';

                    const now = new Date();

                    eventsData.forEach(event => {
                        const eventStart = new Date(event.start_datetime);
                        if (eventStart >= now) {
                            const eventCard = document.createElement("div");
                            eventCard.classList.add("event-card");

                            const eventTitle = document.createElement("div");
                            eventTitle.classList.add("event-title");
                            eventTitle.textContent = event.title;

                            const eventCompanyName = document.createElement("div");
                            eventCompanyName.classList.add("event-company-name");
                            eventCompanyName.textContent = `Course: ${event.company_name}`;


                            const eventStartDatetime = document.createElement("div");
                            eventStartDatetime.classList.add("event-start-datetime");
                            eventStartDatetime.textContent = `Start: ${event.start_datetime}`;

                            const eventEndDatetime = document.createElement("div");
                            eventEndDatetime.classList.add("event-end-datetime");
                            eventEndDatetime.textContent = `End: ${event.end_datetime}`;

                            eventCard.appendChild(eventTitle);
                            eventCard.appendChild(eventCompanyName);
                            eventCard.appendChild(eventStartDatetime);
                            eventCard.appendChild(eventEndDatetime);
                            eventList.appendChild(eventCard);
                        }
                    });
                });
        }

        // Initialize gallery and events
        displayGallery();
        fetchEvents();
    });
</script>
</body>
<script src="./js/popup.js"></script>
</html>