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
    $title = $conn->real_escape_string($_POST['title']);
    $cat = $conn->real_escape_string($_POST['category']);
    $content = $conn->real_escape_string($_POST['content_sanskrit']);
    $meaning = $conn->real_escape_string($_POST['meaning']);

    // 3. Database Insertion
    $sql = "INSERT INTO library_texts (title, category, content_sanskrit, meaning) 
            VALUES ('$title', '$cat', '$content', '$meaning')";

    if ($conn->query($sql) === TRUE) { 
        // Success redirect back to the add page
        header("Location: admin-add-library.php?status=success"); 
        exit();
    } else {
        // Styled Error Page for debugging
        echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='style.css'></head><body>";
        echo "<div class='content-section' style='text-align:center; margin-top:50px;'>";
        echo "<h2 style='color:red;'>❌ Database Error</h2>";
        echo "<p>Could not save Library entry. Check if table 'library_texts' exists.</p>";
        echo "<pre style='background:#eee; padding:10px;'>" . $conn->error . "</pre>";
        echo "<a href='admin-add-library.php' class='btn'>Try Again</a>";
        echo "</div></body></html>";
    }
} else {
    header("Location: admin-add-library.php");
    exit();
}
?>