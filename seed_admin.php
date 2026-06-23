<?php
require_once __DIR__ . '/database.php';

$email = 'raja@gmail.com';
$plain_password = '123';  

// Check if admin exists
$stmt = $conn->prepare("SELECT id FROM admin_login WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    echo "Admin already exists: $email";
    exit;
}

// Insert hashed password
$hash = password_hash($plain_password, PASSWORD_DEFAULT);
$stmt2 = $conn->prepare("INSERT INTO admin_login (email, password) VALUES (?, ?)");
$stmt2->bind_param("ss", $email, $hash);

if ($stmt2->execute()) {
    echo "Admin created.<br>Email: $email<br>Password: $plain_password<br>";
    echo "⚠️ Delete seed_admin.php for security.";
} else {
    echo "Error: " . $conn->error;
}
