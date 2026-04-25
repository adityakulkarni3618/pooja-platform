<?php
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_id = $_POST['pooja_id'];
    $item = $conn->real_escape_string($_POST['item_name']);
    $qty = $conn->real_escape_string($_POST['quantity']);
    $prov = $_POST['provided_by'];

    $sql = "INSERT INTO samagri_list (pooja_id, item_name, quantity, provided_by) VALUES ($p_id, '$item', '$qty', '$prov')";
    if ($conn->query($sql) === TRUE) { header("Location: guruji-dashboard.php?msg=SamagriAdded"); }
}
?>