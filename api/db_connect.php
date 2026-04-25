<?php
// Database Configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pooja_platform";

// Global flag to check database status
$db_connected = false;

try {
    // Attempt connection
    $conn = new mysqli($host, $user, $pass, $dbname);
    
    if ($conn->connect_error) {
        $db_connected = false;
    } else {
        $db_connected = true;
        // Set charset for Marathi support
        $conn->set_charset("utf8mb4");
    }
} catch (Exception $e) {
    // Silence the error for the live site
    $db_connected = false;
}
?>