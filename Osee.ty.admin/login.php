<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> OSee.ty </title>
    <link rel="website icon" type="png" href="image/Logo School.png">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="Login">
    <div class="logo_login">
        <center><img src="image/Logo New.png" alt="Logo"></center>
    </div>
    <div class="wrapper">
        <form action="connect.php" method="post">
            <h1>Admin Login Panel </h1>
            <div class = "error-message">
                <?php
                session_start(); 
                if (isset($_SESSION['message']) && 
                !empty($_SESSION['message'])) {
                echo '<p class = "error">' . $_SESSION['message'] . 
                '</p>';
                unset($_SESSION['message']);
                }
                ?>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username">
                <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password">
                <i class="bx bxs-lock-alt"> </i>
            </div>
            <div class="login-link">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
    </div>
</div>
    <footer id="footer">
        <h2>&copy;2024 · <span class="design"> Privacy Policy </span> </h2>
    </footer>
</body>
</html>