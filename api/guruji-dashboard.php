<?php 
// STEP 1: This MUST be the very first line. No spaces before <?php
session_start(); 

// STEP 2: Security Gate - Check if the session was created in login.php
if (!isset($_SESSION['guruji_id'])) {
    // If no session exists, redirect back to login
    header("Location: /login.php"); 
    exit();
}

// STEP 3: Now load your other files
include 'lang_config.php'; 
include 'db_connect.php'; 

// ... rest of your code ...

// 3. Fallback for Translations (In case lang_config.php keys are missing)
if(!isset($t['dashboard'])) {
    $t['dashboard'] = "Guruji Dashboard";
    $t['home'] = "Home";
    $t['logout'] = "Logout";
    $t['address'] = "Address";
    $t['status'] = "Status";
    $t['action'] = "Action";
    $t['lang_toggle'] = ($lang == 'en' ? 'मराठीत पहा' : 'Switch to English');
}

// 4. Analytics Calculation
$today = date('Y-m-d');
$stats_query = "SELECT 
    COUNT(*) as total, 
    SUM(CASE WHEN booking_date = '$today' THEN 1 ELSE 0 END) as today_count,
    SUM(CASE WHEN status = 'pending_review' OR pooja_id = 999 THEN 1 ELSE 0 END) as custom_requests
    FROM bookings WHERE status != 'cancelled'";

$stats_result = $conn->query($stats_query);
$stats = ($stats_result) ? $stats_result->fetch_assoc() : ['total'=>0, 'today_count'=>0, 'custom_requests'=>0];

// 5. Data Fetching (Bilingual Support)
$sql = "SELECT b.booking_id, b.pooja_id, u.full_name, u.phone_number, p.title, p.title_mr, b.booking_date, b.time_slot, b.exact_address, b.status 
        FROM bookings b
        JOIN users u ON b.devotee_id = u.user_id
        JOIN poojas p ON b.pooja_id = p.pooja_id
        ORDER BY b.booking_date ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $t['dashboard']; ?> - Control Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .stat-card { 
            flex: 1; min-width: 200px; background: white; padding: 20px; 
            border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
            text-align: center; border-bottom: 4px solid #ff4500;
        }
        .stat-card h3 { font-size: 0.9rem; color: #666; margin-bottom: 10px; }
        .stat-card p { font-size: 1.8rem; font-weight: bold; color: #333; margin: 0; }
        .admin-menu { 
            background: #fff; padding: 20px; border-radius: 10px; 
            margin-bottom: 30px; border: 1px solid #eee; text-align: center;
        }
        .custom-row { background-color: #fff9f0 !important; border-left: 5px solid #ff8c00; }
        .badge-pending { background: #ff8c00; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; }
        .dashboard-table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        .dashboard-table th { background-color: #f8f9fa; color: #333; padding: 12px; text-align: left; border-bottom: 2px solid #eee; }
        .dashboard-table td { padding: 12px; border-bottom: 1px solid #eee; }
        .status-confirmed { color: green; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
        .status-cancelled { color: red; font-weight: bold; }
    </style>
</head>
<body style="background-color: #fdfdfd;">

    <nav class="navbar">
        <div class="logo">Pooja Seva Admin</div>
        <ul class="nav-links">
            <li><a href="index.php"><?php echo $t['home']; ?></a></li>
            <li><a href="logout.php" style="color: #ff4500; font-weight: bold;"><?php echo $t['logout']; ?></a></li>
            <li><a href="?lang=<?php echo ($lang == 'en' ? 'mr' : 'en'); ?>" style="background: #333; color: white; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.8rem;">
                <?php echo $t['lang_toggle']; ?>
            </a></li>
        </ul>
    </nav>

    <div class="content-section" style="padding: 20px; max-width: 1200px; margin: auto;">
        
        <div class="admin-menu">
            <h3 style="margin-top: 0; color: #333;">🛠️ Management Console</h3>
            <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                <a href="admin-add-pooja.php" class="btn-small" style="background: #ff4500; text-decoration: none; padding: 10px 15px; color: white; border-radius: 5px;">➕ Add New Pooja</a>
                <a href="admin-add-samagri.php" class="btn-small" style="background: #666; text-decoration: none; padding: 10px 15px; color: white; border-radius: 5px;">🛒 Add Samagri Item</a>
                <a href="admin-add-library.php" class="btn-small" style="background: #ff8c00; text-decoration: none; padding: 10px 15px; color: white; border-radius: 5px;">📖 Add Library Text</a>
            </div>
        </div>

        <h1 style="color: #333;"><?php echo $t['dashboard']; ?></h1>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3>Active Bookings</h3>
                <p><?php echo $stats['total']; ?></p>
            </div>
            <div class="stat-card" style="border-bottom-color: #007bff;">
                <h3>Tasks for Today</h3>
                <p><?php echo $stats['today_count']; ?></p>
                <small style="color:<?php echo ($stats['today_count'] >= 3 ? 'red':'green'); ?>">
                    <?php echo ($stats['today_count'] >= 3 ? '⚠️ Fully Booked':'Available'); ?>
                </small>
            </div>
            <div class="stat-card" style="border-bottom-color: #6f42c1;">
                <h3>Review Required</h3>
                <p><?php echo $stats['custom_requests']; ?></p>
            </div>
        </div>

        <h2 style="color: #ff4500; border-bottom: 2px solid #eee; padding-bottom: 10px;">Upcoming Assignments</h2>
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Pooja Name</th>
                    <th>Devotee Details</th>
                    <th><?php echo $t['address']; ?></th>
                    <th><?php echo $t['status']; ?></th>
                    <th><?php echo $t['action']; ?></th>
                    <th>Smart Links</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $is_custom = ($row['pooja_id'] == 999 || $row['status'] == 'pending_review');
                        $row_class = $is_custom ? "custom-row" : "";
                        
                        // Bilingual Pooja Title Logic
                        $display_title = ($lang == 'mr' && !empty($row['title_mr'])) ? $row['title_mr'] : $row['title'];
                        
                        // Action Links
                        $wa_msg = "Namaste " . $row['full_name'] . ", regarding your " . $display_title . " on " . $row['booking_date'] . "...";
                        $wa_link = "https://wa.me/91" . $row['phone_number'] . "?text=" . urlencode($wa_msg);
                        $maps_link = "https://www.google.com/maps/search/?api=1&query=" . urlencode($row['exact_address']);
                        $phone_link = "tel:" . $row['phone_number'];

                        echo "<tr class='$row_class'>";
                        echo "<td><strong>" . date('d M', strtotime($row['booking_date'])) . "</strong><br><small>" . $row['time_slot'] . "</small></td>";
                        
                        echo "<td>";
                        echo $is_custom ? "<span class='badge-pending'>NEW REQUEST</span><br>" : "";
                        echo "<strong>" . $display_title . "</strong><br>";
                        echo "<a href='pooja-details.php?id=" . $row['pooja_id'] . "' target='_blank' style='font-size:0.75rem; color:#ff4500;'>📋 Check Samagri</a>";
                        echo "</td>";

                        echo "<td>" . $row['full_name'] . "<br><small>" . $row['phone_number'] . "</small></td>";
                        echo "<td><div style='max-width:200px; font-size:0.85rem;'>" . $row['exact_address'] . "</div></td>";
                        echo "<td><span class='status-" . $row['status'] . "'>" . strtoupper($row['status']) . "</span></td>";
                        
                        echo "<td>
                                <a href='update-status.php?id=" . $row['booking_id'] . "&status=confirmed' class='btn-small' style='background-color:green; display:block; text-align:center; color:white; text-decoration:none; padding:5px; border-radius:3px; margin-bottom:5px; font-size:0.8rem;'>Accept</a>
                                <a href='update-status.php?id=" . $row['booking_id'] . "&status=cancelled' class='btn-small' style='background-color:red; display:block; text-align:center; color:white; text-decoration:none; padding:5px; border-radius:3px; font-size:0.8rem;'>Reject</a>
                              </td>";
                        
                        echo "<td>
                                <a href='$wa_link' target='_blank' style='background:#25D366; color:white; text-decoration:none; padding:5px; display:block; text-align:center; border-radius:3px; margin-bottom:5px; font-size:0.8rem;'>WhatsApp</a>
                                <div style='display:flex; gap:5px;'>
                                    <a href='$phone_link' style='background-color:#007bff; flex:1; text-align:center; color:white; text-decoration:none; border-radius:3px; padding:5px;'>📞</a>
                                    <a href='$maps_link' target='_blank' style='background-color:#6f42c1; flex:1; text-align:center; color:white; text-decoration:none; border-radius:3px; padding:5px;'>📍</a>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding: 20px; color: #999;'>No bookings found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>