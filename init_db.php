<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/app/models/User.php';

// Create a new user instance
$user = new User();

// Create an admin user
$username = 'admin';
$password = 'password123';
$email = 'admin@example.com';

if ($user->createUser($username, $password, $email)) {
    echo "Admin user created successfully!\n";
} else {
    echo "Error creating admin user.\n";
}
