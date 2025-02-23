<?php
session_start();
$server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "oseety_db";

$conn = new mysqli($server, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a session variable containing the user's ID
if (isset($_SESSION['user']['id'])) {
    $userId = $_SESSION['user']['id']; // Assuming 'id' is the column name in your login_tb table

    $sql = "SELECT `username` FROM `login_tb` WHERE `id` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username);

    if ($stmt->fetch()) {
        $userData = array(
            'name' => $username,
        );

        echo json_encode($userData);
    } else {
        echo json_encode(array('name' => 'Guest')); // Default if user not found
    }

    $stmt->close();
} else {
    echo json_encode(array('name' => 'Guest')); // Default if session data not found
}

$conn->close();
?>
