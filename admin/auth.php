<?php
require_once __DIR__ . '/../functions.php';

if (!is_admin_logged_in()) {
    header('Location: login.php');
    exit;
}
 