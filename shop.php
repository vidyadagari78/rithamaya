<?php
require_once __DIR__ . '/includes/header.php';

$search_query = isset($_GET['q']) ? sanitize($_GET['q']) : '';
$selected_category = isset($_GET['category']) ? sanitize($_GET['category']) : 'all';

$products = [];
if ($GLOBALS['db_connected']) {
    try {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";
        $params = [];

        if (!empty($search_query)) {
            $sql .= " AND (p.name LIKE ? OR p.short_description LIKE ?)";
            $params[] = "%$search_query%";
            $params[] = "%$search_query%";
        }

        if ($selected_category !== 'all') {
            $sql .= " AND c.slug = ?";
            $params[] = $selected_category;
        }

        $sql .= " ORDER BY p.updated_at DESC, p.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();
    } catch (Exception $e) {
        $products = [];
    }
}

if (empty($products)) {
    $products = get_mock_products();
    if (!empty($search_query)) {
        $products = array_filter($products, function($item) use ($search_query) {
            return stripos($item['name'], $search_query) !== false || stripos($item['short_description'], $search_query) !== false;
        });
    }
    if ($selected_category !== 'all') {
        $products = array_filter($products, function($item) use ($selected_category) {
            return strtolower(str_replace([' & ', ' '], '-', $item['category_name'])) === $selected_category;
        });
    }
}
?>

<!-- Shop Page Hero Banner (Signature Theme Banner) -->
<div class="page-banner">
    <div class="container">
        <span style="color: var(--secondary-color); font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1.5px;">ORGANIC STORE CATALOG</span>
        <h1 style="font-size: 2.5rem; font-weight: 900; margin-top: 6px;">RM's Sampoorna Products</h1>
        <p>Browse our complete catalog of 100% organic masalas, health mix powders, and traditional foods.</p>
    </div>
</div>

<!-- Category Tabs Filter Bar -->
<div class="shop-filter-bar">
    <div class="container">
        <div class="filter-categories-pills">
            <a href="shop.php" class="cat-pill <?= $selected_category == 'all' ? 'active' : '' ?>" data-category="all">
                All Products
            </a>
            <a href="shop.php?category=health-mixes" class="cat-pill <?= $selected_category == 'health-mixes' ? 'active' : '' ?>" data-category="health-mixes">
                🌾 Health Mixes
            </a>
            <a href="shop.php?category=masala-powders" class="cat-pill <?= $selected_category == 'masala-powders' ? 'active' : '' ?>" data-category="masala-powders">
                🌶️ Masala Powders
            </a>
            <a href="shop.php?category=baby-food" class="cat-pill <?= $selected_category == 'baby-food' ? 'active' : '' ?>" data-category="baby-food">
                👶 Baby Food
            </a>
            <a href="shop.php?category=sweets-laddus" class="cat-pill <?= $selected_category == 'sweets-laddus' ? 'active' : '' ?>" data-category="sweets-laddus">
                🍯 Sweets & Laddus
            </a>
        </div>
    </div>
</div>

<div class="container shop-grid-container">
    <?php if (!empty($search_query)): ?>
        <div style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 24px; padding-top: 10px;">
            Showing results for: <strong>"<?= $search_query ?>"</strong> (<a href="shop.php" style="color: var(--primary-hover); text-decoration: underline;">Clear Search</a>)
        </div>
    <?php endif; ?>

    <!-- Product Grid -->
    <?php if (count($products) > 0): ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
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
    <?php else: ?>
        <div style="text-align: center; padding: 70px 20px; background: #fff; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); margin: 40px 0;">
            <i class="fas fa-box-open" style="font-size: 3.5rem; color: var(--secondary-color); margin-bottom: 18px;"></i>
            <h2 style="font-size: 1.8rem; margin-bottom: 8px;">No Products Found</h2>
            <p style="color: var(--text-muted); margin-bottom: 24px;">We couldn't find any products matching your criteria.</p>
            <a href="shop.php" class="btn btn-primary">Browse All Products</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
