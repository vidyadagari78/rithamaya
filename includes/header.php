<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/helpers.php';
$cart_count = get_cart_count();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RM's Sampoorna Food Products | 100% Organic & Healthy</title>
    <meta name="description" content="Pure organic masalas, health mixes, baby ragi sari, and homemade traditional spices. Shop RM's Sampoorna for fresh nutrition.">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main Style CSS (with Cache Busting) -->
    <link rel="stylesheet" href="<?= asset_url('assets/css/style.css') ?>">
</head>
<body>

    <!-- Cookie Enabled Detector & Cache Notification Banner -->
    <div id="cookieWarningBanner" class="alert-banner warning" style="display: none; background: #fff3cd; color: #856404; padding: 10px 16px; text-align: center; border-bottom: 1px solid #ffeeba; font-size: 0.9rem;">
        ⚠️ <strong>Cookies are disabled in your browser!</strong> Please enable cookies or turn off private browsing mode to ensure your cart and login work properly.
    </div>

    <?php if (isset($_SESSION['cache_cleared_msg'])): ?>
        <div class="alert-banner success" style="background: #d4edda; color: #155724; padding: 10px 16px; text-align: center; border-bottom: 1px solid #c3e6cb; font-size: 0.9rem;">
            ✅ <?= htmlspecialchars($_SESSION['cache_cleared_msg']) ?>
        </div>
        <?php unset($_SESSION['cache_cleared_msg']); ?>
    <?php endif; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (!navigator.cookieEnabled) {
                var banner = document.getElementById("cookieWarningBanner");
                if (banner) banner.style.display = "block";
            }
        });
    </script>

    <!-- Single Moving Announcement Ticker Bar -->
    <div class="top-ticker-bar">
        <div class="ticker-track">
            <div class="ticker-content">
                <span>🌿 100% Pure Organic & Homemade</span>
                <span>📞 Call / WhatsApp: <a href="tel:+919876543210">+91 98765 43210</a></span>
                <span>🔥 Get <strong>10% OFF</strong> on 35+ Multigrain Health Mix! Code: <strong>SAMPOORNA10</strong></span>
                <span>🚚 Free Delivery Above ₹499</span>
                <span>📜 FSSAI Lic. No: <strong>21223000000000</strong></span>
                <span>👶 Natural Sprouted Baby Ragi Sari</span>
            </div>
            <div class="ticker-content">
                <span>🌿 100% Pure Organic & Homemade</span>
                <span>📞 Call / WhatsApp: <a href="tel:+919876543210">+91 98765 43210</a></span>
                <span>🔥 Get <strong>10% OFF</strong> on 35+ Multigrain Health Mix! Code: <strong>SAMPOORNA10</strong></span>
                <span>🚚 Free Delivery Above ₹499</span>
                <span>📜 FSSAI Lic. No: <strong>21223000000000</strong></span>
                <span>👶 Natural Sprouted Baby Ragi Sari</span>
            </div>
        </div>
    </div>

    <!-- Main Header Navbar -->
    <header class="main-header">
        <div class="container">
            <div class="header-wrapper">
                <!-- Brand Logo -->
                <a href="index.php" class="logo">
                    <img src="assets/images/logo.png" alt="Rithamaya Logo" class="brand-logo-img">
                </a>

                <!-- Navigation Links -->
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a></li>
                    <li><a href="shop.php" class="nav-link <?= $current_page == 'shop.php' ? 'active' : '' ?>">Shop Products</a></li>
                    <li><a href="about.php" class="nav-link <?= $current_page == 'about.php' ? 'active' : '' ?>">About Us</a></li>
                    <li><a href="faq.php" class="nav-link <?= $current_page == 'faq.php' ? 'active' : '' ?>">FAQs</a></li>
                    <li><a href="contact.php" class="nav-link <?= $current_page == 'contact.php' ? 'active' : '' ?>">Contact Us</a></li>
                </ul>

                <!-- Header Action Icons -->
                <div class="header-actions">
                    <form action="shop.php" method="GET" class="search-form">
                        <input type="text" name="q" placeholder="Search masalas..." class="search-input">
                        <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    </form>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="account.php" class="action-btn" title="My Account">
                            <i class="fas fa-user-check"></i>
                        </a>
                        <a href="logout.php" class="action-btn" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="action-btn" title="Login / Register">
                            <i class="fas fa-user"></i>
                        </a>
                    <?php endif; ?>

                    <a href="cart.php" class="action-btn" title="Shopping Cart">
                        <i class="fas fa-shopping-basket"></i>
                        <span class="badge-count"><?= $cart_count ?></span>
                    </a>

                    <button class="mobile-toggle" id="mobileToggleBtn" aria-label="Toggle navigation" aria-expanded="false">
                        <i class="fas fa-bars" id="mobileToggleIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="closeMobileNav()" style="display: none;"></div>
    <nav class="mobile-nav-drawer" id="mobileNavDrawer" style="display: none;">
        <div class="mobile-nav-header">
            <img src="assets/images/logo.png" alt="Rithamaya" style="height:40px; width:auto; background: #fff; padding: 4px 8px; border-radius: 6px;">
            <button class="mobile-nav-close" onclick="closeMobileNav()" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="index.php" onclick="closeMobileNav()"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="shop.php" onclick="closeMobileNav()"><i class="fas fa-store"></i> Shop Products</a></li>
            <li><a href="about.php" onclick="closeMobileNav()"><i class="fas fa-leaf"></i> About Us</a></li>
            <li><a href="faq.php" onclick="closeMobileNav()"><i class="fas fa-question-circle"></i> FAQs</a></li>
            <li><a href="terms.php" onclick="closeMobileNav()"><i class="fas fa-file-contract"></i> Terms & Conditions</a></li>
            <li><a href="contact.php" onclick="closeMobileNav()"><i class="fas fa-envelope"></i> Contact Us</a></li>
        </ul>
        <div class="mobile-nav-footer">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="account.php" class="mobile-nav-action-btn" onclick="closeMobileNav()">
                    <i class="fas fa-user-check"></i> My Account
                </a>
                <a href="logout.php" class="mobile-nav-action-btn" onclick="closeMobileNav()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php else: ?>
                <a href="login.php" class="mobile-nav-action-btn" onclick="closeMobileNav()">
                    <i class="fas fa-user"></i> Login / Register
                </a>
            <?php endif; ?>
            <a href="cart.php" class="mobile-nav-action-btn mobile-cart-btn" onclick="closeMobileNav()">
                <i class="fas fa-shopping-basket"></i> Cart
                <?php if ($cart_count > 0): ?>
                    <span class="mobile-cart-badge"><?= $cart_count ?></span>
                <?php endif; ?>
            </a>
        </div>
    </nav>

    <script>
    function openMobileNav() {
        const drawer = document.getElementById('mobileNavDrawer');
        const overlay = document.getElementById('mobileNavOverlay');
        drawer.style.display = 'flex';
        overlay.style.display = 'block';
        setTimeout(function() {
            drawer.classList.add('open');
            overlay.classList.add('open');
        }, 10);
        document.getElementById('mobileToggleIcon').className = 'fas fa-times';
        document.getElementById('mobileToggleBtn').setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
    function closeMobileNav() {
        const drawer = document.getElementById('mobileNavDrawer');
        const overlay = document.getElementById('mobileNavOverlay');
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        setTimeout(function() {
            drawer.style.display = 'none';
            overlay.style.display = 'none';
        }, 300);
        document.getElementById('mobileToggleIcon').className = 'fas fa-bars';
        document.getElementById('mobileToggleBtn').setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }
    document.getElementById('mobileToggleBtn').addEventListener('click', function() {
        const drawer = document.getElementById('mobileNavDrawer');
        if (drawer.classList.contains('open') || drawer.style.display === 'flex') {
            closeMobileNav();
        } else {
            openMobileNav();
        }
    });
    </script>

    <!-- Flash Message Container -->
    <?php if (isset($_SESSION['success_msg']) || isset($_SESSION['error_msg'])): ?>
    <div class="container" style="margin-top: 20px;">
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success">
                <span><i class="fas fa-check-circle"></i> <?= $_SESSION['success_msg']; ?></span>
                <i class="fas fa-times" style="cursor:pointer;" onclick="this.parentElement.remove();"></i>
            </div>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger">
                <span><i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error_msg']; ?></span>
                <i class="fas fa-times" style="cursor:pointer;" onclick="this.parentElement.remove();"></i>
            </div>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>
