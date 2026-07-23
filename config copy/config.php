<?php
// SIMPLE config.php - no fancy functions, just basics
define('BASE_PATH', '/Applications/XAMPP/htdocs/conference/');
define('BASE_URL', 'http://localhost/conference/');
define('INCLUDES_PATH', BASE_PATH . 'includes/');
define('ASSETS_URL', BASE_URL . 'assets/');


// Database
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'kalro');

// Site
define('SITE_NAME', 'KALRO Conference');
define('SITE_TAGLINE', 'Advancing Agricultural Innovation Through Research');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die("Database connection failed");
}
mysqli_set_charset($conn, 'utf8mb4');
?>