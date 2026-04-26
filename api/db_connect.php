<?php
// Filess.io Connection Details
$host = "8gb2xk.h.filess.io";
$user = "pooja_platform_db_meantskill";
$pass = "9471475cf7ce2172cc4215d237b5e90200e2d0bf";
$dbname = "pooja_platform_db_meantskill";
$port = 3307;

// Initialize the status variable
$db_connected = false;

try {
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if ($conn->connect_error) {
        // If connection fails, $db_connected stays false
        error_log("Connection failed: " . $conn->connect_error);
    } else {
        // Success! Set to true to hide the yellow banner
        $db_connected = true;
        $conn->set_charset("utf8mb4");
    }
    
} catch (Exception $e) {
    error_log("Cloud Database Error: " . $e->getMessage());
}
?>