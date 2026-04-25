<?php
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $cat = $_POST['category'];
    $content = $conn->real_escape_string($_POST['content_sanskrit']);
    $meaning = $conn->real_escape_string($_POST['meaning']);

    $sql = "INSERT INTO library_texts (title, category, content_sanskrit, meaning) VALUES ('$title', '$cat', '$content', '$meaning')";
    if ($conn->query($sql) === TRUE) { header("Location: guruji-dashboard.php?msg=LibraryUpdated"); }
}
?>