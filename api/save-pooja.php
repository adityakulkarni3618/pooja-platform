<?php
include 'lang_config.php';
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture and Sanitize Text Data
    $title = $conn->real_escape_string($_POST['title']);
    $title_mr = $conn->real_escape_string($_POST['title_mr']); // New Marathi Title
    $desc = $conn->real_escape_string($_POST['description']);
    $cost = intval($_POST['cost']);

    // 2. File Upload Logic
    $target_dir = "uploads/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) { 
        mkdir($target_dir, 0777, true); 
    }
    
    // Check if a file was actually uploaded
    if (!empty($_FILES["pooja_image"]["name"])) {
        $file_name = time() . "_" . basename($_FILES["pooja_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["pooja_image"]["tmp_name"], $target_file)) {
            $img_path = $target_file;
        } else {
            $img_path = "default_pooja.jpg";
        }
    } else {
        $img_path = "default_pooja.jpg";
    }

    // 3. Database Insertion (Including title_mr)
    $sql = "INSERT INTO poojas (title, title_mr, significance_description, base_dakshina, image_path) 
            VALUES ('$title', '$title_mr', '$desc', '$cost', '$img_path')";

    if ($conn->query($sql) === TRUE) {
        // Success redirect
        header("Location: guruji-dashboard.php?msg=PoojaAdded");
        exit();
    } else {
        // Error handling
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>