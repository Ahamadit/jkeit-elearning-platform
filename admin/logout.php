<?php
// admin/logout.php
require_once __DIR__ . '/../functions.php'; // Correct path to functions.php

// Destroy session and logout
session_start();
session_unset();
session_destroy();

header("Location: login.php");
exit;
