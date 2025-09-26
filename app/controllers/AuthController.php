<?php
class AuthController {
    private $userModel;

    public function __construct() {
        require_once __DIR__ . '/../models/User.php';
        $this->userModel = new User();
    }

    public function login() 
     {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $this->sanitizeInput($_POST['username']);
            $password = $_POST['password'];

            if ($this->userModel->authenticate($username, $password)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("Location: /dashboard");
                exit;
            } else {
                return ['error' => "Invalid username or password"];
            }
        }
        return [];
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $this->sanitizeInput($_POST['username']);
            $email = $this->sanitizeInput($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validate input
            if (strlen($username) < 3) {
                return ['error' => "Username must be at least 3 characters long"];
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['error' => "Please enter a valid email address"];
            }
            
            if (strlen($password) < 6) {
                return ['error' => "Password must be at least 6 characters long"];
            }
            
            if ($password !== $confirmPassword) {
                return ['error' => "Passwords do not match"];
            }
            
            // Attempt to create the user
            if ($this->userModel->createUser($username, $password, $email)) {
                return [
                    'success' => "Account created successfully! You can now login.",
                    'redirect' => '/login'
                ];
            } else {
                return ['error' => "Username or email already exists"];
            }
        }
        return [];
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        header("Location: /login");
        exit;
    }

    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }
}
