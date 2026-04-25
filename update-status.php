<?php
include 'db_connect.php';
session_start();

// 1. Security Check: Only logged-in Guruji can update status
if (!isset($_SESSION['guruji_id'])) {
    die("Access Denied: Unauthorized action.");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    // 2. Sanitize Inputs (Essential for Computer Engineering students!)
    $id = intval($_GET['id']); 
    $status = $conn->real_escape_string($_GET['status']);

    // 3. Valid Status Check (Optional but professional)
    $allowed_statuses = ['pending', 'confirmed', 'cancelled', 'pending_review'];
    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status type.");
    }

    // 4. Update the database
    $sql = "UPDATE bookings SET status='$status' WHERE booking_id=$id";

    if ($conn->query($sql) === TRUE) {
        // 5. Redirect back to dashboard with a success message
        header("Location: guruji-dashboard.php?msg=success");
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    header("Location: guruji-dashboard.php");
    exit();
}
?>