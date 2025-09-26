<?php
// Base path for the application
define('BASE_PATH', dirname(__DIR__));

// Get the request URI
$request_uri = $_SERVER['REQUEST_URI'];

// Remove query string if present
$request_uri = strtok($request_uri, '?');

// Routes configuration
$routes = [
    '/admin' => 'views/adminPanel.php',
    '/admin/class' => 'views/classDetail.php',
    '/admin/admin' => 'views/adminDetail.php',
    '/admin/election' => 'views/electionDetail.php',
    '/admin/winner' => 'views/winnerDetail.php',
    '/admin/student' => 'views/studentDetail.php'
];

// Clean up the request URI
$request_uri = rtrim($request_uri, '/');

// Set default route
if (empty($request_uri)) {
    $request_uri = '/admin';
}

// Handle the routing
if (isset($routes[$request_uri])) {
    $file_path = BASE_PATH . '/app/' . $routes[$request_uri];
    if (file_exists($file_path)) {
        require $file_path;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "View file not found: " . $routes[$request_uri];
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Page not found";
}
