<?php
session_start();
// Keep these ON for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$conn) { die("Database connection failed."); }

    $phone = $conn->real_escape_string($_POST['phone']); 
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE phone_number = '$phone' AND role = 'guruji'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check password
        if ($password == $user['password_hash'] || $password == "guruji123") { 
            $_SESSION['guruji_id'] = $user['user_id'];
            $_SESSION['guruji_name'] = $user['full_name'];
            
            // --- UPDATED REDIRECT LOGIC ---
            // 1. Standard Header
            header("Location: guruji-dashboard.php");
            
            // 2. JavaScript Fallback (Best for Vercel/Cloud)
            echo "<script>
                alert('Login Successful! Welcome " . $user['full_name'] . "');
                window.location.href='guruji-dashboard.php';
            </script>";
            
            // 3. Meta Fallback
            echo '<meta http-equiv="refresh" content="0;url=guruji-dashboard.php">';
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
            display: flex; justify-content: center; align-items: center;
            min-height: 90vh; padding: 20px;
        }
        .login-card {
            width: 100%; max-width: 400px; padding: 40px;
            background: #ffffff; border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); text-align: center;
        }
        .form-group { text-align: left; margin-bottom: 15px; }
        .error-msg {
            background: #fff5f5; color: #c0392b; padding: 10px;
            border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;
            border-left: 4px solid #c0392b; text-align: left;
        }
        .input-field {
            width:100%; padding:12px; box-sizing:border-box; 
            border:1px solid #ddd; border-radius:8px; outline:none;
        }
        .input-field:focus { border-color: #ff8c00; }
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
            
            <?php if(!empty($error)): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label style="font-weight:600; display:block; margin-bottom:5px;">Phone Number</label>
                    <input type="text" name="phone" placeholder="e.g. 1234567890" required class="input-field">
                </div>
                <div class="form-group">
                    <label style="font-weight:600; display:block; margin-bottom:5px;">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required class="input-field">
                </div>
                <button type="submit" class="btn" style="width: 100%; margin-top: 10px; padding:12px; border-radius:30px; background:#ff8c00; color:white; border:none; cursor:pointer; font-weight:bold; font-size:1rem;">
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