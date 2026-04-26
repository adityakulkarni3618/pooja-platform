<?php 
// Removed session_start() because it is already in lang_config.php
include 'lang_config.php'; 
if (!isset($_SESSION['guruji_id'])) { header("Location: login.php"); exit(); }
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Add New Pooja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content-section" style="max-width: 600px; margin: auto; padding: 20px;">
        <h2>Add New Pooja Service</h2>
        <form action="save-pooja.php" method="POST" enctype="multipart/form-data">
            
            <label>Pooja Name (English):</label>
            <input type="text" name="title" required placeholder="e.g. Satyanarayan Pooja" style="width:100%; margin-bottom:15px; padding: 8px;">

            <label style="color: #ff4500;">Pooja Name (Marathi / मराठी):</label>
            <input type="text" name="title_mr" required placeholder="उदा. सत्यनारायण पूजा" style="width:100%; margin-bottom:15px; padding: 8px; border: 1px solid #ff4500;">

            <label>Description (Significance):</label>
            <textarea name="description" rows="4" placeholder="Describe the importance of this ritual..." style="width:100%; margin-bottom:15px; padding: 8px;"></textarea>

            <label>Base Dakshina (Cost):</label>
            <input type="number" name="cost" required placeholder="5000" style="width:100%; margin-bottom:15px; padding: 8px;">

            <label>Upload Pooja Image:</label>
            <input type="file" name="pooja_image" accept="image/*" style="margin-bottom:20px; display: block;">

            <button type="submit" class="btn" style="width: 100%;">Save Pooja to Database</button>
        </form>
        <br>
        <a href="guruji-dashboard.php" style="color: #666; text-decoration: none;">← Back to Dashboard</a>
    </div>
</body>
</html>