<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    include('./connect/conn.php');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update status to 'denied' in schedule_list table
    $query = "UPDATE `schedule_list` SET `status` = 'denied' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {

        // Move denied request to processschedule_list
        $query_move = "INSERT INTO `processschedule_list` (title, fullname, email, company_name, start_datetime, end_datetime, venue, description, status)
                       SELECT title, fullname, email, company_name, start_datetime, end_datetime, venue, description, status
                       FROM `schedule_list` WHERE id = ?";
        $stmt_move = mysqli_prepare($conn, $query_move);
        if (!$stmt_move) {
            die("Query preparation failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_move, "i", $id);
        if (!mysqli_stmt_execute($stmt_move)) {
            echo "Error: " . mysqli_stmt_error($stmt_move);
            exit;
        }

        // Duplicate denied request to historyschedule_list from processschedule_list
        $query_duplicate = "INSERT INTO `historyschedule_list` (title, fullname, email, company_name, start_datetime, end_datetime, venue, description, status)
                            SELECT title, fullname, email, company_name, start_datetime, end_datetime, venue, description, status
                            FROM `processschedule_list` WHERE id = ?";
        $stmt_duplicate = mysqli_prepare($conn, $query_duplicate);
        if (!$stmt_duplicate) {
            die("Query preparation failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_duplicate, "i", $id);
        if (!mysqli_stmt_execute($stmt_duplicate)) {
            echo "Error: " . mysqli_stmt_error($stmt_duplicate);
            exit;
        }

        $query_delete = "DELETE FROM `schedule_list` WHERE id = ?";
        $stmt_delete = mysqli_prepare($conn, $query_delete);
        if(!$stmt_delete) {
            die("Query preparation failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_delete, "i", $id);
        mysqli_stmt_execute($stmt_delete);

        session_start();
        $_SESSION['message'] = "Booking request denied"; // Set success message in session
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "No ID parameter provided.";
}
?>