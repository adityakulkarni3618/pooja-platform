<?php 
// 1. Load Configuration (Handles session and translations)
include 'lang_config.php'; 

// 2. Security Gate - Only Guruji can add poojas
if (!isset($_SESSION['guruji_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add New Pooja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fdfdfd;">
    <nav class="navbar">
        <div class="logo">Admin Panel</div>
        <ul class="nav-links">
            <li><a href="guruji-dashboard.php">Dashboard</a></li>
            <li><a href="logout.php" style="color: #ff4500;">Logout</a></li>
        </ul>
    </nav>

    <div class="content-section" style="max-width: 600px; margin: 40px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <h2 style="color: #333; border-bottom: 2px solid #ff4500; padding-bottom: 10px; margin-bottom: 25px;">➕ Add New Pooja Service</h2>
        
        <form action="save-pooja.php" method="POST" enctype="multipart/form-data">
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Pooja Name (English):</label>
                <input type="text" name="title" required placeholder="e.g. Satyanarayan Pooja" style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px; color: #ff4500;">Pooja Name (Marathi / मराठी):</label>
                <input type="text" name="title_mr" required placeholder="उदा. सत्यनारायण पूजा" style="width:100%; padding: 10px; border: 1px solid #ff4500; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Description (Significance):</label>
                <textarea name="description" rows="4" placeholder="Describe the importance of this ritual..." style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: inherit;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Base Dakshina (₹):</label>
                <input type="number" name="cost" required placeholder="5000" style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Upload Pooja Image:</label>
                <input type="file" name="pooja_image" accept="image/*" style="display: block; font-size: 0.9rem;">
                <small style="color: #666;">Note: Image upload might require Vercel Blob storage for persistent live sites.</small>
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 12px; background: #ff4500; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 1rem;">
                Save Pooja to Database
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="guruji-dashboard.php" style="color: #666; text-decoration: none; font-size: 0.9rem;">← Cancel and Go Back</a>
        </div>
    </div>
</body>
</html>