<?php
require_once __DIR__ . '/includes/helpers.php';

// Force clear OPCache and PHP garbage collection
clear_website_cache();

// Set anti-cache headers for browser refresh
header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Store success flash message in session
$_SESSION['cache_cleared_msg'] = "Website cache & session status cleared successfully! Speed & latest assets updated.";

// Redirect back to referring page or home page
$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: " . $redirect);
exit;
