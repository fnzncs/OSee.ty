<?php
session_start();
$server = "localhost"; 
$db_user = "root"; 
$db_pass = "mysql123";
$db_name = "oseety_db"; 

$conn = new mysqli($server, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass = $_POST["password"];
    $user = $_POST["username"];

    $username = mysqli_real_escape_string($conn, $user);
    $password = mysqli_real_escape_string($conn, $pass);
    $sql = "SELECT * FROM `login_tb` WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // Assuming login credentials are verified and correct
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = array(
            'id' => $user['id'], // Assuming 'id' is your user ID column
            'username' => $user['username'],
            // Add any other relevant user data here
        );
        header("Location: homepage.php");
        exit(); 
    } else {
        $_SESSION['message'] = "Incorrect username or password";
        header('Location: login.php');
        exit();
    }
} else {
    echo "Form not submitted";
}
mysqli_close($conn);
?>
