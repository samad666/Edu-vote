<?php
// Helper functions for the application

/**
 * Get current date in a formatted string
 * @return string
 */
function getCurrentDate() {
    return date('Y-m-d H:i:s');
}

/**
 * Sanitize user input
 * @param string $input
 * @return string
 */
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

/**
 * Generate a random string
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
