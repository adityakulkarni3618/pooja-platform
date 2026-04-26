<?php 
// 1. Initial configuration
session_start();
error_reporting(0);
ini_set('display_errors', 0);

include 'lang_config.php'; 
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Request - Pooja Seva</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fdfdfd;">
    <nav class="navbar">
        <div class="logo">Pooja Seva</div>
        <ul class="nav-links">
            <li><a href="index.php">Back to Home</a></li>
        </ul>
    </nav>

    <div class="content-section" style="max-width: 600px; margin: 40px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <h2 style="color: #ff4500; border-bottom: 2px solid #ff4500; padding-bottom: 10px; margin-bottom: 20px;">🙏 Special Pooja Request</h2>
        <p style="color: #666; margin-bottom: 25px;">Can't find a specific ritual? Provide the details below, and Guruji will review your request and contact you regarding the Muhurta and Samagri.</p>
        
        <form action="process-booking.php" method="POST">
            <input type="hidden" name="pooja_id" value="999">
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Which Pooja/Vidhi do you want?</label>
                <input type="text" name="custom_pooja_name" placeholder="e.g. Special Kuldevi Pooja, Navchandi Path" required style="width:100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Your Full Name</label>
                <input type="text" name="full_name" required style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Phone (WhatsApp preferred)</label>
                <input type="tel" name="phone" placeholder="9876543210" required style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Tentative Date</label>
                <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Location / Address</label>
                <textarea name="address" rows="3" placeholder="Where should the Pooja be performed?" required style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: inherit;"></textarea>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; padding: 15px; background: #ff4500; color: white; border: none; font-size: 1.1rem; cursor: pointer; border-radius: 8px; font-weight: bold;">
                Ask Guruji for Availability
            </button>
        </form>
    </div>
</body>
</html>