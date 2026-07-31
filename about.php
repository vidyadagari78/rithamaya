<?php
require_once __DIR__ . '/includes/header.php';
?>

<!-- About Us Page Hero Banner (With Rich Background Image & Badges) -->
<div class="shop-hero-banner" style="background: linear-gradient(rgba(14, 35, 26, 0.78), rgba(14, 35, 26, 0.85)), url('assets/images/shop_banner_bg.png') center/cover no-repeat; padding: 50px 0; margin-bottom: 50px;">
    <div class="container shop-banner-content" style="text-align: center; color: #fff;">
        <span style="color: #5CB832; font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 6px;">OUR HERITAGE & MISSION</span>
        <h1 class="shop-banner-title" style="font-size: 2.6rem; font-weight: 900; color: #fff; margin-bottom: 8px;">About RM's Sampoorna</h1>
        <p class="shop-banner-subtitle" style="color: #d8f3dc; font-size: 1.05rem; max-width: 650px; margin: 0 auto 24px;">Our story, traditional roots, and commitment to 100% natural, unadulterated food products</p>
        
        <!-- Floating Feature Badges Row -->
        <div class="shop-banner-badges">
            <div class="banner-badge-item">
                <i class="fas fa-leaf"></i> <span>100% ORGANIC</span>
            </div>
            <div class="banner-badge-item">
                <i class="fas fa-house-chimney"></i> <span>HOME MADE</span>
            </div>
            <div class="banner-badge-item">
                <i class="fas fa-ban"></i> <span>NO PRESERVATIVES</span>
            </div>
            <div class="banner-badge-item">
                <i class="fas fa-truck-fast"></i> <span>FAST SHIPPING</span>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 70px;">
    <!-- Story Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; margin-bottom: 60px;">
        <div>
            <span class="section-subtitle">Our Heritage</span>
            <h2 style="font-size: 2.2rem; margin-bottom: 18px;">Bringing Authentic Homemade Taste To Every Kitchen</h2>
            <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 16px;">
                RM's Sampoorna Food Products (Rithamaya) was born out of a passion to revive genuine, traditional recipes passed down through generations in Karnataka. 
            </p>
            <p style="color: var(--text-muted); line-height: 1.8;">
                In an era dominated by mass-manufactured, chemically enhanced spice blends and processed cereals, we remain committed to 100% sun-dried whole spices, slow roasting, and handpicked natural grains.
            </p>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=800&auto=format&fit=crop" alt="RM Sampoorna Kitchen Spices" style="border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
        </div>
    </div>

    <!-- Core Values -->
    <div class="section-title">
        <span class="section-subtitle">Pillars of Trust</span>
        <h2>Why Families Love RM's Sampoorna</h2>
    </div>

    <div class="feature-grid">
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-leaf"></i></div>
            <h3 class="feature-title">Pure & Natural</h3>
            <p class="feature-desc">Zero preservatives, artificial colors, anti-caking agents, or synthetic flavors.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-seedling"></i></div>
            <h3 class="feature-title">Sprouted Ragi Sari</h3>
            <p class="feature-desc">Slow-sprouted ragi dried under sunlight to maximize bioavailable iron and calcium.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-mortar-pestle"></i></div>
            <h3 class="feature-title">Small Batch Crafting</h3>
            <p class="feature-desc">Small batch production guarantees maximum freshness and essential oil retention.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-heart"></i></div>
            <h3 class="feature-title">Made With Love</h3>
            <p class="feature-desc">Prepared in hygienic, home-style kitchens adhering to traditional proportions.</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
