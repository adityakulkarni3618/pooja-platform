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
    <title>Add Samagri - Admin</title>
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

    <div class="content-section" style="max-width: 500px; margin: 50px auto; padding: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="color: #333; border-bottom: 2px solid #ff8c00; padding-bottom: 10px; margin-bottom: 20px;">🛒 Add Samagri Item</h2>
        
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <p style="color: green; font-weight: bold; text-align: center;">✅ Item added successfully!</p>
        <?php endif; ?>

        <form action="save-samagri.php" method="POST">
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Select Pooja Service:</label>
                <select name="pooja_id" required style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="">-- Choose a Pooja --</option>
                    <?php
                    $res = $conn->query("SELECT pooja_id, title FROM poojas ORDER BY title ASC");
                    if ($res && $res->num_rows > 0) {
                        while($p = $res->fetch_assoc()) { 
                            echo "<option value='".$p['pooja_id']."'>".$p['title']."</option>"; 
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Item Name (सामग्रीचे नाव):</label>
                <input type="text" name="item_name" required placeholder="e.g. Haldi-Kumkum, Coconut" style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Quantity / Volume:</label>
                <input type="text" name="quantity" placeholder="e.g. 2 units, 250 grams" style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Responsibility:</label>
                <select name="provided_by" style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="devotee">Devotee (User to bring)</option>
                    <option value="guruji">Guruji (Priest will bring)</option>
                </select>
            </div>

            <button type="submit" class="btn" style="width: 100%; background: #ff8c00; border: none; padding: 12px; color: white; font-weight: bold; border-radius: 5px; cursor: pointer;">
                Save Item to List
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="guruji-dashboard.php" style="color: #666; text-decoration: none; font-size: 0.9rem;">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>