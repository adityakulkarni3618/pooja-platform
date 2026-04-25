<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Set default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// 2. Update language if user clicks the toggle
if (isset($_GET['lang'])) {
    $allowed = ['en', 'mr'];
    if (in_array($_GET['lang'], $allowed)) {
        $_SESSION['lang'] = $_GET['lang'];
    }
}

$current_lang = $_SESSION['lang'];

// 3. Your Translation Dictionary
// 3. Your Translation Dictionary
$texts = [
    'en' => [
        'home' => 'Home',
        'library' => 'Library',
        'booking' => 'Book a Pooja',
        'login' => 'Guruji Login',
        'dashboard' => 'Dashboard',
        'logout' => 'Logout',
        'dakshina' => 'Dakshina',
        'status' => 'Status',
        'address' => 'Address',
        'action' => 'Action',
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
        'btn_view' => 'View Samagri & Book',
        'custom_h3' => "Can't find the Pooja you need?",
        'custom_p' => "If you have a specific ritual not listed, send a custom request.",
        'btn_custom' => 'Send Custom Request',
        'lang_toggle' => 'मराठीत पहा' // Changed from 'lang_btn' to match index.php
    ],
    'mr' => [
        'home' => 'मुख्यपृष्ठ',
        'library' => 'ग्रंथालय',
        'booking' => 'पूजा बुकिंग',
        'login' => 'गुरुजी लॉगिन',
        'dashboard' => 'डॅशबोर्ड',
        'logout' => 'लॉगआउट',
        'dakshina' => 'दक्षिणा',
        'status' => 'स्थिती',
        'address' => 'पत्ता',
        'action' => 'कृती',
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
        'btn_view' => 'साहित्य पहा आणि बुक करा',
        'custom_h3' => "हवी ती पूजा सापडत नाहीये?",
        'custom_p' => "यादीत नसल्यास, तुमची विशेष विनंती गुरुजींना पाठवा.",
        'btn_custom' => 'विशेष विनंती पाठवा',
        'lang_toggle' => 'Switch to English' // Changed from 'lang_btn' to match index.php
    ]
];

$t = $texts[$current_lang];
?>