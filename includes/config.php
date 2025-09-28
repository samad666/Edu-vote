<?php

// ================================
// Base Settings
// ================================
session_start(); // important!

define('BASE_URL', 'http://localhost/eduvote/');
define('ASSETS_URL', BASE_URL . 'assets/');

$site_name = 'EduVote';
$admin_name = $_SESSION['admin_name'] ?? 'Admin User';

// ================================
// Functions
// ================================
function setActivePage($page) {
    global $current_page;
    $current_page = $page;
}

function setPageTitle($title) {
    global $page_title;
    $page_title = $title;
}

// ================================
// Database Connection (MySQLi Procedural)
// ================================
// define('DB_HOST', '127.0.0.1');  
// define('DB_NAME', 'eduvote');    
// define('DB_USER', 'eduvote_user');   
// define('DB_PASS', 'eduvote_pass');   

define('DB_HOST', '127.0.0.1');  
define('DB_NAME', 'eduvote');    
define('DB_USER', 'root');   
define('DB_PASS', ''); 


// Username	root
// Password	(Empty String) or '' (no password)
// Host	127.0.0.1 or localhost
// Port	3306 (Explicitly set in the file)
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("❌ Database Connection Failed: " . mysqli_connect_error());
}

// ================================
// Helper Functions (Optional)
// ================================
/**
 * Run a query safely
 */
function dbQuery($sql) {
    global $conn;
    return mysqli_query($conn, $sql);
}

/**
 * Fetch all rows as associative array
 */
function dbFetchAll($result) {
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Escape user input to prevent SQL injection
 */
function dbEscape($value) {
    global $conn;
    return mysqli_real_escape_string($conn, $value);
}

// ================================
// Enable Error Reporting for Debug
// ================================
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
