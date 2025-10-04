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
    case '/admin/create':
        require_once __DIR__ . '/../app/views/createStudent.php';
        break;
    case '/admin/editStudent':
        require_once __DIR__ . '/../app/views/editStudent.php';
        break;   
    case '/admin/createAdmin':
        require_once __DIR__ . '/../app/views/admincreation.php';
        break;
    case '/admin/createElection':
        require_once __DIR__ . '/../app/views/createElection.php';
        break;
    case '/admin/editElection':
        require_once __DIR__ . '/../app/views/editElection.php';
        break;    
    case '/admin/createClass':
        require_once __DIR__ . '/../app/views/createClass.php';
        break;
    case '/admin/classDetail':
        require_once __DIR__ . '/../app/views/classDetail.php';
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
    case '/vote':
        require_once __DIR__ . '/../app/views/vote.php';
        break;
    case '/generate_token':
        require_once __DIR__ . '/../generate_token.php';
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
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($username === 'superadmin' && $password === 'admin123') {
                $_SESSION['user_type'] = 'super_admin';
                $_SESSION['user_id'] = 1;
                $_SESSION['username'] = 'Super Admin';
                header('Location: /admin');
                exit;
            }
            
            $stmt = mysqli_prepare($conn, "SELECT * FROM admins WHERE email = ? AND password = ? AND status = 'Active'");
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($admin = mysqli_fetch_assoc($result)) {
                $_SESSION['user_type'] = 'class_admin';
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['username'] = $admin['full_name'];
                header('Location: /admin');
                exit;
            }
            
            $error = 'Invalid username or password';
        }
        require_once __DIR__ . '/../app/views/login.php';
        break;

    case '/dashboard':
        require_once __DIR__ . '/../app/controllers/DashboardController.php';
        $controller = new DashboardController();
        $data = $controller->index();
        extract($data);
        require_once __DIR__ . '/../app/views/dashboard.php';
        break;

    case '/admin/class-dashboard':
        require_once __DIR__ . '/../app/views/dashboard.php';
        break;
        
    case '/logout':
        session_destroy();
        header('Location: /login');
        exit;    

    default:
        header("Location: /login");
        exit;
}
