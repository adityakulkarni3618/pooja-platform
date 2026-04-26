<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Add Library Text</title></head>
<body>
    <div class="content-section" style="max-width: 600px; margin: auto; padding: 20px;">
        <h2>📖 Add New Shloka / Mantra / Aarti</h2>
        <form action="save-library.php" method="POST">
            <label>Title:</label>
            <input type="text" name="title" required style="width:100%; margin-bottom:10px;">
            
            <label>Category:</label>
            <select name="category" style="width:100%; margin-bottom:10px; padding:8px;">
                <option value="aarti">Aarti</option>
                <option value="stotra">Stotra</option>
                <option value="jap matra">Jap Mantra</option>
            </select>

            <label>Sanskrit Content:</label>
            <textarea name="content_sanskrit" rows="5" required style="width:100%; margin-bottom:10px;"></textarea>

            <label>Meaning (Marathi/English):</label>
            <textarea name="meaning" rows="3" style="width:100%; margin-bottom:10px;"></textarea>

            <button type="submit" class="btn">Add to Library</button>
        </form>
    </div>
</body>
</html>