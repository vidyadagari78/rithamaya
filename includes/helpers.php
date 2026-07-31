<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

// Asset Cache-Busting Helper for Website Speed
function asset_url($path) {
    $full_path = __DIR__ . '/../' . ltrim($path, '/');
    if (file_exists($full_path)) {
        $mtime = filemtime($full_path);
        return $path . '?v=' . $mtime;
    }
    return $path;
}

// Clear Website Cache Helper
function clear_website_cache() {
    if (function_exists('opcache_reset')) {
        @opcache_reset();
    }
    if (function_exists('gc_collect_cycles')) {
        @gc_collect_cycles();
    }
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sanitize user inputs
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Format Currency
function format_price($price) {
    return '₹' . number_format((float)$price, 2);
}

// Get Cart Item Count
function get_cart_count() {
    $count = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if (is_array($item)) {
                $count += (int)($item['quantity'] ?? 1);
            } elseif (is_numeric($item)) {
                $count += (int)$item;
            }
        }
    }
    return $count;
}

// Get Cart Total Amount
function get_cart_total() {
    $total = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if (is_array($item)) {
                $price = (float)($item['price'] ?? 0);
                $qty = (int)($item['quantity'] ?? 1);
                $total += ($price * $qty);
            } elseif (is_numeric($item)) {
                // Defensive fallback for numeric items
                $prod_id = (int)$key;
                $all_mock = get_mock_products();
                foreach ($all_mock as $m) {
                    if ($m['id'] == $prod_id) {
                        $total += ((float)$m['price'] * (int)$item);
                        break;
                    }
                }
            }
        }
    }
    return $total;
}

// Fallback Mock Data if MySQL DB is not connected yet
function get_mock_products() {
    return [
        [
            'id' => 1,
            'category_id' => 1,
            'category_name' => 'Health Mixes',
            'name' => 'RITHAMAYA 35+ Multi Grain Health Mix Powder',
            'slug' => 'rithamaya-35-multigrain-health-mix-powder',
            'short_description' => '35+ natural grains, millets, nuts, and seeds. Rich in Calcium, Energy Booster & Immunity Support.',
            'description' => 'Rithamaya 35+ Multi Grain Health Mix Powder is 100% natural, crafted with 6 types of millets, finger millet (ragi), jowar, red rice, almonds, walnuts, cashews, raisins, pumpkin seeds, cardamom, and natural herbs. NO Preservatives, NO Added Colours, NO Added Sugar. Rich in Calcium, Energy Booster, and Immunity Support from Soil to Soul.',
            'price' => 299.00,
            'weight' => '400g',
            'badge' => 'Bestseller',
            'stock' => 120,
            'image' => 'assets/images/products/multigrain-health-mix-400g.png',
            'is_featured' => 1,
            'variants' => [
                ['weight' => '400g', 'price' => 299.00, 'image' => 'assets/images/products/multigrain-health-mix-400g.png', 'label' => '400g Standard Pack'],
                ['weight' => '800g', 'price' => 549.00, 'image' => 'assets/images/products/multigrain-health-mix-800g.png', 'label' => '800g Family Pack (Save ₹49)']
            ]
        ],
        [
            'id' => 10,
            'category_id' => 1,
            'category_name' => 'Health Mixes',
            'name' => 'RITHAMAYA 35+ Multi Grain Health Mix Powder (800g Pack)',
            'slug' => 'rithamaya-35-multigrain-health-mix-powder-800g',
            'short_description' => '800g Family Savings Pack. 35+ natural grains, millets, nuts, and seeds.',
            'description' => 'Rithamaya 35+ Multi Grain Health Mix Powder 800g Family Savings Pack is 100% natural, crafted with 6 types of millets, finger millet (ragi), jowar, red rice, almonds, walnuts, cashews, raisins, pumpkin seeds, cardamom, and natural herbs. NO Preservatives, NO Added Colours, NO Added Sugar.',
            'price' => 549.00,
            'weight' => '800g',
            'badge' => 'Family Pack',
            'stock' => 90,
            'image' => 'assets/images/products/multigrain-health-mix-800g.png',
            'is_featured' => 1,
            'variants' => [
                ['weight' => '400g', 'price' => 299.00, 'image' => 'assets/images/products/multigrain-health-mix-400g.png', 'label' => '400g Standard Pack'],
                ['weight' => '800g', 'price' => 549.00, 'image' => 'assets/images/products/multigrain-health-mix-800g.png', 'label' => '800g Family Pack (Save ₹49)']
            ]
        ],
        [
            'id' => 2,
            'category_id' => 3,
            'category_name' => 'Baby Food',
            'name' => 'RITHAMAYA Baby Ragi Sari Powder (6 to 36 Months)',
            'slug' => 'rithamaya-baby-ragi-sari-powder',
            'short_description' => 'Gentle 100% natural sprouted ragi baby cereal for 6 to 36 months. Rich in Calcium & Immunity Support.',
            'description' => 'Rithamaya Baby Ragi Sari Powder is handcrafted specially for infants and toddlers aged 6 Months to 36 Months. Formulated with sprouted Ragi (Finger Millet), Wheat, Red Rice, Almonds, Cashews, Walnuts, Pistachios, Green Gram, Moong Dal, Fenugreek, and Spices. NO Preservatives, NO Added Colours, NO Added Sugar. Rich in Calcium, Energy Booster, and Immunity Support.',
            'price' => 249.00,
            'weight' => '500g',
            'badge' => '6-36 Months',
            'stock' => 85,
            'image' => 'assets/images/products/baby-ragi-sari.png',
            'is_featured' => 1
        ],
        [
            'id' => 3,
            'category_id' => 2,
            'category_name' => 'Masala Powders',
            'name' => 'Bisibele Bath Powder',
            'slug' => 'bisibele-bath-powder',
            'short_description' => 'Authentic aroma & flavor for traditional Karnataka-style Bisibele Bath.',
            'description' => 'Made from roasted coriander, chana dal, urad dal, dried red chillies, cinnamon, cloves, and kapok buds. Delivers restaurant-style authentic taste to your homemade rice dishes.',
            'price' => 140.00,
            'weight' => '250g',
            'badge' => 'Traditional',
            'stock' => 95,
            'image' => 'assets/images/products/bisibele-bath-powder.png',
            'is_featured' => 1
        ],
        [
            'id' => 4,
            'category_id' => 2,
            'category_name' => 'Masala Powders',
            'name' => 'Dhaniya Powder (Coriander Powder)',
            'slug' => 'dhaniya-powder',
            'short_description' => 'Freshly ground premium coriander seeds with intense natural fragrance.',
            'description' => '100% pure sun-dried coriander seeds slow-ground to preserve volatile essential oils. Elevates every curry, gravy, and dal with fresh aromatic warmth.',
            'price' => 95.00,
            'weight' => '250g',
            'badge' => 'Pure',
            'stock' => 150,
            'image' => 'assets/images/products/dhaniya-powder.png',
            'is_featured' => 0
        ],
        [
            'id' => 5,
            'category_id' => 2,
            'category_name' => 'Masala Powders',
            'name' => 'Red Chilli Powder',
            'slug' => 'red-chilli-powder',
            'short_description' => 'Rich vibrant red color with mild authentic heat from select chillies.',
            'description' => 'Blended from handpicked Byadgi and Guntur chillies giving vibrant red color without synthetic colors or chemicals.',
            'price' => 120.00,
            'weight' => '250g',
            'badge' => 'Spicy',
            'stock' => 110,
            'image' => 'assets/images/products/red-chilli-powder.png',
            'is_featured' => 0
        ],
        [
            'id' => 6,
            'category_id' => 2,
            'category_name' => 'Masala Powders',
            'name' => 'Authentic Sambar Powder',
            'slug' => 'sambar-powder',
            'short_description' => 'Classic South Indian aromatic spice mix for comforting homemade sambar.',
            'description' => 'A balanced blend of roasted spices, roasted lentils, fenugreek, cumin, and asafoetida. Perfect for daily vegetable sambars.',
            'price' => 130.00,
            'weight' => '250g',
            'badge' => 'Karnataka Special',
            'stock' => 140,
            'image' => 'assets/images/products/sambar-powder.png',
            'is_featured' => 1
        ],
        [
            'id' => 7,
            'category_id' => 2,
            'category_name' => 'Masala Powders',
            'name' => 'Mutton Sambar Powder',
            'slug' => 'mutton-sambar-powder',
            'short_description' => 'Special secret blend for rich, spicy non-vegetarian sambars & gravies.',
            'description' => 'Traditional homemade Mutton Sambar Powder expertly blended with exotic spices to bring out the authentic taste of Karnataka non-veg cuisine.',
            'price' => 160.00,
            'weight' => '250g',
            'badge' => 'Authentic',
            'stock' => 75,
            'image' => 'assets/images/products/mutton-sambar-powder.png',
            'is_featured' => 1
        ],
        [
            'id' => 8,
            'category_id' => 2,
            'category_name' => 'Masala Powders',
            'name' => 'Homemade Puliyogare Powder',
            'slug' => 'puliyogare-powder',
            'short_description' => 'Tangy tamarind rice masala powder prepared from heritage family recipe.',
            'description' => 'Prepared with dry roasted sesame seeds, black pepper, peanuts, coriander, mustard, and tamarind spice blend for instant authentic tamarind rice.',
            'price' => 145.00,
            'weight' => '250g',
            'badge' => 'Heritage Recipe',
            'stock' => 90,
            'image' => 'assets/images/products/puliyogare-powder.png',
            'is_featured' => 0
        ],
        [
            'id' => 9,
            'category_id' => 4,
            'category_name' => 'Sweets & Laddus',
            'name' => 'Nutritious Dry Fruits Laddu',
            'slug' => 'dry-fruits-laddu',
            'short_description' => 'No added sugar laddu packed with dates, figs, almonds, cashews & ghee.',
            'description' => 'Healthy guilt-free dessert crafted with premium Medjool dates, dried figs, roasted almonds, pistachios, cashews, seeds, and pure desi cow ghee.',
            'price' => 420.00,
            'weight' => '400g',
            'badge' => 'Sugar-Free',
            'stock' => 60,
            'image' => 'assets/images/products/dry-fruits-laddu.jpg',
            'is_featured' => 1
        ],
        [
            'id' => 10,
            'category_id' => 1,
            'category_name' => 'Health Mixes',
            'name' => 'Korle Millet Powder',
            'slug' => 'korle-millet-powder',
            'short_description' => 'Pure organic blend of Browntop (Korle) millet, pumpkin seeds & brown rice.',
            'description' => 'High-fiber diabetic-friendly millet powder rich in minerals and slow-releasing complex carbohydrates. Great for kanji, porridge, or roti flour mix.',
            'price' => 280.00,
            'weight' => '500g',
            'badge' => 'Superfood',
            'stock' => 80,
            'image' => 'assets/images/products/korle-millet-powder.png',
            'is_featured' => 0
        ]
    ];
}
?>
