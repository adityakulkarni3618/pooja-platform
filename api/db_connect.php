<?php
// Database credentials for Laragon
$host = "localhost";      // The server is running on your local machine
$username = "root";       // Default Laragon username
$password = "";           // Default Laragon password is blank
$database = "pooja_platform"; // The database we just created in HeidiSQL

// 1. Establish the connection
$conn = new mysqli($host, $username, $password, $database);

// 2. Check if the connection worked
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Success message (we will delete this later once we know it works)

?>