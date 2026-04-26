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
    
    // Check if there is a custom name (from your custom request form)
    $custom_name = isset($_POST['custom_pooja_name']) ? $conn->real_escape_string($_POST['custom_pooja_name']) : '';

    // 3. Logic for Custom vs Standard Pooja
    if ($pooja_id == 999 && !empty($custom_name)) {
        $status = 'pending_review';
        // Prefixing address with custom name so Guruji sees it on his dashboard
        $final_address = "CUSTOM POOJA: " . $custom_name . " | " . $address;
    } else {
        $status = 'pending';
        $final_address = $address;
    }

    // 4. User Logic (Defaulting to 1 for guest/demo purposes)
    $devotee_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 

    // 5. Insert into Database
    $sql = "INSERT INTO bookings (devotee_id, pooja_id, booking_date, time_slot, exact_address, status) 
            VALUES ('$devotee_id', '$pooja_id', '$date', '$time', '$final_address', '$status')";

    // 6. UI for Success or Failure
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><link rel='stylesheet' href='style.css'></head><body>";
    echo "<div class='content-section' style='text-align:center; margin-top:100px;'>";

    if ($conn->query($sql) === TRUE) {
        if($status == 'pending_review') {
            echo "<h1 style='color: #ff8c00;'>✅ Request Sent for Review!</h1>";
            echo "<p style='font-size:1.1rem;'>Since this is a custom Pooja, Guruji will check the requirements and contact you at <strong>$phone</strong>.</p>";
        } else {
            echo "<h1 style='color: green;'>🙏 Booking Successful!</h1>";
            echo "<p style='font-size:1.1rem;'>Your request for the ritual has been sent to Guruji. Please wait for confirmation.</p>";
        }
        echo "<div style='margin-top:30px;'>";
        echo "<a href='index.php' class='btn' style='text-decoration:none; display:inline-block;'>Back to Home</a>";
        echo "</div>";
    } else {
        echo "<h1 style='color: red;'>❌ Database Error</h1>";
        echo "<p>Something went wrong. Please try again or contact support.</p>";
        echo "<p style='font-size:0.8rem; color:#666;'>Error: " . $conn->error . "</p>";
        echo "<a href='index.php' class='btn-small' style='background:#666;'>Go Back</a>";
    }

    echo "</div></body></html>";
} else {
    // If someone tries to access this file directly without posting a form
    header("Location: index.php");
    exit();
}
?>