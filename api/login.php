<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $conn->real_escape_string($_POST['phone']); 
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE phone_number = '$phone' AND role = 'guruji'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // This check covers both your DB column and your demo password
        if ($password == $user['password_hash'] || $password == "guruji123") { 
            $_SESSION['guruji_id'] = $user['user_id'];
            $_SESSION['guruji_name'] = $user['full_name'];
            
            header("Location: guruji-dashboard.php");
            exit();
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
    <title>Guruji Login | Pooja Seva</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            padding: 20px;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        /* Ensure labels are aligned left even if card is centered */
        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }
        .error-msg {
            background: #fff5f5;
            color: #c0392b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border-left: 4px solid #c0392b;
            text-align: left;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">🕉️ Pooja Seva</div>
        <ul class="nav-links">
            <li><a href="/">Home</a></li>
        </ul>
    </nav>

    <div class="login-container">
        <div class="login-card">
            <div style="font-size: 3rem; margin-bottom: 10px;">🙏</div>
            <h2 style="color: #ff8c00; margin-bottom: 5px;">Guruji Portal</h2>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 30px;">Access your sacred assignments</p>
            
            <?php if(isset($error)): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label style="font-weight:600; display:block; margin-bottom:5px;">Phone Number</label>
                    <input type="text" name="phone" placeholder="e.g. 1234567890" required style="width:100%; box-sizing:border-box;">
                </div>
                <div class="form-group">
                    <label style="font-weight:600; display:block; margin-bottom:5px;">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required style="width:100%; box-sizing:border-box;">
                </div>
                <button type="submit" class="btn" style="width: 100%; margin-top: 10px; font-family:inherit;">
                    Enter Dashboard
                </button>
            </form>
            
            <div style="margin-top: 25px;">
                <a href="/" style="color: #999; text-decoration: none; font-size: 0.85rem;">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>

    <footer style="text-align: center; color: #999; font-size: 0.8rem; margin-bottom: 20px;">
        &copy; 2026 Digital Vedic Resource Platform
    </footer>

</body>
</html>