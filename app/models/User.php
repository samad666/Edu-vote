<?php
require_once __DIR__ . '/../../includes/Database.php';

class User {
    private $db;

    public function __construct() {
        // Temporarily skip database connection
    }

    public function authenticate($username, $password) {
        // Temporary authentication for testing
        if ($username === 'admin' && $password === 'password123') {
            return true;
        }
        return false;
    }

    public function getUserByUsername($username) {
        // Temporary user data for testing
        if ($username === 'admin') {
            return [
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@example.com',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        return null;
    }

    public function createUser($username, $password, $email) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        try {
            $this->db->query($sql, [$username, $hashedPassword, $email]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
