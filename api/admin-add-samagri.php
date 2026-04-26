<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Add Samagri</title></head>
<body>
    <div class="content-section" style="max-width: 500px; margin: auto;">
        <h2>🛒 Add Samagri Item</h2>
        <form action="save-samagri.php" method="POST">
            <label>Select Pooja:</label>
            <select name="pooja_id" required style="width:100%; padding:8px; margin-bottom:10px;">
                <?php
                $res = $conn->query("SELECT pooja_id, title FROM poojas");
                while($p = $res->fetch_assoc()) { echo "<option value='".$p['pooja_id']."'>".$p['title']."</option>"; }
                ?>
            </select>

            <label>Item Name:</label>
            <input type="text" name="item_name" required style="width:100%; margin-bottom:10px;">

            <label>Quantity:</label>
            <input type="text" name="quantity" placeholder="e.g. 2 units" style="width:100%; margin-bottom:10px;">

            <label>Who provides this?</label>
            <select name="provided_by" style="width:100%; padding:8px;">
                <option value="devotee">Devotee</option>
                <option value="guruji">Guruji</option>
            </select>

            <button type="submit" class="btn" style="margin-top:15px;">Save Item</button>
        </form>
    </div>
</body>
</html>