<?php
// 1. Initial configuration
session_start();
error_reporting(0);
ini_set('display_errors', 0);

include 'db_connect.php';

// 2. Security Check: Only logged-in Guruji can update status
if (!isset($_SESSION['guruji_id'])) {
    die("Access Denied: Please log in to perform this action.");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    // 3. Sanitize Inputs
    $id = intval($_GET['id']); 
    $status = $conn->real_escape_string($_GET['status']);

    // 4. Valid Status Check
    $allowed_statuses = ['pending', 'confirmed', 'cancelled', 'pending_review'];
    if (!in_array($status, $allowed_statuses)) {
        header("Location: guruji-dashboard.php?msg=invalid_status");
        exit();
    }

    // 5. Update the database
    $sql = "UPDATE bookings SET status='$status' WHERE booking_id=$id";

    if ($conn->query($sql) === TRUE) {
        // 6. Redirect back to dashboard
        header("Location: guruji-dashboard.php?status=updated");
        exit();
    } else {
        // Styled error for debugging
        echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='style.css'></head><body>";
        echo "<div class='content-section' style='text-align:center;'>";
        echo "<h2>Error updating status</h2>";
        echo "<p>" . $conn->error . "</p>";
        echo "<a href='guruji-dashboard.php' class='btn'>Back to Dashboard</a>";
        echo "</div></body></html>";
    }
} else {
    header("Location: guruji-dashboard.php");
    exit();
}
?>