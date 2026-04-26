<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // TEST MODE: Bypass Database
    if ($password == "guruji123") { 
        $_SESSION['guruji_id'] = 1;
        $_SESSION['guruji_name'] = "Test Guruji";
        
        // Use a standard meta-refresh for the most reliable redirect on Vercel
        echo "<!DOCTYPE html><html><body>";
        echo "<p>Login successful! Redirecting to dashboard...</p>";
        echo "<script>window.location.href='/guruji-dashboard.php';</script>";
        echo "<meta http-equiv='refresh' content='1;url=/guruji-dashboard.php'>";
        echo "</body></html>";
        exit();
    } else {
        $error = "Invalid Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guruji Login | Pooja Seva</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            background-color: #fdfaf5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .navbar {
            background: linear-gradient(135deg, #ff8c00, #ff4500);
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 85vh;
            padding: 20px;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }
        .input-field:focus {
            border-color: #ff8c00;
        }
        .btn-login {
            width: 100%;
            background: #ff8c00;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: #e67e00;
        }
        .error-msg {
            background: #fff5f5;
            color: #c0392b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border-left: 5px solid #c0392b;
            text-align: left;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div style="font-size: 1.4rem; font-weight: bold;">🕉️ Pooja Seva</div>
        <a href="/" style="color: white; text-decoration: none; font-weight: 500;">Home</a>
    </nav>

    <div class="login-container">
        <div class="login-card">
            <div style="font-size: 3.5rem; margin-bottom: 15px;">🙏</div>
            <h2 style="color: #ff8c00; margin-top: 0; margin-bottom: 10px;">Guruji Portal</h2>
            <p style="color: #777; font-size: 0.95rem; margin-bottom: 30px;">Enter credentials to manage rituals</p>
            
            <?php if(!empty($error)): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="/login.php" method="POST">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="e.g. 1234567890" required class="input-field">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required class="input-field">
                </div>
                <button type="submit" class="btn-login">
                    Enter Dashboard
                </button>
            </form>
            
            <div style="margin-top: 30px;">
                <a href="/" style="color: #999; text-decoration: none; font-size: 0.85rem;">
                    ← Back to Devotee Site
                </a>
            </div>
        </div>
    </div>

    <footer style="text-align: center; color: #bbb; font-size: 0.8rem; padding-bottom: 20px;">
        &copy; 2026 Digital Vedic Resource Platform | Computer Engineering Project
    </footer>

</body>
</html>