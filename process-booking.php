<?php
include 'lang_config.php';
include 'db_connect.php';

// Your existing logic starts here...
<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture Form Data
    $pooja_id = $_POST['pooja_id'];
    $name = $conn->real_escape_string($_POST['full_name']); // Safety first!
    $phone = $conn->real_escape_string($_POST['phone']);
    $date = $_POST['booking_date'];
    $time = $_POST['time_slot'];
    $address = $conn->real_escape_string($_POST['address']);
    
    // Check if there is a custom name (from your custom request form)
    $custom_name = isset($_POST['custom_pooja_name']) ? $conn->real_escape_string($_POST['custom_pooja_name']) : '';

    // 2. Logic for Custom vs Standard Pooja
    // If ID is 999, it's a request for a pooja not in our list
    if ($pooja_id == 999 && !empty($custom_name)) {
        $status = 'pending_review';
        // We can temporarily store the custom name in the address or a notes field 
        // Or better: update the pooja title in the display logic later.
        $final_address = "CUSTOM POOJA: " . $custom_name . " | Address: " . $address;
    } else {
        $status = 'pending';
        $final_address = $address;
    }

    // 3. Guest User Logic
    $devotee_id = 1; 

    // 4. Insert into Database
    $sql = "INSERT INTO bookings (devotee_id, pooja_id, booking_date, time_slot, exact_address, status) 
            VALUES ('$devotee_id', '$pooja_id', '$date', '$time', '$final_address', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
        if($status == 'pending_review') {
            echo "<h1 style='color: #ff8c00;'>Request Sent for Review!</h1>";
            echo "<p>Since this is a custom Pooja, Guruji will check the requirements and contact you.</p>";
        } else {
            echo "<h1 style='color: green;'>Booking Successful!</h1>";
            echo "<p>Your request for the ritual has been sent to Guruji.</p>";
        }
        echo "<br><a href='index.php' style='padding:10px 20px; background:#ff4500; color:white; text-decoration:none; border-radius:5px;'>Back to Home</a>";
        echo "</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>