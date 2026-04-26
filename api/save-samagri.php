<?php
// 1. Initial configuration
session_start();
error_reporting(0);
ini_set('display_errors', 0);

include 'db_connect.php';

// Security: Only logged-in Guruji can save data
if (!isset($_SESSION['guruji_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Capture and Sanitize Data
    $p_id = intval($_POST['pooja_id']); // Ensure ID is a number
    $item = $conn->real_escape_string($_POST['item_name']);
    $qty = $conn->real_escape_string($_POST['quantity']);
    $prov = $conn->real_escape_string($_POST['provided_by']);

    // 3. Database Insertion
    $sql = "INSERT INTO samagri_list (pooja_id, item_name, quantity, provided_by) 
            VALUES ($p_id, '$item', '$qty', '$prov')";

    if ($conn->query($sql) === TRUE) { 
        // Success redirect back to the entry page with a status
        header("Location: admin-add-samagri.php?status=success"); 
        exit();
    } else {
        // Styled Error Page for debugging
        echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='style.css'></head><body>";
        echo "<div class='content-section' style='text-align:center; margin-top:50px;'>";
        echo "<h2 style='color:red;'>❌ Database Error</h2>";
        echo "<p>Could not save Samagri item. Check if the table 'samagri_list' exists.</p>";
        echo "<pre style='background:#eee; padding:10px;'>" . $conn->error . "</pre>";
        echo "<a href='admin-add-samagri.php' class='btn'>Try Again</a>";
        echo "</div></body></html>";
    }
} else {
    header("Location: admin-add-samagri.php");
    exit();
}
?>