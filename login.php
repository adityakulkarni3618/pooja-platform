<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Check if user exists and is a Guruji
    $sql = "SELECT * FROM users WHERE phone_number = '$phone' AND role = 'guruji'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // For now, we are doing a simple check. 
        // In a real app, we'd use password_verify()
        if ($password == "guruji123") { 
            $_SESSION['guruji_id'] = $user['user_id'];
            header("Location: guruji-dashboard.php");
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
    <title>Guruji Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #fffaf0;">
    <div class="booking-form-box" style="max-width: 400px; margin: 100px auto;">
        <h2>Guruji Login</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Enter Dashboard</button>
        </form>
    </div>
</body>
</html>