<?php
require_once __DIR__ . '/../includes/helpers.php';
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_email']);
header("Location: login.php");
exit;
