<?php
// 1. Initial configuration
session_start();
error_reporting(0);
ini_set('display_errors', 0);

include 'lang_config.php';
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Capture and Sanitize Form Data
    $pooja_id = intval($_POST['pooja_id']);
    $name = $conn->real_escape_string($_POST['full_name']); 
    $phone = $conn->real_escape_string($_POST['phone']);
    $date = $conn->real_escape_string($_POST['booking_date']);
    $time = $conn->real_escape_string($_POST['time_slot']);
    $address = $conn->real_escape_string($_POST['address']);
    
    $custom_name = isset($_POST['custom_pooja_name']) ? $conn->real_escape_string($_POST['custom_pooja_name']) : '';

    if ($pooja_id == 999 && !empty($custom_name)) {
        $status = 'pending_review';
        $final_address = "CUSTOM POOJA: " . $custom_name . " | " . $address;
    } else {
        $status = 'pending';
        $final_address = $address;
    }

    $devotee_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 

    // 5. Insert into Database
    $sql = "INSERT INTO bookings (devotee_id, pooja_id, booking_date, time_slot, exact_address, status) 
            VALUES ('$devotee_id', '$pooja_id', '$date', '$time', '$final_address', '$status')";

    // 6. UI for Success or Failure
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><link rel='stylesheet' href='style.css'></head><body>";
    echo "<nav class='navbar'><div class='logo'>🕉️ Pooja Seva</div></nav>";
    echo "<div class='content-section' style='display:flex; justify-content:center;'>";
    echo "<div class='card-box' style='max-width:600px; text-align:center; margin-top:50px; border-top: 8px solid #ff8c00;'>";

    if ($conn->query($sql) === TRUE) {
        if($status == 'pending_review') {
            echo "<h1 style='color: #ff8c00;'>✅ Request Sent for Review!</h1>";
            echo "<p style='font-size:1.1rem;'>Since this is a custom Pooja, Guruji will check the requirements and contact you at <strong>$phone</strong>.</p>";
        } else {
            echo "<h1 style='color: green;'>🙏 Booking Successful!</h1>";
            echo "<p style='font-size:1.1rem;'>Your request for the ritual has been sent to Guruji. Please wait for confirmation.</p>";
        }
        echo "<div style='margin-top:30px;'>";
        // CHANGED: href='/' ensures you go to the main home page without 404
        echo "<a href='/' class='btn' style='text-decoration:none;'>Back to Home</a>";
        echo "</div>";
    } else {
        echo "<h1 style='color: red;'>❌ Database Error</h1>";
        echo "<p>Something went wrong. Please try again.</p>";
        echo "<p style='font-size:0.8rem; color:#666;'>Error: " . $conn->error . "</p>";
        echo "<a href='/' class='btn' style='background:#666; text-decoration:none;'>Go Back Home</a>";
    }

    echo "</div></div></body></html>";
} else {
    header("Location: /");
    exit();
}
?>