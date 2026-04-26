error_reporting(0);
ini_set('display_errors', 0);
<?php if (!$db_connected): ?>
    <div style="background: #fff3cd; color: #856404; padding: 15px; text-align: center; border-bottom: 2px solid #ffeeba;">
        <strong>⚠️ Development Mode:</strong> The live preview database is offline. 
        Please view the full version on <strong>Localhost (Laragon)</strong> for booking features.
    </div>
<?php endif; ?>
<?php 
include 'lang_config.php'; // This must be first to handle the language session
include 'db_connect.php'; 
?>
<?php 
include 'db_connect.php'; 


// --- LANGUAGE LOGIC ---
// Set default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Check for language toggle request
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] == 'mr' ? 'mr' : 'en';
}

$lang = $_SESSION['lang'];

// Translation Array for UI Elements
$texts = [
    'en' => [
        'home' => 'Home',
        'library' => 'Library',
        'booking' => 'Book a Pooja',
        'login' => 'Guruji Login',
        'hero_h1' => 'Digital Vedic Resource & Pooja Services',
        'hero_p' => 'Connecting Devotees with Vedic Wisdom and Sacred Rituals.',
        'btn_explore' => 'Explore Library',
        'lib_h2' => 'Vedic Library',
        'search_placeholder' => 'Search for a Stotra, Aarti or Mantra...',
        'all' => 'All',
        'aartis' => 'Aartis',
        'stotras' => 'Stotras',
        'jap_mantras' => 'Jap Mantras',
        'pooja_h2' => 'Book a Pooja',
        'pooja_search' => 'Search for a specific Pooja...',
        'dakshina' => 'Dakshina',
        'btn_view' => 'View Samagri & Book',
        'custom_h3' => "Can't find the Pooja you need?",
        'custom_p' => "If you have a specific ritual not listed, send a custom request.",
        'btn_custom' => 'Send Custom Request',
        'lang_toggle' => 'मराठीत पहा'
    ],
    'mr' => [
        'home' => 'मुख्यपृष्ठ',
        'library' => 'ग्रंथालय',
        'booking' => 'पूजा बुकिंग',
        'login' => 'गुरुजी लॉगिन',
        'hero_h1' => 'डिजिटल वेदिक सेवा आणि माहिती',
        'hero_p' => 'भक्तांना वेदिक ज्ञान आणि पवित्र विधींशी जोडणे.',
        'btn_explore' => 'ग्रंथालय पहा',
        'lib_h2' => 'वेदिक ग्रंथालय',
        'search_placeholder' => 'स्तोत्र, आरती किंवा मंत्र शोधा...',
        'all' => 'सर्व',
        'aartis' => 'आरती',
        'stotras' => 'स्तोत्र',
        'jap_mantras' => 'जप मंत्र',
        'pooja_h2' => 'पूजा बुक करा',
        'pooja_search' => 'विशिष्ट पूजा शोधा...',
        'dakshina' => 'दक्षिणा',
        'btn_view' => 'साहित्य पहा आणि बुक करा',
        'custom_h3' => "हवी ती पूजा सापडत नाहीये?",
        'custom_p' => "यादीत नसल्यास, तुमची विशेष विनंती गुरुजींना पाठवा.",
        'btn_custom' => 'विशेष विनंती पाठवा',
        'lang_toggle' => 'Switch to English'
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
        #scrollTop {
            position: fixed; bottom: 20px; right: 20px;
            background: #ff4500; color: white; border: none;
            border-radius: 50%; width: 45px; height: 45px;
            cursor: pointer; display: none; font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index: 1000;
        }
        .custom-request-box {
            margin: 40px auto; max-width: 800px; padding: 30px;
            background: #fff; border: 2px dashed #ff4500;
            border-radius: 15px; text-align: center;
        }
    </style>
</head>
<body>

    <button id="scrollTop" onclick="window.scrollTo(0,0)">↑</button>

    <nav class="navbar">
        <div class="logo">Pooja Seva</div>
        <ul class="nav-links">
            <li><a href="index.php"><?php echo $t['home']; ?></a></li>
            <li><a href="#library"><?php echo $t['library']; ?></a></li>
            <li><a href="#booking"><?php echo $t['booking']; ?></a></li>
            <li><a href="login.php"><?php echo $t['login']; ?></a></li>
            <li><a href="?lang=<?php echo ($lang == 'en' ? 'mr' : 'en'); ?>" style="background: #ff4500; color: white; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.85rem;">
                <?php echo $t['lang_toggle']; ?>
            </a></li>
        </ul>
    </nav>

    <header class="hero">
        <h1><?php echo $t['hero_h1']; ?></h1>
        <p><?php echo $t['hero_p']; ?></p>
        <a href="#library" class="btn" style="text-decoration:none; display:inline-block;"><?php echo $t['btn_explore']; ?></a>
    </header>

    <section id="library" class="content-section">
        <h2 style="text-align: center; color: #ff4500;"><?php echo $t['lib_h2']; ?></h2>
        
        <div style="text-align: center; margin-bottom: 20px;">
            <form method="GET" action="index.php#library">
                <input type="text" name="search" placeholder="<?php echo $t['search_placeholder']; ?>" 
                       value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                       style="padding: 10px; width: 60%; border-radius: 25px; border: 2px solid #ff4500; outline: none;">
                <button type="submit" class="btn-small">Search</button>
            </form>
        </div>

        <div style="margin-bottom: 30px; text-align: center;">
            <a href="index.php#library" class="btn-small" style="background:#666"><?php echo $t['all']; ?></a>
            <a href="index.php?cat=aarti#library" class="btn-small" style="background:#ff8c00"><?php echo $t['aartis']; ?></a>
            <a href="index.php?cat=stotra#library" class="btn-small" style="background:#ff8c00"><?php echo $t['stotras']; ?></a>
            <a href="index.php?cat=jap matra#library" class="btn-small" style="background:#ff8c00"><?php echo $t['jap_mantras']; ?></a>
        </div>

        <div class="grid-container">
            <?php
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            $cat_filter = isset($_GET['cat']) ? $conn->real_escape_string($_GET['cat']) : '';

            if($search != '') {
                $sql_library = "SELECT * FROM library_texts WHERE title LIKE '%$search%' OR content_sanskrit LIKE '%$search%'";
            } elseif($cat_filter != '') {
                $sql_library = "SELECT * FROM library_texts WHERE category = '$cat_filter'";
            } else {
                $sql_library = "SELECT * FROM library_texts ORDER BY category ASC";
            }

            $library_result = $conn->query($sql_library);

            if ($library_result && $library_result->num_rows > 0) {
                while($row = $library_result->fetch_assoc()) {
                    echo "<div class='card sloka-card' style='position:relative; display:flex; flex-direction:column; justify-content:space-between;'>";
                    echo "<span class='badge' style='background:#ff4500; color:white; font-size:0.7rem; padding:2px 8px; border-radius:10px; position:absolute; top:10px; right:10px;'>" . strtoupper($row["category"]) . "</span>";
                    echo "<div><h3>" . $row["title"] . "</h3>";
                    echo "<p class='sanskrit-text' style='color:#800000; font-size:1.2rem;'>" . nl2br($row["content_sanskrit"]) . "</p></div>";
                    echo "<p class='meaning-text' style='border-top: 1px dashed #ccc; padding-top:10px; font-size:0.95rem;'><strong>अर्थ:</strong> " . $row["meaning"] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p style='text-align:center; grid-column: 1/-1;'>No texts found.</p>";
            }
            ?>
        </div>
    </section>

    <section id="booking" class="content-section" style="background-color: #fffaf0; padding-bottom: 60px;">
        <h2 style="text-align: center; color: #ff4500;"><?php echo $t['pooja_h2']; ?></h2>
        
        <div style="text-align: center; margin-bottom: 30px;">
            <form method="GET" action="index.php#booking">
                <input type="text" name="p_search" placeholder="<?php echo $t['pooja_search']; ?>" 
                       value="<?php echo isset($_GET['p_search']) ? $_GET['p_search'] : ''; ?>"
                       style="padding: 10px; width: 50%; border-radius: 5px; border: 1px solid #ff4500; outline: none;">
                <button type="submit" class="btn-small">Find</button>
            </form>
        </div>

        <div class="grid-container">
            <?php
            $p_search = isset($_GET['p_search']) ? $conn->real_escape_string($_GET['p_search']) : '';
            if($p_search != '') {
                $sql_pooja = "SELECT * FROM poojas WHERE title LIKE '%$p_search%' OR significance_description LIKE '%$p_search%' ORDER BY title ASC";
            } else {
                $sql_pooja = "SELECT * FROM poojas ORDER BY title ASC";
            }

            $pooja_result = $conn->query($sql_pooja);

            if ($pooja_result && $pooja_result->num_rows > 0) {
                while($row = $pooja_result->fetch_assoc()) {
                    echo "<div class='card pooja-card' style='display:flex; flex-direction:column; justify-content:space-between; height:100%;'>";
                    echo "<div><h3>" . $row["title"] . "</h3>";
                    echo "<p style='font-size:0.9rem; color:#555;'>" . $row["significance_description"] . "</p></div>";
                    echo "<div><div style='margin: 10px 0;'><strong style='color:#d9534f;'>".$t['dakshina'].": ₹" . $row["base_dakshina"] . "</strong></div>";
                    echo "<a href='pooja-details.php?id=" . $row["pooja_id"] . "' class='btn-small' style='text-decoration:none; display:block; text-align:center;'>".$t['btn_view']."</a></div>";
                    echo "</div>";
                }
            }
            ?>
        </div>

        <div class="custom-request-box">
            <h3 style="color: #ff4500;"><?php echo $t['custom_h3']; ?></h3>
            <p><?php echo $t['custom_p']; ?></p>
            <a href="pooja-details.php?id=999" class="btn" style="text-decoration: none; padding: 12px 30px; font-weight: bold; background: #ff4500; color: white; border-radius: 5px; display: inline-block; margin-top: 15px;"><?php echo $t['btn_custom']; ?></a>
        </div>
    </section>

    <script>
        window.onscroll = function() {
            var btn = document.getElementById("scrollTop");
            if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                btn.style.display = "block";
            } else {
                btn.style.display = "none";
            }
        };
    </script>
</body>
</html>