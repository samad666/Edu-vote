<?php
class DashboardController {
    private $userModel;

    public function __construct() {
        require_once __DIR__ . '/../models/User.php';
        $this->userModel = new User();
    }

    public function index() {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /login");
            exit;
        }

        $user = $this->userModel->getUserByUsername($_SESSION['username']);
        
        // Add stats for the dashboard
        $stats = [
            'total_students' => 1250,
            'total_classes' => 45,
            'total_elections' => 12,
            'participation_rate' => 78
        ];

        return [
            'user' => $user,
            'stats' => $stats,
            'page_title' => 'Dashboard'
        ];
    }
}
