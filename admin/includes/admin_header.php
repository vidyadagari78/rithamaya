<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

// Check Admin Authentication
$admin_page = basename($_SERVER['PHP_SELF']);
if ($admin_page !== 'login.php') {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RM Sampoorna - Admin Control Panel</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style CSS (with Cache Busting) -->
    <link rel="stylesheet" href="<?= asset_url('../assets/css/style.css') ?>">
    <style>
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 230px; background: linear-gradient(180deg, #703816 0%, #0D5728 100%); color: #f4ebe0; padding: 24px 0; flex-shrink: 0; }
        .admin-brand { padding: 0 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 10px; }
        .admin-brand img { height: 38px; background: #fff; padding: 4px 8px; border-radius: 8px; }
        .admin-nav { list-style: none; padding: 16px 0; }
        .admin-nav li a { display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #e4d8ca; font-weight: 600; font-size: 0.92rem; transition: all 0.3s; }
        .admin-nav li a:hover, .admin-nav li a.active { background: rgba(92, 184, 50, 0.22); color: #fff; border-left: 4px solid #5CB832; }
        .admin-content { flex-grow: 1; padding: 24px; background: #faf6f0; overflow-x: auto; width: calc(100% - 230px); }
        .admin-header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; background: #fff; padding: 16px 24px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); }
        .stat-card { background: #fff; padding: 20px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }

        /* Admin Mobile Responsiveness */
        @media (max-width: 768px) {
            .admin-wrapper { flex-direction: column !important; }
            .admin-sidebar { width: 100% !important; padding: 16px 12px !important; }
            .admin-brand { padding-bottom: 12px !important; }
            .admin-nav { display: flex !important; flex-wrap: wrap !important; gap: 6px !important; padding: 10px 0 0 !important; }
            .admin-nav li { flex: 1 1 auto !important; margin-top: 0 !important; border-top: none !important; padding-top: 0 !important; }
            .admin-nav li a { padding: 8px 12px !important; font-size: 0.82rem !important; border-radius: 8px !important; justify-content: center !important; }
            .admin-content { width: 100% !important; padding: 14px 10px !important; overflow-x: auto !important; }
            .admin-header-bar { flex-direction: column !important; align-items: flex-start !important; gap: 12px !important; padding: 14px !important; }
            .cart-table, table { display: block !important; width: 100% !important; overflow-x: auto !important; white-space: nowrap !important; }
        }
    </style>
</head>
<body>

<?php if ($admin_page !== 'login.php'): ?>
<div class="admin-wrapper">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <img src="../assets/images/logo.png" alt="Rithamaya Logo" style="background: #ffffff; padding: 4px 8px; border-radius: 6px;">
            <div>
                <h4 style="color:#fff; font-size: 1rem;">Admin Panel</h4>
                <span style="font-size: 0.75rem; color: var(--secondary-color);">Rithamaya</span>
            </div>
        </div>

        <ul class="admin-nav">
            <li><a href="index.php" class="<?= $admin_page == 'index.php' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="products.php" class="<?= $admin_page == 'products.php' ? 'active' : '' ?>"><i class="fas fa-boxes-stacked"></i> Products</a></li>
            <li><a href="orders.php" class="<?= $admin_page == 'orders.php' ? 'active' : '' ?>"><i class="fas fa-shopping-cart"></i> Customer Orders</a></li>
            <li><a href="messages.php" class="<?= $admin_page == 'messages.php' ? 'active' : '' ?>"><i class="fas fa-envelope"></i> Contact Messages</a></li>
            <li><a href="../clear_cache.php" style="color: #69f0ae;"><i class="fas fa-sync-alt"></i> Clear Site Cache</a></li>
            <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                <a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> View Live Site</a>
            </li>
            <li><a href="logout.php" style="color: #ff8a80;"><i class="fas fa-sign-out-alt"></i> Admin Logout</a></li>
        </ul>
    </aside>

    <!-- Main Admin Content Area -->
    <main class="admin-content">
        <div class="admin-header-bar">
            <div>
                <h2 style="font-size: 1.5rem; color: var(--primary-color);">Welcome, Admin Manager 👋</h2>
                <span style="font-size: 0.85rem; color: var(--text-muted);"><?= date('l, F j, Y') ?></span>
            </div>
            <div style="display:flex; gap:10px;">
                <a href="../clear_cache.php" class="btn btn-outline" style="font-size: 0.85rem; padding: 8px 14px; background:#e8f5e9; color:#2e7d32; border-color:#a5d6a7;"><i class="fas fa-bolt"></i> Clear Cache</a>
                <a href="../index.php" target="_blank" class="btn btn-outline" style="font-size: 0.85rem; padding: 8px 16px;"><i class="fas fa-globe"></i> Visit Store</a>
            </div>
        </div>
<?php endif; ?>
