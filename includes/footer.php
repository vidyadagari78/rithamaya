    <!-- Main Site Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Col 1: Brand Info -->
                <div class="footer-col">
                    <img src="assets/images/logo.png" alt="Rithamaya Logo" style="height: 54px; width: auto; background: #ffffff; padding: 6px 14px; border-radius: 8px; margin-bottom: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                    <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; color: #b7e4c7;">
                        Dedicated to bringing pure, traditional, and 100% organic homemade nutrition to every household. Handcrafted with love and authentic ingredients.
                    </p>
                    <div style="display:flex; gap:12px;">
                        <a href="#" style="color:#fff; background:rgba(255,255,255,0.1); width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" style="color:#fff; background:rgba(255,255,255,0.1); width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;"><i class="fab fa-instagram"></i></a>
                        <a href="#" style="color:#fff; background:rgba(255,255,255,0.1); width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="shop.php">Shop Products</a></li>
                        <li><a href="about.php">About RM Sampoorna</a></li>
                        <li><a href="faq.php">Frequently Asked Questions (FAQ)</a></li>
                        <li><a href="terms.php">Terms & Conditions</a></li>
                        <li><a href="contact.php">Contact & Support</a></li>
                        <li><a href="clear_cache.php" style="color: #5CB832;" title="Clear website cache & reload latest assets"><i class="fas fa-sync-alt"></i> Clear Website Cache</a></li>
                    </ul>
                </div>

                <!-- Col 3: Popular Categories -->
                <div class="footer-col">
                    <h4>Product Range</h4>
                    <ul class="footer-links">
                        <li><a href="shop.php?category=health-mixes">35+ Multigrain Mix</a></li>
                        <li><a href="shop.php?category=baby-food">Baby Ragi Sari</a></li>
                        <li><a href="shop.php?category=masala-powders">Bisibele Bath Powder</a></li>
                        <li><a href="shop.php?category=masala-powders">Karnataka Sambar Powder</a></li>
                        <li><a href="shop.php?category=sweets-laddus">Dry Fruits Laddu</a></li>
                    </ul>
                </div>

                <!-- Col 4: Store Contact -->
                <div class="footer-col">
                    <h4>Get In Touch</h4>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt" style="margin-right:8px; color:var(--secondary-color);"></i> Bengaluru, Karnataka, India</li>
                        <li><i class="fas fa-phone-alt" style="margin-right:8px; color:var(--secondary-color);"></i> +91 98765 43210</li>
                        <li><i class="fas fa-envelope" style="margin-right:8px; color:var(--secondary-color);"></i> support@rithamaya.com</li>
                        <li><i class="fas fa-clock" style="margin-right:8px; color:var(--secondary-color);"></i> Mon - Sat: 9:00 AM - 7:00 PM</li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> RM's Sampoorna Food Products (Rithamaya). All Rights Reserved. Built with PHP & MySQL.</p>
            </div>
        </div>
    </footer>

    <!-- Promotional Offer Modal Popup (Reference Match) -->
    <div id="promoModal" class="promo-modal-overlay">
        <div class="promo-modal-container">
            <button type="button" class="promo-modal-close" onclick="closePromoModal()">&times;</button>
            
            <div class="promo-banner-content">
                <!-- Header Logo & Tagline -->
                <div class="promo-header">
                    <img src="assets/images/logo.png" alt="Rithamaya Logo" class="promo-logo">
                    <div class="promo-subtag">TRADITION • TRUST • TASTE</div>
                </div>

                <!-- Discount Headline & Coupon -->
                <div class="promo-badge-ribbon">
                    <h2>Get FLAT <span>10% OFF</span></h2>
                    <p>On Your First Purchase!</p>
                    <div class="promo-code-box">Use Code: <strong>WELCOME10</strong></div>
                </div>

                <!-- Real Product Showcase Images -->
                <div class="promo-products-row">
                    <img src="assets/images/products/dry-fruits-laddu.jpg" alt="Dry Fruits Laddu" class="promo-pouch-img">
                    <img src="assets/images/products/multigrain-health-mix.png" alt="Multigrain Mix" class="promo-pouch-img main-pouch">
                    <img src="assets/images/products/sambar-powder.png" alt="Sambar Powder" class="promo-pouch-img">
                </div>

                <!-- Feature Pills -->
                <div class="promo-features-grid">
                    <span>🍯 Made with <strong>Pure Ghee</strong></span>
                    <span>🌿 <strong>100% Natural</strong> Ingredients</span>
                    <span>❤️ Handcrafted <strong>with Love</strong></span>
                </div>

                <div class="promo-tagline">
                    Taste the Heritage of Authentic Karnataka Sweets & Spices!
                </div>

                <!-- Shop Now Action Button -->
                <a href="shop.php" class="btn promo-shop-btn">
                    SHOP NOW <i class="fas fa-shopping-cart" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main JavaScript File -->
    <script src="assets/js/main.js"></script>
</body>
</html>
