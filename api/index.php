<?php 
// 1. Initial config - No output before this!
error_reporting(0);
ini_set('display_errors', 0);

include 'db_connect.php'; 
include 'lang_config.php'; 

// --- LANGUAGE LOGIC ---
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] == 'mr' ? 'mr' : 'en';
}
$lang = $_SESSION['lang'];

// YOUR ORIGINAL TRANSLATIONS PRESERVED
$texts = [
    'en' => [
        'home' => 'Home', 'library' => 'Library', 'booking' => 'Book a Pooja', 'login' => 'Guruji Login',
        'hero_h1' => 'Digital Vedic Resource & Pooja Services', 'hero_p' => 'Connecting Devotees with Vedic Wisdom and Sacred Rituals.',
        'btn_explore' => 'Explore Library', 'lib_h2' => 'Vedic Library', 'search_placeholder' => 'Search for a Stotra, Aarti or Mantra...',
        'all' => 'All', 'aartis' => 'Aartis', 'stotras' => 'Stotras', 'jap_mantras' => 'Jap Mantras',
        'pooja_h2' => 'Book a Pooja', 'pooja_search' => 'Search for a specific Pooja...', 'dakshina' => 'Dakshina',
        'btn_view' => 'View Samagri & Book', 'custom_h3' => "Can't find the Pooja you need?", 'custom_p' => "If you have a specific ritual not listed, send a custom request.",
        'btn_custom' => 'Send Custom Request', 'lang_toggle' => 'मराठीत पहा'
    ],
    'mr' => [
        'home' => 'मुख्यपृष्ठ', 'library' => 'ग्रंथालय', 'booking' => 'पूजा बुकिंग', 'login' => 'गुरुजी लॉगिन',
        'hero_h1' => 'डिजिटल वेदिक सेवा आणि माहिती', 'hero_p' => 'भक्तांना वेदिक ज्ञान आणि पवित्र विधींशी जोडणे.',
        'btn_explore' => 'ग्रंथालय पहा', 'lib_h2' => 'वेदिक ग्रंथालय', 'search_placeholder' => 'स्तोत्र, आरती किंवा मंत्र शोधा...',
        'all' => 'सर्व', 'aartis' => 'आरती', 'stotras' => 'स्तोत्र', 'jap_mantras' => 'जप मंत्र',
        'pooja_h2' => 'पूजा बुक करा', 'pooja_search' => 'विशिष्ट पूजा शोधा...', 'dakshina' => 'दक्षिणा',
        'btn_view' => 'साहित्य पहा आणि बुक करा', 'custom_h3' => "हवी ती पूजा सापडत नाहीये?", 'custom_p' => "यादीत नसल्यास, तुमची विशेष विनंती गुरुजींना पाठवा.",
        'btn_custom' => 'विशेष विनंती पाठवा', 'lang_toggle' => 'Switch to English'
    ]
];
$t = $texts[$lang];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vedic Pooja Platform</title>
    <link rel="stylesheet" href="style.css">
    <style>
        html { scroll-behavior: smooth; }
        .hero {
            padding: 80px 20px;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1545062990-4a95e8e4b96d?auto=format&fit=crop&w=1350&q=80');
            background-size: cover; background-position: center; color: white; text-align: center;
        }
        .search-input {
            padding: 12px 25px; width: 60%; border-radius: 30px; border: 2px solid #ff8c00; outline: none; margin-bottom: 20px;
        }
        .filter-btn {
            display: inline-block; padding: 8px 18px; margin: 5px; border-radius: 20px; text-decoration: none; font-size: 0.9rem; font-weight: bold;
        }
        /* Dashboard Card Styling for Library and Pooja */
        .card-box {
            background: white; border-radius: 12px; padding: 20px; text-align: left;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.2s;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .card-box:hover { transform: translateY(-5px); }
        .badge { background: #ff4500; color: white; padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: bold; }
        #scrollTop { position: fixed; bottom: 20px; right: 20px; background: #ff4500; color: white; border: none; border-radius: 50%; width: 45px; height: 45px; cursor: pointer; display: none; z-index: 1000; }
    </style>
</head>
<body>

    <?php if (!$db_connected): ?>
        <div style="background: #fff3cd; color: #856404; padding: 10px; text-align: center;">
            <strong>⚠️ Notice:</strong> Using development mode connection.
        </div>
    <?php endif; ?>

    <button id="scrollTop" onclick="window.scrollTo(0,0)">↑</button>

    <nav class="navbar">
        <div class="logo">🕉️ Pooja Seva</div>
        <ul class="nav-links">
            <li><a href="index.php"><?php echo $t['home']; ?></a></li>
            <li><a href="#library"><?php echo $t['library']; ?></a></li>
            <li><a href="#booking"><?php echo $t['booking']; ?></a></li>
            <li><a href="login.php"><?php echo $t['login']; ?></a></li>
            <li><a href="?lang=<?php echo ($lang == 'en' ? 'mr' : 'en'); ?>" style="background: white; color: #ff8c00; padding: 5px 12px; border-radius: 15px; font-size: 0.8rem;"><?php echo $t['lang_toggle']; ?></a></li>
        </ul>
    </nav>

    <header class="hero">
        <h1><?php echo $t['hero_h1']; ?></h1>
        <p><?php echo $t['hero_p']; ?></p>
        <a href="#library" class="btn" style="text-decoration:none; display:inline-block; margin-top:15px;"><?php echo $t['btn_explore']; ?></a>
    </header>

    <section id="library" class="content-section">
        <h2 style="color: #ff4500;"><?php echo $t['lib_h2']; ?></h2>
        
        <form method="GET" action="index.php#library" style="margin-bottom: 25px;">
            <input type="text" name="search" class="search-input" placeholder="<?php echo $t['search_placeholder']; ?>" value="<?php echo htmlspecialchars($_GET['search']); ?>">
            <button type="submit" class="btn" style="padding: 10px 20px;">Search</button>
        </form>

        <div style="margin-bottom: 40px;">
            <a href="index.php#library" class="filter-btn" style="background:#666; color:white;"><?php echo $t['all']; ?></a>
            <a href="index.php?cat=aarti#library" class="filter-btn" style="background:#ff8c00; color:white;"><?php echo $t['aartis']; ?></a>
            <a href="index.php?cat=stotra#library" class="filter-btn" style="background:#ff8c00; color:white;"><?php echo $t['stotras']; ?></a>
            <a href="index.php?cat=jap matra#library" class="filter-btn" style="background:#ff8c00; color:white;"><?php echo $t['jap_mantras']; ?></a>
        </div>

        <div class="grid-container">
            <?php
            $search = $conn->real_escape_string($_GET['search']);
            $cat_filter = $conn->real_escape_string($_GET['cat']);

            if($search != '') {
                $sql_lib = "SELECT * FROM library_texts WHERE title LIKE '%$search%' OR content_sanskrit LIKE '%$search%'";
            } elseif($cat_filter != '') {
                $sql_lib = "SELECT * FROM library_texts WHERE category = '$cat_filter'";
            } else {
                $sql_lib = "SELECT * FROM library_texts ORDER BY category ASC";
            }

            $lib_res = $conn->query($sql_lib);
            if ($lib_res && $lib_res->num_rows > 0) {
                while($row = $lib_res->fetch_assoc()) {
                    echo "<div class='card-box'>";
                    echo "<div><span class='badge'>" . strtoupper($row["category"]) . "</span>";
                    echo "<h3 style='margin-top:10px;'>" . $row["title"] . "</h3>";
                    echo "<p class='sanskrit-text' style='color:#800000; font-size:1.1rem;'>" . nl2br($row["content_sanskrit"]) . "</p></div>";
                    echo "<p style='font-size:0.9rem; color:#666; border-top:1px solid #eee; padding-top:10px;'><strong>अर्थ:</strong> " . $row["meaning"] . "</p>";
                    echo "</div>";
                }
            } else { echo "<p style='grid-column: 1/-1;'>No texts found in the library.</p>"; }
            ?>
        </div>
    </section>

    <section id="booking" class="content-section" style="background-color: #fffaf0; border-top: 2px solid #eee;">
        <h2 style="color: #ff4500;"><?php echo $t['pooja_h2']; ?></h2>
        
        <form method="GET" action="index.php#booking" style="margin-bottom: 30px;">
            <input type="text" name="p_search" class="search-input" placeholder="<?php echo $t['pooja_search']; ?>" value="<?php echo htmlspecialchars($_GET['p_search']); ?>">
            <button type="submit" class="btn" style="padding: 10px 20px;">Find</button>
        </form>

        <div class="grid-container">
            <?php
            $p_search = $conn->real_escape_string($_GET['p_search']);
            $sql_pooja = ($p_search != '') ? "SELECT * FROM poojas WHERE title LIKE '%$p_search%' ORDER BY title ASC" : "SELECT * FROM poojas ORDER BY title ASC";
            $p_res = $conn->query($sql_pooja);

            if ($p_res && $p_res->num_rows > 0) {
                while($row = $p_res->fetch_assoc()) {
                    $display_title = ($lang == 'mr' && !empty($row['title_mr'])) ? $row['title_mr'] : $row['title'];
                    echo "<div class='card-box' style='border-left: 5px solid #ff8c00;'>";
                    echo "<div><h3>$display_title</h3>";
                    echo "<p style='font-size:0.85rem; color:#555;'>".substr($row['significance_description'], 0, 150)."...</p></div>";
                    echo "<div style='margin-top:15px; display:flex; justify-content:space-between; align-items:center;'>";
                    echo "<strong style='color:#d9534f;'>₹".$row['base_dakshina']."</strong>";
                    echo "<a href='pooja-details.php?id=".$row['pooja_id']."' class='btn' style='font-size:0.8rem; text-decoration:none;'>".$t['btn_view']."</a>";
                    echo "</div></div>";
                }
            }
            ?>
        </div>

        <div style="margin: 50px auto; max-width: 700px; padding: 30px; border: 2px dashed #ff4500; border-radius: 15px; background: white;">
            <h3 style="color: #ff4500;"><?php echo $t['custom_h3']; ?></h3>
            <p><?php echo $t['custom_p']; ?></p>
            <a href="custom-request.php" class="btn" style="text-decoration: none;"><?php echo $t['btn_custom']; ?></a>
        </div>
    </section>

    <footer style="background:#333; color:white; padding:30px; text-align:center; margin-top: 50px;">
        <p>&copy; 2026 Pooja Seva Platform | Computer Engineering Mini-Project</p>
    </footer>

    <script>
        window.onscroll = function() {
            var btn = document.getElementById("scrollTop");
            if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) { btn.style.display = "block"; } 
            else { btn.style.display = "none"; }
        };
    </script>
</body>
</html>