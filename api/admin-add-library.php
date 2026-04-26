<?php 
// 1. Load Configuration
include 'lang_config.php'; 

// 2. Security Gate - Ensure only logged-in Guruji can access
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
    <title>Add Library Text - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fdfdfd;">
    <nav class="navbar">
        <div class="logo">Admin Panel</div>
        <ul class="nav-links">
            <li><a href="guruji-dashboard.php">Dashboard</a></li>
            <li><a href="index.php">View Site</a></li>
        </ul>
    </nav>

    <div class="content-section" style="max-width: 600px; margin: 40px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="color: #333; border-bottom: 2px solid #ff8c00; padding-bottom: 10px; margin-bottom: 20px;">📖 Add New Shloka / Mantra / Aarti</h2>
        
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <p style="color: green; font-weight: bold; text-align: center;">✅ Library entry added!</p>
        <?php endif; ?>

        <form action="save-library.php" method="POST">
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Title (English/Marathi):</label>
                <input type="text" name="title" required placeholder="e.g. Ganpati Aarti" style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Category:</label>
                <select name="category" style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="aarti">Aarti (आरती)</option>
                    <option value="stotra">Stotra (स्तोत्र)</option>
                    <option value="jap mantra">Jap Mantra (जप मंत्र)</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Sanskrit/Marathi Content:</label>
                <textarea name="content_sanskrit" rows="8" required placeholder="Paste the Devanagari text here..." style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: inherit;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Meaning (English/Marathi):</label>
                <textarea name="meaning" rows="4" placeholder="Explain the significance or translation..." style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: inherit;"></textarea>
            </div>

            <button type="submit" class="btn" style="width: 100%; background: #ff8c00; border: none; padding: 12px; color: white; font-weight: bold; border-radius: 5px; cursor: pointer;">
                Add to Library
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="guruji-dashboard.php" style="color: #666; text-decoration: none; font-size: 0.9rem;">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>