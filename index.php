<?php
require_once __DIR__ . '/includes/header.php';

// Fetch Products from Database or Fallback Mock Data
$all_products = [];
if ($GLOBALS['db_connected']) {
    try {
        $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.updated_at DESC, p.id DESC");
        $all_products = $stmt->fetchAll();
    } catch (Exception $e) {
        $all_products = [];
    }
}

if (empty($all_products)) {
    $all_products = get_mock_products();
}
?>

<!-- 1. Hero Banner Slider Section (Full-Width Reference Match) -->
<section class="hero-section new-hero-bg hero-slide-honey">
    <div class="container" style="padding: 40px 15px 35px;">
        <div class="hero-slider-wrapper">
            <!-- Slide 1: RITHAMAYA Baby Ragi Sari Powder -->
            <div class="hero-slide active">
                <div class="new-hero-grid">
                    <div class="new-hero-content">
                        <span class="new-hero-tag">6 MONTHS TO 36 MONTHS</span>
                        <h1 class="new-hero-title">
                            Gentle Sprouted Ragi<br><span>Baby Cereal Powder</span>
                        </h1>
                        <div style="margin-bottom: 24px;">
                            <a href="product.php?id=2" class="btn new-hero-btn">Explore Baby Ragi Sari</a>
                        </div>
                        <div class="new-hero-rating">
                            <div class="rating-dots">
                                <span style="background:#5CB832;"></span>
                                <span style="background:#703816;"></span>
                                <span style="background:#0D5728;"></span>
                            </div>
                            <span><strong>4.9/5</strong> from 3,500+ happy mothers</span>
                        </div>
                        <div class="new-hero-trust-bar">
                            <span><i class="fas fa-award"></i> 100% Sprouted Ragi</span>
                            <span><i class="fas fa-shield-check"></i> NO Preservatives</span>
                            <span><i class="fas fa-heart"></i> NO Added Sugar</span>
                            <span><i class="fas fa-leaf"></i> Easy Digestion</span>
                        </div>
                    </div>
                    <div class="new-hero-media">
                        <div class="new-hero-video-container">
                            <video class="new-hero-video" autoplay loop muted playsinline poster="assets/images/products/baby-ragi-sari.png">
                                <source src="assets/videos/hero-banner-video.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="hero-video-badge"><i class="fas fa-play-circle"></i> Baby Ragi Sari Video</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: 35+ Multigrain Health Mix -->
            <div class="hero-slide" data-theme="hero-slide-green">
                <div class="new-hero-grid">
                    <div class="new-hero-content">
                        <span class="new-hero-tag">100% ORGANIC & PURE</span>
                        <h1 class="new-hero-title">
                            Daily Nourishment<br>for <span>All Age Groups</span>
                        </h1>
                        <div style="margin-bottom: 24px;">
                            <a href="product.php?id=1" class="btn new-hero-btn">Explore Health Mix</a>
                        </div>
                        <div class="new-hero-rating">
                            <div class="rating-dots">
                                <span style="background:#e65100;"></span>
                                <span style="background:#f57c00;"></span>
                                <span style="background:#ffb74d;"></span>
                            </div>
                            <span><strong>4.9/5</strong> from 2,000+ happy customers</span>
                        </div>
                        <div class="new-hero-trust-bar">
                            <span><i class="fas fa-award"></i> Heritage Recipe</span>
                            <span><i class="fas fa-flag"></i> Make in India</span>
                            <span><i class="fas fa-shield-check"></i> FSSAI Certified</span>
                            <span><i class="fas fa-leaf"></i> Pure and Natural</span>
                        </div>
                    </div>
                    <div class="new-hero-media">
                        <div class="new-hero-video-container">
                            <video class="new-hero-video" autoplay loop muted playsinline poster="assets/images/products/multigrain-health-mix.png">
                                <source src="assets/videos/hero-banner-video.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="hero-video-badge"><i class="fas fa-play-circle"></i> 100% Organic Preparation</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Karnataka Sambar Powder -->
            <div class="hero-slide" data-theme="hero-slide-coral">
                <div class="new-hero-grid">
                    <div class="new-hero-content">
                        <span class="new-hero-tag">HOMEMADE SPICE BLENDS</span>
                        <h1 class="new-hero-title">
                            Authentic Karnataka<br><span>Sambar & Masala Powders</span>
                        </h1>
                        <div style="margin-bottom: 24px;">
                            <a href="product.php?id=7" class="btn new-hero-btn">Explore Masalas</a>
                        </div>
                        <div class="new-hero-rating">
                            <div class="rating-dots">
                                <span style="background:#e65100;"></span>
                                <span style="background:#f57c00;"></span>
                                <span style="background:#ffb74d;"></span>
                            </div>
                            <span><strong>4.9/5</strong> from 2,000+ happy customers</span>
                        </div>
                        <div class="new-hero-trust-bar">
                            <span><i class="fas fa-award"></i> Sun-Dried Spices</span>
                            <span><i class="fas fa-flag"></i> Make in India</span>
                            <span><i class="fas fa-shield-check"></i> FSSAI Certified</span>
                            <span><i class="fas fa-leaf"></i> Pure and Natural</span>
                        </div>
                    </div>
                    <div class="new-hero-media">
                        <div class="new-hero-video-container">
                            <video class="new-hero-video" autoplay loop muted playsinline poster="assets/images/products/sambar-powder.png">
                                <source src="assets/videos/hero-banner-video.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="hero-video-badge"><i class="fas fa-play-circle"></i> Sun-Dried Spice Processing</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 4: Dhaniya Powder -->
            <div class="hero-slide" data-theme="hero-slide-amber">
                <div class="new-hero-grid">
                    <div class="new-hero-content">
                        <span class="new-hero-tag">FRESH GROUND SPICES</span>
                        <h1 class="new-hero-title">
                            Pure and Natural<br><span>Dhaniya Coriander Magic</span>
                        </h1>
                        <div style="margin-bottom: 24px;">
                            <a href="product.php?id=4" class="btn new-hero-btn">Explore Spices</a>
                        </div>
                        <div class="new-hero-rating">
                            <div class="rating-dots">
                                <span style="background:#e65100;"></span>
                                <span style="background:#f57c00;"></span>
                                <span style="background:#ffb74d;"></span>
                            </div>
                            <span><strong>4.9/5</strong> from 2,000+ happy customers</span>
                        </div>
                        <div class="new-hero-trust-bar">
                            <span><i class="fas fa-award"></i> Freshly Ground</span>
                            <span><i class="fas fa-flag"></i> Make in India</span>
                            <span><i class="fas fa-shield-check"></i> FSSAI Certified</span>
                            <span><i class="fas fa-leaf"></i> Pure and Natural</span>
                        </div>
                    </div>
                    <div class="new-hero-media">
                        <div class="new-hero-video-container">
                            <video class="new-hero-video" autoplay loop muted playsinline poster="assets/images/products/dhaniya-powder.png">
                                <source src="assets/videos/hero-banner-video.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="hero-video-badge"><i class="fas fa-play-circle"></i> Authentic Home Grinding</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slider Dots -->
            <div class="slider-dots">
                <span class="dot active" onclick="currentSlide(0)"></span>
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>
    </div>
</section>

<!-- 2. Section: 100% Organic Products (Product Grid Matching Reference Design) -->
<section class="section" style="padding: 40px 0 60px;">
    <div class="container">
        <h2 style="font-size: 2rem; font-family: var(--font-heading); color: #1b4332; text-align: left; margin-bottom: 30px; font-weight: 800;">100% Organic Products</h2>

        <div class="product-grid">
            <?php foreach (array_slice($all_products, 0, 8) as $product): ?>
                <?php 
                    $cat_slug = strtolower(str_replace([' & ', ' '], '-', $product['category_name'] ?? ''));
                ?>
                <div class="product-card" data-category="<?= $cat_slug ?>">
                    <!-- Image Stage with Top Right Corner Badge -->
                    <div class="product-img-wrapper">
                        <?php if (!empty($product['badge'])): ?>
                            <span class="product-corner-badge">
                                <?= strtoupper(sanitize($product['badge'])) ?>
                            </span>
                        <?php endif; ?>
                        
                        <a href="product.php?id=<?= $product['id'] ?>" class="product-img-link">
                            <img src="<?= sanitize($product['image']) ?>" alt="<?= sanitize($product['name']) ?>" class="product-img">
                        </a>
                    </div>

                    <!-- Details -->
                    <div class="product-details">
                        <!-- Title & Rating Row -->
                        <div class="ref-title-rating-row">
                            <h3 class="product-title">
                                <a href="product.php?id=<?= $product['id'] ?>"><?= sanitize($product['name']) ?></a>
                            </h3>
                            <span class="ref-star-rating"><i class="fas fa-star" style="color:#5CB832;"></i> 4.5</span>
                        </div>

                        <!-- Category Subtitle -->
                        <div class="ref-category-sub"><?= sanitize($product['category_name'] ?? 'RM SAMPOORNA') ?></div>

                        <!-- Price & Strikethrough Row -->
                        <div class="ref-price-discount-row">
                            <span class="ref-main-price"><?= format_price($product['price']) ?></span>
                            <span class="ref-unit-text">/ pack</span>
                            <span class="ref-original-price"><s><?= format_price($product['price'] * 1.15) ?></s></span>
                        </div>

                        <!-- Pack Weight Info -->
                        <div class="ref-pack-info">Pack Weight: <?= sanitize($product['weight']) ?></div>

                        <!-- Quantity & Add to Cart Form -->
                        <form action="cart.php" method="POST" style="margin-top: auto;">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                            <!-- Quantity Selector Pill -->
                            <div class="ref-qty-pill">
                                <button type="button" class="ref-qty-btn" onclick="updateQty(this, -1)">-</button>
                                <input type="number" name="quantity" value="1" min="1" class="qty-input ref-qty-val" style="width: 40px; text-align: center; border: none; background: transparent; font-weight: 800; font-size: 0.95rem; color: #000;">
                                <button type="button" class="ref-qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>

                            <!-- Action Buttons Row -->
                            <div class="ref-actions-row">
                                <button type="submit" class="ref-cart-green-btn">
                                    <i class="fas fa-shopping-cart" style="margin-right: 4px;"></i> Add to Cart
                                </button>
                                <a href="product.php?id=<?= $product['id'] ?>" class="ref-bulk-inquiry-btn">
                                    <i class="fas fa-eye" style="margin-right: 4px;"></i> View Details
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="shop.php" class="btn ref-purchase-btn" style="border-radius: 30px !important; padding: 14px 38px !important;">Explore All Products <i class="fas fa-arrow-right" style="margin-left: 6px;"></i></a>
        </div>
    </div>
</section>

<!-- 3. Section: Feature Highlights (Ultra-Modern Premium Redesign) -->
<section style="background: linear-gradient(135deg, #f7faf8 0%, #edf5f0 100%); padding: 50px 0; border-top: 1px solid rgba(0,135,68,0.1); border-bottom: 1px solid rgba(0,135,68,0.1);">
    <div class="container">
        <div class="feature-highlights-grid">
            <!-- Card 1 -->
            <div class="feature-highlight-card">
                <div class="feature-highlight-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <div>
                    <span class="feature-highlight-pill">GUARANTEED PURE</span>
                    <h4 class="feature-highlight-title">100% Organic & Pure</h4>
                    <p class="feature-highlight-desc">Zero chemical preservatives, synthetic dyes, or artificial flavors.</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="feature-highlight-card">
                <div class="feature-highlight-icon">
                    <i class="fas fa-mortar-pestle"></i>
                </div>
                <div>
                    <span class="feature-highlight-pill">HERITAGE RECIPE</span>
                    <h4 class="feature-highlight-title">Handcrafted Homemade</h4>
                    <p class="feature-highlight-desc">Prepared with love following heritage family recipes from Karnataka.</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="feature-highlight-card">
                <div class="feature-highlight-icon">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <span class="feature-highlight-pill">EXPRESS DISPATCH</span>
                    <h4 class="feature-highlight-title">Fast All India Shipping</h4>
                    <p class="feature-highlight-desc">Hassle-free express doorstep delivery across all pin codes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Section: Wholesome Authentic Taste Philosophy (Ultra-Modern Glassmorphism Card Redesign) -->
<section style="padding: 70px 0; background: #ffffff;">
    <div class="container">
        <div class="wholesome-banner-card">
            <div>
                <span class="wholesome-badge">🌿 HERITAGE INGREDIENTS & TRADITIONAL TASTE</span>
                <h2 class="wholesome-title">
                    Wholesome Authentic Taste <i class="fas fa-wheat-awn" style="color: #5CB832;"></i><br>Goodness Anytime <i class="fas fa-pepper-hot" style="color: #703816;"></i>
                </h2>
                <p class="wholesome-desc">
                    We bring the rich taste of traditional Karnataka kitchens right to your doorstep. All our ingredients are sun-dried and ground carefully to maintain essential natural oils, authentic aromas, and nutritional power.
                </p>
                
                <div class="wholesome-bullets-grid">
                    <div><i class="fas fa-sun" style="color: #5CB832; font-size: 1rem; margin-right: 6px;"></i> 100% Sun-Dried Spices</div>
                    <div><i class="fas fa-mortar-pestle" style="color: #0D5728; font-size: 1rem; margin-right: 6px;"></i> Heritage Recipes</div>
                    <div><i class="fas fa-shield-heart" style="color: #008744; font-size: 1rem; margin-right: 6px;"></i> Zero Chemical Additives</div>
                    <div><i class="fas fa-leaf" style="color: #008744; font-size: 1rem; margin-right: 6px;"></i> Fresh Batch Ground</div>
                </div>

                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 24px;">
                    <a href="shop.php?category=health-mixes" class="wholesome-cat-chip">MULTIGRAIN MIXES</a>
                    <a href="shop.php?category=baby-food" class="wholesome-cat-chip">BABY CARE</a>
                    <a href="shop.php?category=masala-powders" class="wholesome-cat-chip">KARNATAKA MASALAS</a>
                    <a href="shop.php?category=sweets-laddus" class="wholesome-cat-chip">DRY FRUIT LADDUS</a>
                </div>
            </div>

            <div style="text-align: center; position: relative;">
                <div class="wholesome-img-glow"></div>
                <img src="assets/images/products/dry-fruits-laddu.jpg" alt="RM's Sampoorna Home Made Dry Fruits Laddu" class="wholesome-jar-img">
            </div>
        </div>
    </div>
</section>

<!-- 5. Section: Quality Feature Diagram ("Pure & Organic Features") -->
<section style="background: #faf6f0; padding: 75px 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 45px;">
            <span style="color: #5CB832; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1.5px;">QUALITY PROMISE</span>
            <h2 style="font-size: 2.3rem; font-family: var(--font-heading); color: #0D5728; margin-top: 6px; font-weight: 900;">Pure & Organic Goodness</h2>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1.2fr 1fr; gap: 30px; align-items: center;">
            <!-- Left Features Column -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <div style="background: #ffffff; padding: 22px 20px; border-radius: 18px; box-shadow: 0 6px 20px rgba(13, 87, 40, 0.05); border: 1px solid #e8dfd5; display: flex; gap: 16px; align-items: center;">
                    <div style="font-size: 1.6rem; color: #5CB832; background: #e8f5e9; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-sun"></i></div>
                    <div>
                        <h4 style="font-size: 1.05rem; color: #0D5728; font-weight: 800; margin-bottom: 4px;">Sun-Dried Spices</h4>
                        <p style="font-size: 0.84rem; color: #665b53; line-height: 1.45;">Slow roasted to retain natural aroma and essential oils.</p>
                    </div>
                </div>
                <div style="background: #ffffff; padding: 22px 20px; border-radius: 18px; box-shadow: 0 6px 20px rgba(13, 87, 40, 0.05); border: 1px solid #e8dfd5; display: flex; gap: 16px; align-items: center;">
                    <div style="font-size: 1.6rem; color: #5CB832; background: #e8f5e9; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-baby"></i></div>
                    <div>
                        <h4 style="font-size: 1.05rem; color: #0D5728; font-weight: 800; margin-bottom: 4px;">Infant Safe Nutrition</h4>
                        <p style="font-size: 0.84rem; color: #665b53; line-height: 1.45;">Sprouted ragi rich in natural calcium for toddler bone health.</p>
                    </div>
                </div>
            </div>

            <!-- Center Product Showcase (Transparent Background, No White Container) -->
            <div style="text-align: center; display: flex; align-items: center; justify-content: center; padding: 10px;">
                <img src="assets/images/products/multigrain-health-mix-400g.png" alt="Pure Ingredients Showcase" style="max-height: 350px; max-width: 100%; width: auto; object-fit: contain; filter: drop-shadow(0 18px 36px rgba(13, 87, 40, 0.22)); display: block; margin: 0 auto;">
            </div>

            <!-- Right Features Column -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <div style="background: #ffffff; padding: 22px 20px; border-radius: 18px; box-shadow: 0 6px 20px rgba(13, 87, 40, 0.05); border: 1px solid #e8dfd5; display: flex; gap: 16px; align-items: center;">
                    <div style="font-size: 1.6rem; color: #5CB832; background: #e8f5e9; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-wheat-awn"></i></div>
                    <div>
                        <h4 style="font-size: 1.05rem; color: #0D5728; font-weight: 800; margin-bottom: 4px;">35+ Natural Grains</h4>
                        <p style="font-size: 0.84rem; color: #665b53; line-height: 1.45;">Loaded with almonds, walnuts, seeds, millets, and lotus seeds.</p>
                    </div>
                </div>
                <div style="background: #ffffff; padding: 22px 20px; border-radius: 18px; box-shadow: 0 6px 20px rgba(13, 87, 40, 0.05); border: 1px solid #e8dfd5; display: flex; gap: 16px; align-items: center;">
                    <div style="font-size: 1.6rem; color: #5CB832; background: #e8f5e9; width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-cookie"></i></div>
                    <div>
                        <h4 style="font-size: 1.05rem; color: #0D5728; font-weight: 800; margin-bottom: 4px;">Zero Added Sugar</h4>
                        <p style="font-size: 0.84rem; color: #665b53; line-height: 1.45;">Sweetened naturally with Medjool dates and dried figs in pure ghee.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Section: Product Categories Cards -->
<section class="section" style="padding: 60px 0;">
    <div class="container">
        <h2 style="font-size: 2rem; font-family: var(--font-heading); color: #0D5728; margin-bottom: 30px; text-align: center; font-weight: 900;">Product Categories</h2>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
            <!-- Category 1: Health Mixes -->
            <div style="background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 15px rgba(13, 87, 40, 0.05); text-align: center; padding: 24px 20px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center;">
                <div style="width: 100%; height: 160px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <img src="assets/images/products/multigrain-health-mix-400g.png" alt="Health Mixes" style="max-height: 150px; max-width: 100%; width: auto; object-fit: contain; margin: 0 auto; display: block;">
                </div>
                <h4 style="font-size: 1.1rem; color: #0D5728; font-weight: 800; margin-bottom: 6px;">Health Mixes</h4>
                <a href="shop.php?category=health-mixes" style="color: #5CB832; font-weight: 700; font-size: 0.88rem; text-decoration: underline;">Browse Category</a>
            </div>

            <!-- Category 2: Masala Powders -->
            <div style="background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 15px rgba(13, 87, 40, 0.05); text-align: center; padding: 24px 20px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center;">
                <div style="width: 100%; height: 160px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <img src="assets/images/products/sambar-powder.png" alt="Masala Powders" style="max-height: 150px; max-width: 100%; width: auto; object-fit: contain; margin: 0 auto; display: block;">
                </div>
                <h4 style="font-size: 1.1rem; color: #0D5728; font-weight: 800; margin-bottom: 6px;">Masala Powders</h4>
                <a href="shop.php?category=masala-powders" style="color: #5CB832; font-weight: 700; font-size: 0.88rem; text-decoration: underline;">Browse Category</a>
            </div>

            <!-- Category 3: Baby Food -->
            <div style="background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 15px rgba(13, 87, 40, 0.05); text-align: center; padding: 24px 20px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center;">
                <div style="width: 100%; height: 160px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <img src="assets/images/products/baby-ragi-sari.png" alt="Baby Food" style="max-height: 150px; max-width: 100%; width: auto; object-fit: contain; margin: 0 auto; display: block;">
                </div>
                <h4 style="font-size: 1.1rem; color: #0D5728; font-weight: 800; margin-bottom: 6px;">Baby Food</h4>
                <a href="shop.php?category=baby-food" style="color: #5CB832; font-weight: 700; font-size: 0.88rem; text-decoration: underline;">Browse Category</a>
            </div>

            <!-- Category 4: Sweets & Laddus -->
            <div style="background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 15px rgba(13, 87, 40, 0.05); text-align: center; padding: 24px 20px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center;">
                <div style="width: 100%; height: 160px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <img src="assets/images/products/dry-fruits-laddu.jpg" alt="Sweets & Laddus" style="max-height: 150px; max-width: 100%; width: auto; object-fit: contain; margin: 0 auto; display: block;">
                </div>
                <h4 style="font-size: 1.1rem; color: #0D5728; font-weight: 800; margin-bottom: 6px;">Sweets & Laddus</h4>
                <a href="shop.php?category=sweets-laddus" style="color: #5CB832; font-weight: 700; font-size: 0.88rem; text-decoration: underline;">Browse Category</a>
            </div>
        </div>
    </div>
</section>

<!-- 7. Section: Customer Testimonials (Unique Premium Redesign) -->
<section style="background: #faf6f0; padding: 75px 0 85px;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 45px;">
            <span style="color: #5CB832; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1.5px;">CUSTOMER REVIEWS & TESTIMONIALS</span>
            <h2 style="font-size: 2.3rem; font-family: var(--font-heading); color: #0D5728; margin-top: 6px; font-weight: 900;">Loved By Households Across India</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px;">
            <!-- Testimonial 1 -->
            <div class="unique-testimonial-card">
                <div>
                    <!-- Top Row: Avatar & Verified Badge -->
                    <div class="unique-card-top-row">
                        <div class="unique-avatar-circle" style="background: #0D5728;">AR</div>
                        <span class="unique-verified-badge"><i class="fas fa-check-circle"></i> Verified Buyer</span>
                    </div>

                    <!-- Rating Stars -->
                    <div style="color: #5CB832; margin-bottom: 12px; font-size: 0.95rem;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>

                    <!-- Product Mention Pill -->
                    <span class="unique-product-tag-pill">✨ RITHAMAYA 35+ Multigrain Health Mix</span>

                    <!-- Quote Text -->
                    <p class="unique-quote-text">
                        "RM Sampoorna 35+ Multigrain Health Mix and Mutton Sambar Powder are absolute staples in our home now! Authentic homemade flavor with zero preservatives."
                    </p>
                    <span class="unique-watermark-quote">“</span>
                </div>

                <!-- Customer Details -->
                <div style="border-top: 1px dashed #e6dfd5; padding-top: 16px; margin-top: auto;">
                    <h4 style="font-size: 1.05rem; color: #0D5728; font-weight: 800; margin-bottom: 2px;">Anusuya Rao</h4>
                    <span style="font-size: 0.82rem; color: #665b53; font-weight: 600;"><i class="fas fa-location-dot" style="color:#5CB832; margin-right: 4px;"></i> Bengaluru, Karnataka</span>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="unique-testimonial-card">
                <div>
                    <!-- Top Row: Avatar & Verified Badge -->
                    <div class="unique-card-top-row">
                        <div class="unique-avatar-circle" style="background: #5CB832;">PV</div>
                        <span class="unique-verified-badge"><i class="fas fa-check-circle"></i> Verified Buyer</span>
                    </div>

                    <!-- Rating Stars -->
                    <div style="color: #5CB832; margin-bottom: 12px; font-size: 0.95rem;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>

                    <!-- Product Mention Pill -->
                    <span class="unique-product-tag-pill">👶 RITHAMAYA Baby Ragi Sari Powder</span>

                    <!-- Quote Text -->
                    <p class="unique-quote-text">
                        "The Baby Ragi Sari Powder is a life saver! My 9-month-old toddler loves the taste, and I feel relieved knowing it is 100% natural, sprouted, and organic."
                    </p>
                    <span class="unique-watermark-quote">“</span>
                </div>

                <!-- Customer Details -->
                <div style="border-top: 1px dashed #e6dfd5; padding-top: 16px; margin-top: auto;">
                    <h4 style="font-size: 1.05rem; color: #0D5728; font-weight: 800; margin-bottom: 2px;">Priya Venkatesh</h4>
                    <span style="font-size: 0.82rem; color: #665b53; font-weight: 600;"><i class="fas fa-location-dot" style="color:#5CB832; margin-right: 4px;"></i> Mysuru, Karnataka</span>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="unique-testimonial-card">
                <div>
                    <!-- Top Row: Avatar & Verified Badge -->
                    <div class="unique-card-top-row">
                        <div class="unique-avatar-circle" style="background: #0D5728;">RS</div>
                        <span class="unique-verified-badge"><i class="fas fa-check-circle"></i> Verified Buyer</span>
                    </div>

                    <!-- Rating Stars -->
                    <div style="color: #5CB832; margin-bottom: 12px; font-size: 0.95rem;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>

                    <!-- Product Mention Pill -->
                    <span class="unique-product-tag-pill">🍯 Nutritious Dry Fruits Laddu</span>

                    <!-- Quote Text -->
                    <p class="unique-quote-text">
                        "The Dry Fruits Laddu has no added sugar yet tastes incredibly rich with ghee and dates. Perfect healthy snack for our family after evening tea."
                    </p>
                    <span class="unique-watermark-quote">“</span>
                </div>

                <!-- Customer Details -->
                <div style="border-top: 1px dashed #e6dfd5; padding-top: 16px; margin-top: auto;">
                    <h4 style="font-size: 1.05rem; color: #0D5728; font-weight: 800; margin-bottom: 2px;">Rajesh Sharma</h4>
                    <span style="font-size: 0.82rem; color: #665b53; font-weight: 600;"><i class="fas fa-location-dot" style="color:#5CB832; margin-right: 4px;"></i> Hyderabad, Telangana</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 8. Section: Exciting New Organic Food Stories -->
<section class="section" style="padding: 60px 0 70px; background: #fdfbf7;">
    <div class="container">
        <h2 style="font-size: 2.2rem; font-family: var(--font-heading); color: #0D5728; margin-bottom: 36px; text-align: center; font-weight: 900;">Exciting New Organic Food Stories</h2>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
            <!-- Story Card 1 -->
            <div style="background: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.04); border: 1px solid #ededed; display: flex; flex-direction: column; transition: all 0.3s ease;">
                <div style="height: 190px; background: #faf8f5; display: flex; align-items: center; justify-content: center; padding: 16px;">
                    <img src="assets/images/products/multigrain-health-mix.png" alt="Multigrain Benefits" style="max-height: 160px; width: auto; object-fit: contain; filter: drop-shadow(0 6px 14px rgba(0,0,0,0.1));">
                </div>
                <div style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1;">
                    <span style="font-size: 0.78rem; color: #008744; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">HEALTH & WELLNESS</span>
                    <h3 style="font-size: 1.15rem; color: #111111; font-weight: 800; font-family: 'Outfit', sans-serif; line-height: 1.3; margin-bottom: 8px;">Benefits of 35+ Sprouted Multigrains</h3>
                    <p style="font-size: 0.86rem; color: #666666; line-height: 1.5; margin: 0;">How sprouted millets and nuts boost daily stamina and natural immunity for all ages.</p>
                </div>
            </div>

            <!-- Story Card 2 -->
            <div style="background: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.04); border: 1px solid #ededed; display: flex; flex-direction: column; transition: all 0.3s ease;">
                <div style="height: 190px; background: #faf8f5; display: flex; align-items: center; justify-content: center; padding: 16px;">
                    <img src="assets/images/products/sambar-powder.png" alt="Sambar Recipe" style="max-height: 160px; width: auto; object-fit: contain; filter: drop-shadow(0 6px 14px rgba(0,0,0,0.1));">
                </div>
                <div style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1;">
                    <span style="font-size: 0.78rem; color: #008744; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">TRADITIONAL RECIPES</span>
                    <h3 style="font-size: 1.15rem; color: #111111; font-weight: 800; font-family: 'Outfit', sans-serif; line-height: 1.3; margin-bottom: 8px;">Authentic Karnataka Sambar Secret</h3>
                    <p style="font-size: 0.86rem; color: #666666; line-height: 1.5; margin: 0;">Learn how slow roasted spices bring out restaurant style flavor in home cooked sambar.</p>
                </div>
            </div>

            <!-- Story Card 3 -->
            <div style="background: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.04); border: 1px solid #ededed; display: flex; flex-direction: column; transition: all 0.3s ease;">
                <div style="height: 190px; background: #faf8f5; display: flex; align-items: center; justify-content: center; padding: 16px;">
                    <img src="assets/images/products/dry-fruits-laddu.jpg" alt="Sugar Free Sweets" style="max-height: 160px; width: auto; object-fit: contain; border-radius: 12px; filter: drop-shadow(0 6px 14px rgba(0,0,0,0.1));">
                </div>
                <div style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1;">
                    <span style="font-size: 0.78rem; color: #008744; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">NUTRITION TIPS</span>
                    <h3 style="font-size: 1.15rem; color: #111111; font-weight: 800; font-family: 'Outfit', sans-serif; line-height: 1.3; margin-bottom: 8px;">Healthy Sweets Without Sugar</h3>
                    <p style="font-size: 0.86rem; color: #666666; line-height: 1.5; margin: 0;">Why Medjool dates and pure cow ghee make the ultimate guilt-free energy laddu.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 9. Section: Newsletter Signup Banner -->
<section style="background: linear-gradient(135deg, #1b4332, #2d6a4f); padding: 60px 0; color: #fff; text-align: center;">
    <div class="container" style="max-width: 600px;">
        <span style="color: var(--secondary-color); font-weight: 700; font-size: 0.9rem; text-transform: uppercase;">Stay Updated</span>
        <h2 style="font-size: 2rem; color: #fff; font-family: var(--font-heading); margin: 6px 0 16px;">Subscribe For Fresh Offers & Recipes</h2>
        <p style="color: #d8f3dc; font-size: 0.92rem; margin-bottom: 24px;">Join our mailing list to receive organic health tips, special discounts, and traditional recipes.</p>

        <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Thank you for subscribing to RM Sampoorna!');" style="display: flex; gap: 10px; max-width: 480px; margin: 0 auto;">
            <input type="email" placeholder="Enter your email address..." required style="flex: 1; padding: 14px 20px; border-radius: 30px; border: none; font-size: 0.95rem;">
            <button type="submit" class="btn ref-purchase-btn" style="border-radius: 30px !important; padding: 14px 28px !important;">Subscribe</button>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
