<?php
// Filess.io Connection Details
$host = "8gb2xk.h.filess.io";
$user = "pooja_platform_db_meantskill";
$pass = "9471475cf7ce2172cc4215d237b5e90200e2d0bf";
$dbname = "pooja_platform_db_meantskill";
$port = 3307; // Note: Your port is 3307, not the standard 3306

try {
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Support for Marathi text
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    echo "Cloud Database Error: " . $e->getMessage();
}
?>