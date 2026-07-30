<?php
require_once __DIR__ . '/includes/header.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 2; // Default to Baby Ragi Sari Powder if invalid
$product = null;

if ($GLOBALS['db_connected']) {
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
    } catch (Exception $e) {
        $product = null;
    }
}

if (!$product) {
    $all_mock = get_mock_products();
    foreach ($all_mock as $m) {
        if ($m['id'] == $product_id) {
            $product = $m;
            break;
        }
    }
    if (!$product) {
        $product = $all_mock[1]; // Default to Baby Ragi Sari Powder mock item
    }
}

// Fetch 4 related products
$related_products = [];
if ($GLOBALS['db_connected']) {
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id != ? ORDER BY RAND() LIMIT 4");
        $stmt->execute([$product_id]);
        $related_products = $stmt->fetchAll();
    } catch (Exception $e) {
        $related_products = [];
    }
}

if (empty($related_products)) {
    $all_mock = get_mock_products();
    $related_products = array_filter($all_mock, function($item) use ($product_id) {
        return $item['id'] != $product_id;
    });
    $related_products = array_slice(array_values($related_products), 0, 4);
}
?>

<div class="product-page-wrapper">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="product-breadcrumb">
            <a href="index.php">Home</a> / <a href="shop.php">Shop</a> / <span class="active-crumb"><?= sanitize($product['name']) ?></span>
        </nav>

        <!-- Product Main Detail Card -->
        <div class="product-detail-card">
            <!-- Left Column: Product Image Stage -->
            <div class="product-detail-img-stage">
                <img src="<?= sanitize($product['image']) ?>" alt="<?= sanitize($product['name']) ?>" class="product-detail-img">
            </div>

            <!-- Right Column: Product Info & Actions -->
            <div class="product-detail-info">
                <!-- Top Badge & Subcategory -->
                <div class="product-detail-badge-row">
                    <span class="detail-cat-badge"><?= strtoupper(sanitize($product['badge'] ?? 'ORGANIC')) ?></span>
                </div>
                
                <div class="product-detail-category">
                    <?= strtoupper(sanitize($product['category_name'] ?? 'BABY & INFANT FOOD')) ?>
                </div>

                <h1 class="product-detail-title"><?= sanitize($product['name']) ?></h1>

                <!-- Price Row -->
                <div class="product-detail-price-row">
                    <span class="detail-main-price"><?= format_price($product['price']) ?></span>
                    <span class="detail-tax-note">(Inclusive of all taxes)</span>
                </div>

                <!-- Description -->
                <p class="product-detail-desc">
                    <?= sanitize($product['description']) ?>
                </p>

                <!-- Highlights Box -->
                <div class="product-highlights-box">
                    <p><strong>Net Weight:</strong> <?= sanitize($product['weight']) ?></p>
                    <p><strong>Availability:</strong> <span class="stock-status-in">In Stock (<?= $product['stock'] ?> units)</span></p>
                    <p><strong>Formulation:</strong> 100% Natural, No Added Colors or Preservatives</p>
                </div>

                <!-- Add to Cart Form -->
                <form action="cart.php" method="POST" class="product-detail-cart-form">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="detail-qty-control">
                        <button type="button" class="detail-qty-btn" onclick="updateQty(this, -1)">-</button>
                        <input type="number" name="quantity" value="1" min="1" class="qty-input detail-qty-val">
                        <button type="button" class="detail-qty-btn" onclick="updateQty(this, 1)">+</button>
                    </div>

                    <button type="submit" class="btn-dark-green-cart">
                        <i class="fas fa-shopping-basket" style="margin-right: 6px;"></i> Add to Cart
                    </button>
                </form>

                <!-- Guarantees Row -->
                <div class="product-guarantees-row">
                    <div class="guarantee-item">
                        <i class="fas fa-shield-halved"></i> 100% Quality Guaranteed
                    </div>
                    <div class="guarantee-item">
                        <i class="fas fa-leaf"></i> Organic Farm Ingredients
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <div class="related-products-section">
            <div class="related-header">
                <h2>Related Products</h2>
                <p>Fresh products you might also need</p>
            </div>

            <div class="product-grid">
                <?php foreach ($related_products as $rel): ?>
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <?php if (!empty($rel['badge'])): ?>
                                <span class="product-corner-badge">
                                    <?= strtoupper(sanitize($rel['badge'])) ?>
                                </span>
                            <?php endif; ?>
                            <a href="product.php?id=<?= $rel['id'] ?>" class="product-img-link">
                                <img src="<?= sanitize($rel['image']) ?>" alt="<?= sanitize($rel['name']) ?>" class="product-img">
                            </a>
                        </div>

                        <div class="product-details">
                            <div class="ref-title-rating-row">
                                <h3 class="product-title">
                                    <a href="product.php?id=<?= $rel['id'] ?>"><?= sanitize($rel['name']) ?></a>
                                </h3>
                                <span class="ref-star-rating"><i class="fas fa-star" style="color:#d48800;"></i> 4.5</span>
                            </div>

                            <div class="ref-category-sub"><?= sanitize($rel['category_name'] ?? 'RM SAMPOORNA') ?></div>

                            <div class="ref-price-discount-row">
                                <span class="ref-main-price"><?= format_price($rel['price']) ?></span>
                                <span class="ref-unit-text">/ pack</span>
                                <span class="ref-original-price"><s><?= format_price($rel['price'] * 1.15) ?></s></span>
                            </div>

                            <div class="ref-pack-info">Pack Weight: <?= sanitize($rel['weight']) ?></div>

                            <form action="cart.php" method="POST" style="margin-top: auto;">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="product_id" value="<?= $rel['id'] ?>">

                                <div class="ref-qty-pill">
                                    <button type="button" class="ref-qty-btn" onclick="updateQty(this, -1)">-</button>
                                    <input type="number" name="quantity" value="1" min="1" class="qty-input ref-qty-val" style="width: 40px; text-align: center; border: none; background: transparent; font-weight: 800; font-size: 0.95rem; color: #000;">
                                    <button type="button" class="ref-qty-btn" onclick="updateQty(this, 1)">+</button>
                                </div>

                                <div class="ref-actions-row">
                                    <button type="submit" class="ref-cart-green-btn">
                                        <i class="fas fa-shopping-cart" style="margin-right: 4px;"></i> Add to Cart
                                    </button>
                                     <a href="product.php?id=<?= $rel['id'] ?>" class="ref-bulk-inquiry-btn">
                                         <i class="fas fa-eye" style="margin-right: 4px;"></i> View Details
                                     </a>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
