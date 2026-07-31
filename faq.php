<?php
require_once __DIR__ . '/includes/header.php';
?>

<!-- FAQ Page Hero Banner (With Rich Background Image & Badges) -->
<div class="shop-hero-banner" style="background: linear-gradient(rgba(14, 35, 26, 0.78), rgba(14, 35, 26, 0.85)), url('assets/images/shop_banner_bg.png') center/cover no-repeat; padding: 50px 0; margin-bottom: 40px;">
    <div class="container shop-banner-content" style="text-align: center; color: #fff;">
        <span style="color: #5CB832; font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 6px;">HELP & KNOWLEDGE BASE</span>
        <h1 class="shop-banner-title" style="font-size: 2.6rem; font-weight: 900; color: #fff; margin-bottom: 8px;">Frequently Asked Questions</h1>
        <p class="shop-banner-subtitle" style="color: #d8f3dc; font-size: 1.05rem; max-width: 650px; margin: 0 auto 24px;">Everything you need to know about RM's Sampoorna organic health mixes, traditional masalas, and shipping.</p>
        
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

<div class="container" style="margin-bottom: 80px;">
    <!-- FAQ Search Bar -->
    <div style="background: #ffffff; padding: 24px; border-radius: 20px; box-shadow: 0 6px 25px rgba(13, 87, 40, 0.06); border: 1px solid #e0e9e3; margin-bottom: 40px; text-align: center;">
        <h3 style="color: #0D5728; font-weight: 800; font-size: 1.3rem; margin-bottom: 12px;">Have Questions? We Have Answers.</h3>
        <p style="color: #555555; font-size: 0.92rem; margin-bottom: 18px;">Search below or browse through our most popular topics.</p>
        <div style="display: flex; gap: 10px; max-width: 550px; margin: 0 auto;">
            <input type="text" id="faqSearchInput" onkeyup="filterFaqs()" placeholder="Type a keyword e.g. Ragi, Shipping, Shelf Life..." style="flex: 1; padding: 12px 18px; border: 2px solid #c8e6c9; border-radius: 30px; outline: none; font-size: 0.95rem;">
        </div>
    </div>

    <!-- Category 1: Products & Ingredients -->
    <div class="faq-category-block" style="margin-bottom: 35px;">
        <h3 style="color: #0D5728; font-size: 1.4rem; font-weight: 900; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-seedling" style="color: #5CB832;"></i> 1. Products & Organic Quality
        </h3>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>What makes RM's Sampoorna 35+ Multigrain Health Mix unique?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>Our 35+ Multigrain Health Mix is prepared using traditional sun-dried millets, sprouted ragi, almonds, walnuts, lotus seeds (makhana), cardamom, and ancient grains. We slow-roast each ingredient in small batches to preserve essential oils and natural digestive enzymes, without any artificial preservatives or added sugars.</p>
            </div>
        </div>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>Is Baby Ragi Sari safe for 6-month-old infants?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>Yes! Our Baby Ragi Sari is 100% natural, prepared from sprouted organic ragi grains that are dried under gentle sunlight and finely ground. Sprouting increases bioavailable iron and calcium, making it soft on baby digestive systems. Always consult your pediatrician for infant weaning guidance.</p>
            </div>
        </div>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>Do your masala powders contain artificial colors or preservatives?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>Never! All our spice blends—including Sambar Powder, Bisibele Bath Powder, Rasam Powder, and Puliyogare Powder—are made with 100% pure sun-dried spices and cold-roasted without synthetic colors, anti-caking agents, or MSG.</p>
            </div>
        </div>
    </div>

    <!-- Category 2: Storage & Shelf Life -->
    <div class="faq-category-block" style="margin-bottom: 35px;">
        <h3 style="color: #0D5728; font-size: 1.4rem; font-weight: 900; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-clock" style="color: #5CB832;"></i> 2. Storage & Shelf Life
        </h3>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>What is the shelf life of Rithamaya products?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>Our Health Mixes and Masala Powders have a recommended shelf life of 6 to 9 months when stored in an airtight container away from direct sunlight. Homemade Laddus and sweets are best enjoyed within 45 to 60 days of delivery.</p>
            </div>
        </div>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>How should I store the health mix after opening?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>Transfer the powder into a dry, clean stainless steel or glass airtight container. Always use a clean dry spoon to prevent moisture contamination.</p>
            </div>
        </div>
    </div>

    <!-- Category 3: Orders, Shipping & Payments -->
    <div class="faq-category-block" style="margin-bottom: 35px;">
        <h3 style="color: #0D5728; font-size: 1.4rem; font-weight: 900; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-truck" style="color: #5CB832;"></i> 3. Shipping, Tracking & Payments
        </h3>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>How long does delivery take across India?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>Orders within Karnataka (Bengaluru, Mysore, Mangaluru) are delivered within 24 to 48 hours. Orders across southern and western India take 2 to 4 business days. Pan-India deliveries take 3 to 6 business days.</p>
            </div>
        </div>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>How can I track my live order status?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>Log in to your <a href="account.php" style="color: #0D5728; font-weight: 700; text-decoration: underline;">My Account Dashboard</a> and click "Track Order" on any order card. You will see a real-time 4-step progress stepper (Placed ➔ Processing ➔ Shipped ➔ Delivered).</p>
            </div>
        </div>

        <div class="faq-accordion-item">
            <button class="faq-accordion-btn" onclick="toggleFaq(this)">
                <span>What payment options are accepted?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </button>
            <div class="faq-accordion-content">
                <p>We accept Cash on Delivery (COD), UPI (GPay, PhonePe, Paytm), Net Banking, and major Debit/Credit Cards.</p>
            </div>
        </div>
    </div>

    <!-- Contact Support Box -->
    <div style="background: linear-gradient(135deg, #0D5728, #1b6b35); color: #ffffff; padding: 30px; border-radius: 20px; text-align: center; margin-top: 40px; box-shadow: 0 10px 30px rgba(13, 87, 40, 0.2);">
        <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 8px; color: #fff;">Still Have Questions?</h3>
        <p style="color: #d8f3dc; font-size: 0.95rem; margin-bottom: 20px;">Our customer support team is happy to help you with product recommendations or custom bulk orders.</p>
        <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
            <a href="contact.php" class="btn" style="background: #5CB832; color: #ffffff; font-weight: 800; padding: 12px 24px; border-radius: 30px;"><i class="fas fa-envelope"></i> Contact Support</a>
            <a href="https://wa.me/919876543210" target="_blank" class="btn" style="background: #ffffff; color: #0D5728; font-weight: 800; padding: 12px 24px; border-radius: 30px;"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
        </div>
    </div>
</div>

<style>
.faq-accordion-item {
    background: #ffffff;
    border-radius: 14px;
    margin-bottom: 12px;
    border: 1px solid #e0e9e3;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(13, 87, 40, 0.03);
    transition: all 0.25s ease;
}
.faq-accordion-item:hover {
    border-color: #5CB832;
}
.faq-accordion-btn {
    width: 100%;
    background: none;
    border: none;
    padding: 18px 22px;
    text-align: left;
    font-size: 1.05rem;
    font-weight: 800;
    color: #0D5728;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    font-family: 'Outfit', sans-serif;
}
.faq-accordion-btn .faq-icon {
    color: #5CB832;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}
.faq-accordion-item.active .faq-icon {
    transform: rotate(180deg);
}
.faq-accordion-content {
    display: none;
    padding: 0 22px 20px;
    color: #444444;
    font-size: 0.92rem;
    line-height: 1.65;
    border-top: 1px dashed #e0e9e3;
}
.faq-accordion-item.active .faq-accordion-content {
    display: block;
    background: #fafcfb;
}
</style>

<script>
function toggleFaq(btn) {
    const item = btn.parentElement;
    item.classList.toggle('active');
}

function filterFaqs() {
    const input = document.getElementById('faqSearchInput').value.toLowerCase();
    const items = document.querySelectorAll('.faq-accordion-item');
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(input)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
