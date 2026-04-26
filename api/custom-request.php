<?php include 'db_connect.php'; ?>
<div class="content-section">
    <h2>Special Pooja Request</h2>
    <form action="process-booking.php" method="POST">
        <input type="hidden" name="pooja_id" value="999">
        
        <label>Which Pooja/Vidhi do you want?</label>
        <input type="text" name="custom_name" placeholder="e.g. Special Kuldevi Pooja" required>
        
        <label>Your Name</label>
        <input type="text" name="full_name" required>
        
        <label>Phone</label>
        <input type="tel" name="phone" required>
        
        <button type="submit" class="btn">Ask Guruji for Availability</button>
    </form>
</div>