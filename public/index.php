<?php
// Bootstrap file
session_start();

// Configuration
require_once __DIR__ . '/../includes/config.php';

// Handle static files
if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    $file = __DIR__ . $_SERVER["REQUEST_URI"];
    if (file_exists($file)) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $mime_types = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif'
        ];
        
        if (isset($mime_types[$extension])) {
            header('Content-Type: ' . $mime_types[$extension]);
            readfile($file);
            exit;
        }
    }
}

// Router
$route = $_SERVER['REQUEST_URI'];
$route = strtok($route, '?'); // Remove query string if present
$route = rtrim($route, '/'); // Remove trailing slash

// Handle the root URL
if ($route === '') {
    $route = '/login';
}

switch ($route) {
    case '/admin/student':
        require_once __DIR__ . '/../app/views/studentDetail.php';
        break;
        
    case '/admin/class':
        require_once __DIR__ . '/../app/views/classDetail.php';
        break;
        
    case '/admin/admin':
        require_once __DIR__ . '/../app/views/adminDetail.php';
        break;
        
    case '/admin/election':
        require_once __DIR__ . '/../app/views/electionDetail.php';
        break;
        
    case '/admin/winner':
        require_once __DIR__ . '/../app/views/winnerDetail.php';
        break;
        
    case '/admin':
        require_once __DIR__ . '/../app/views/adminPanel.php';
        break;
    case '/register':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $data = $controller->register();
        extract($data);
        
        if (isset($redirect)) {
            header("Location: " . $redirect);
            exit;
        }
        
        require_once __DIR__ . '/../app/views/register.php';
        break;
        
    case '/login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $data = $controller->login();
        extract($data);
        require_once __DIR__ . '/../app/views/login.php';
        break;

    case '/dashboard':
        require_once __DIR__ . '/../app/controllers/DashboardController.php';
        $controller = new DashboardController();
        $data = $controller->index();
        extract($data);
        require_once __DIR__ . '/../app/views/dashboard.php';
        break;

    case '/logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
    case '/logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;    

    default:
        header("Location: /login");
        exit;
}
