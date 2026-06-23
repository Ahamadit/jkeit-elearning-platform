<?php
// ----------------------
// LOCALHOST CONFIG (XAMPP/WAMP)
// ----------------------

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "jkeit";  



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ----------------------
// LIVE SERVER CONFIG (Hostinger)
// ----------------------
// $servername = "localhost";        
// $username   = "u825082873_jkeit_user";       
// $password   = "Jkeit@97";      
// $dbname     = "u825082873_jkeit";            

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Optional: remove echo in production

?>
