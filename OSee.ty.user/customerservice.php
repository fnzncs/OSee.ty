<?php
session_start();

// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php?error=session_expired");
    exit();
}
$username = $_SESSION['user']['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service</title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="./css/customer.css">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
<div class="page">
    <div class="content">
        <section id="team">
            <div class="aboutus">
                <div class="card">
                    <img src="./image/Franz.jpg" />
                    <h2>Franz Naces</h2>
                    <p>Full-Stack Developer</p>
                    <div class="social-icons">
                        <a href="https://facebook.com/FranzKennethNaces21" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="mailto:franzkenneth.naces@olivarezcollege.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
                <div class="card">
                    <img src="./image/Ej.jpg" />
                    <h2>Emmanuel Salvacion</h2>
                    <p>Back-End Developer</p>
                    <div class="social-icons">
                        <a href="https://facebook.com/seisadkiddddd" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="mailto:emanueljoel.salvacion@olivarezcollege.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
                <div class="card">
                    <img src="./image/King.jpg" />
                    <h2>King Dangilan</h2>
                    <p>Front-End Developer</p>
                    <div class="social-icons"> 
                        <a href="https://facebook.com/Conquerre28" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="mailto:kingjeremiah.dangilan@olivarezcollegetagaytay.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="aboutus">
                <div class="card">
                    <img src="./image/Vaughn.jpg" />
                    <h2>Vaughn de Sagun</h2>
                    <p>Project Manager</p>
                    <div class="social-icons">
                        <a href="https://facebook.com/vndesagun" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="mailto:vaughnnicolai.desagun@olivarezcollege.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
                <div class="card">
                    <img src="./image/Mat.jpg" />
                    <h2>Matthew Bueno</h2>
                    <p>Capstone Adviser</p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/share/12De3K6Xewt/" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="mailto:matthew.bueno@olivarezcollegetagaytay.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
                <div class="card">
                    <img src="./image/Ainah.jpg" />
                    <h2>Ainah Cielos</h2>
                    <p>Quality Assurance</p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/share/1BVxtCXHHh/?mibextid=wwXIfr" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="mailto:ainahuziel.cielos@olivarezcollege.edu.ph"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <div class="button-container">
            <a href="homepage.php" class="btn">Return Home</a>
        </div>
    </div>
</div>
</body>
</html>
