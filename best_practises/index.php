<?php

// Include necessary files
require_once 'UserRepositoryInterface.php';
require_once 'MySQLUserRepository.php';
require_once 'UserManager.php';

// Create a new database connection
$mysqli = new mysqli("localhost", "username", "password", "database");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Create an instance of MySQLUserRepository with the database connection
$userRepository = new MySQLUserRepository($mysqli);

// Create an instance of UserManager with the repository
$userManager = new UserManager($userRepository);

// Example operations
$user = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'role' => 'admin'
];
$userManager->addUser($user); // Add a new user

$userManager->deleteUser(1); // Delete user with ID 1

$user['id'] = 1; // User ID to update
$user['name'] = 'John Smith'; // Updated name
$userManager->updateUser($user); // Update user

$userManager->listUsers(); // List all users

// Close the database connection
$mysqli->close();
?>
