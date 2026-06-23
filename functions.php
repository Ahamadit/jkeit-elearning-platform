<?php
// functions.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

// Check if admin is logged in
function is_admin_logged_in() {
    return !empty($_SESSION['admin_id']);
}
