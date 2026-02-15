<?php
// --- Create Admin User ---
// This script should be run once from the command line or browser
// to create the initial admin user. 
// IMPORTANT: Delete this file after running it for security reasons.

require_once 'config/database.php';

// --- Configuration ---
$admin_username = 'admin';
$admin_password = 'password123'; // You can change this
$admin_fullname = 'Administrator';

// --- Logic ---
echo "Attempting to create admin user...\n";

// Hash the password securely
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

// Check if user already exists
try {
    $stmt = $pdo->prepare("SELECT id_user FROM users WHERE username = ?");
    $stmt->execute([$admin_username]);
    if ($stmt->fetch()) {
        echo "Error: User '$admin_username' already exists.\n";
        exit;
    }

    // Insert the new admin user
    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password, full_name) VALUES (?, ?, ?)"
    );
    $stmt->execute([$admin_username, $hashed_password, $admin_fullname]);

    echo "--------------------------------------------------\n";
    echo "Success! Admin user created.\n";
    echo "Username: " . $admin_username . "\n";
    echo "Password: " . $admin_password . "\n";
    echo "--------------------------------------------------\n";
    echo "IMPORTANT: You should now delete this file (create_admin_user.php) for security!\n";

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

?>