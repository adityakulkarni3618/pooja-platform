<?php
// 1. Initial configuration
session_start();
error_reporting(0);
ini_set('display_errors', 0);

include 'lang_config.php';
include 'db_connect.php';

// Security: Only logged-in Guruji can save data
if (!isset($_SESSION['guruji_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Capture and Sanitize Text Data
    $title = $conn->real_escape_string($_POST['title']);
    $title_mr = $conn->real_escape_string($_POST['title_mr']); 
    $desc = $conn->real_escape_string($_POST['description']);
    $cost = intval($_POST['cost']);

    // 3. File Upload Logic (Cloud-Friendly)
    $target_dir = "uploads/";
    $img_path = "default_pooja.jpg"; // Default if upload fails

    if (!empty($_FILES["pooja_image"]["name"])) {
        // Create directory if it doesn't exist (May fail on Vercel, which is okay)
        if (!file_exists($target_dir)) { 
            @mkdir($target_dir, 0777, true); 
        }
        
        $file_name = time() . "_" . basename($_FILES["pooja_image"]["name"]);
        $target_file = $target_dir . $file_name;

        // Attempt move, but don't crash if cloud blocks it
        if (@move_uploaded_file($_FILES["pooja_image"]["tmp_name"], $target_file)) {
            $img_path = $target_file;
        }
    }

    // 4. Database Insertion
    // Note: We use title_mr which we added to your DB earlier
    $sql = "INSERT INTO poojas (title, title_mr, significance_description, base_dakshina, image_path) 
            VALUES ('$title', '$title_mr', '$desc', '$cost', '$img_path')";

    if ($conn->query($sql) === TRUE) {
        // Success redirect back to dashboard
        header("Location: guruji-dashboard.php?status=success&item=pooja");
        exit();
    } else {
        // Detailed error display for debugging
        echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='style.css'></head><body>";
        echo "<div class='content-section'>";
        echo "<h2 style='color:red;'>Database Error</h2>";
        echo "<p>Could not save Pooja. Please check if the 'title_mr' column exists in your table.</p>";
        echo "<pre>" . $conn->error . "</pre>";
        echo "<a href='admin-add-pooja.php' class='btn'>Go Back</a>";
        echo "</div></body></html>";
    }
} else {
    header("Location: admin-add-pooja.php");
    exit();
}
?>