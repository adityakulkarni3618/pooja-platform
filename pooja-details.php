<?php 
include 'lang_config.php'; // This must be first to handle the language session
include 'db_connect.php'; 
?>
<?php 
include 'db_connect.php'; 

// 1. Get the Pooja ID. 999 is our "Custom" flag.
$pooja_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$is_custom = ($pooja_id == 999);

// 2. Fetch Pooja details (unless it's a custom request)
if (!$is_custom) {
    $sql = "SELECT * FROM poojas WHERE pooja_id = $pooja_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $pooja = $result->fetch_assoc();
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    // Default values for Custom Request
    $pooja = [
        'title' => 'Custom Pooja Request',
        'significance_description' => 'Tell us about the specific Vidhi or ritual you wish to perform. Guruji will review your request and guide you on the Muhurta and Samagri.',
        'base_dakshina' => 'To be discussed'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pooja['title']; ?> - Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Pooja Seva</div>
        <ul class="nav-links">
            <li><a href="index.php">Back to Home</a></li>
        </ul>
    </nav>

    <div class="content-section">
        <h1 style="color: #ff4500;"><?php echo $pooja['title']; ?></h1>
        <p class="hero-desc" style="font-size: 1.1rem; color: #555; margin-bottom: 30px; line-height: 1.6;">
            <?php echo $pooja['significance_description']; ?>
        </p>

        <?php if (!$is_custom): ?>
        <div class="samagri-box" style="background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid #ff4500;">
            <h2 style="color: #ff4500; border-bottom: 1px solid #eee; padding-bottom: 10px;">Required Samagri (सामग्री)</h2>
            
            <div class="split-list" style="display: flex; gap: 40px; margin-top: 20px; flex-wrap: wrap;">
                <div class="list-column" style="flex: 1; min-width: 250px;">
                    <h3 style="color: #800000;">🔹 Devotee to Arrange:</h3>
                    <ul style="line-height: 2;">
                        <?php
                        $s_sql = "SELECT * FROM samagri_list WHERE pooja_id = $pooja_id AND provided_by = 'devotee'";
                        $s_res = $conn->query($s_sql);
                        if ($s_res && $s_res->num_rows > 0) {
                            while($item = $s_res->fetch_assoc()) {
                                echo "<li><strong>" . $item['item_name'] . "</strong> <small>(" . $item['quantity'] . ")</small></li>";
                            }
                        } else {
                            echo "<li>Rice, Flowers, Fruit, and Milk (Standard items).</li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="list-column" style="flex: 1; min-width: 250px; border-left: 1px solid #eee; padding-left: 20px;">
                    <h3 style="color: #ff8c00;">🔸 Guruji will Bring:</h3>
                    <ul style="line-height: 2;">
                        <?php
                        $g_sql = "SELECT * FROM samagri_list WHERE pooja_id = $pooja_id AND provided_by = 'guruji'";
                        $g_res = $conn->query($g_sql);
                        if ($g_res && $g_res->num_rows > 0) {
                            while($item = $g_res->fetch_assoc()) {
                                echo "<li>" . $item['item_name'] . "</li>";
                            }
                        } else {
                            echo "<li>Idols, Copper Kalash, and Ritual Tools.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="booking-form-box" style="margin-top: 40px; background: #fffaf0; padding: 35px; border-radius: 12px; border: 1px solid #ffd700;">
            <h2 style="text-align: center; margin-bottom: 25px;">📅 Booking Details</h2>
            
            <form action="process-booking.php" method="POST">
                <input type="hidden" name="pooja_id" value="<?php echo $pooja_id; ?>">

                <?php if ($is_custom): ?>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="font-weight: bold; color: #ff4500;">Name of the Pooja/Vidhi you want:</label>
                    <input type="text" name="custom_pooja_name" placeholder="e.g. Navchandi Path, Special Shanti Vidhi..." required style="width: 100%; padding: 12px; border: 2px solid #ff4500; border-radius: 5px;">
                </div>
                <?php endif; ?>

                <div class="grid-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label>Your Full Name</label>
                        <input type="text" name="full_name" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                    </div>

                    <div class="form-group">
                        <label>Phone Number (WhatsApp)</label>
                        <input type="tel" name="phone" required placeholder="Ex: 9876543210" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                    </div>

                    <div class="form-group">
                        <label>Select Date</label>
                        <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                    </div>

                    <div class="form-group">
                        <label>Preferred Time</label>
                        <input type="time" name="time_slot" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <label>Exact Address & Landmark</label>
                    <textarea name="address" rows="3" required placeholder="Flat No, Society Name, Near..." style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;"></textarea>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <h4 style="color: #800000; margin-bottom: 10px;">Approximate Dakshina: ₹<?php echo $pooja['base_dakshina']; ?></h4>
                    <button type="submit" class="btn" style="width: 100%; padding: 15px; background: #ff4500; color: white; border: none; font-size: 1.2rem; cursor: pointer; border-radius: 8px; font-weight: bold;">
                        <?php echo $is_custom ? "Send Request to Guruji" : "Confirm Booking Request"; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>