<?php
session_start();
// Silence warnings to keep the UI clean on Vercel
error_reporting(0);
ini_set('display_errors', 0);

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $conn->real_escape_string($_POST['phone']); // Security: Escape input
    $password = $_POST['password'];

    // Check if user exists and is a Guruji
    $sql = "SELECT * FROM users WHERE phone_number = '$phone' AND role = 'guruji'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Simple password check for your project
        if ($password == "guruji123") { 
            $_SESSION['guruji_id'] = $user['user_id'];
            $_SESSION['guruji_name'] = $user['full_name'];
            
            // On Vercel, use a relative path since they are in the same folder
            header("Location: guruji-dashboard.php");
            exit(); // Always exit after a header redirect
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "Access Denied: Not a registered Guruji.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guruji Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fffaf0;">
    <div class="booking-form-box" style="max-width: 400px; margin: 100px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #ff4500; text-align: center;">Guruji Login</h2>
        
        <?php if(isset($error)): ?>
            <p style="color:red; text-align: center; font-weight: bold;"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Phone Number</label>
                <input type="text" name="phone" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <button type="submit" class="btn" style="width: 100%; background: #ff4500; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                Enter Dashboard
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 15px;">
            <a href="index.php" style="color: #666; text-decoration: none; font-size: 0.9rem;">← Back to Home</a>
        </div>
    </div>
</body>
</html>