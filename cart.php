<?php
require_once __DIR__ . '/includes/header.php';

// Auto-normalize session cart format to prevent type array offset warnings
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $clean_cart = [];
    $all_mock = get_mock_products();
    foreach ($_SESSION['cart'] as $k => $v) {
        if (is_array($v) && isset($v['id'], $v['name'], $v['price'])) {
            $clean_cart[$v['id']] = $v;
        } elseif (is_numeric($v) || is_numeric($k)) {
            $pid = is_numeric($k) && $k > 0 ? (int)$k : (int)$v;
            $q = is_numeric($v) && $v > 0 ? (int)$v : 1;
            $found_prod = null;
            if ($GLOBALS['db_connected']) {
                try {
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute([$pid]);
                    $found_prod = $stmt->fetch();
                } catch (Exception $e) {
                    $found_prod = null;
                }
            }
            if (!$found_prod) {
                foreach ($all_mock as $m) {
                    if ($m['id'] == $pid) {
                        $found_prod = $m;
                        break;
                    }
                }
            }
            if ($found_prod) {
                $clean_cart[$found_prod['id']] = [
                    'id' => $found_prod['id'],
                    'name' => $found_prod['name'],
                    'price' => $found_prod['price'],
                    'weight' => $found_prod['weight'] ?? '500g',
                    'image' => $found_prod['image'],
                    'quantity' => $q
                ];
            }
        }
    }
    $_SESSION['cart'] = $clean_cart;
}

// Handle Cart Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitize($_POST['action']) : '';
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Fetch product details
    $target_product = null;
    if ($GLOBALS['db_connected']) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $target_product = $stmt->fetch();
        } catch (Exception $e) {
            $target_product = null;
        }
    }

    if (!$target_product) {
        $all_mock = get_mock_products();
        foreach ($all_mock as $m) {
            if ($m['id'] == $product_id) {
                $target_product = $m;
                break;
            }
        }
    }

    if ($action === 'add' && $target_product) {
        if (isset($_SESSION['cart'][$product_id]) && is_array($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $target_product['id'],
                'name' => $target_product['name'],
                'price' => $target_product['price'],
                'weight' => $target_product['weight'] ?? '500g',
                'image' => $target_product['image'],
                'quantity' => $quantity
            ];
        }
        $_SESSION['success_msg'] = "Added <strong>" . sanitize($target_product['name']) . "</strong> to your cart.";
    } elseif ($action === 'update') {
        if (isset($_SESSION['cart'][$product_id])) {
            if ($quantity > 0) {
                if (is_array($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = [
                        'id' => $product_id,
                        'quantity' => $quantity
                    ];
                }
                $_SESSION['success_msg'] = "Cart updated successfully.";
            } else {
                unset($_SESSION['cart'][$product_id]);
                $_SESSION['success_msg'] = "Item removed from cart.";
            }
        }
    } elseif ($action === 'remove') {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['success_msg'] = "Item removed from cart.";
        }
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
        $_SESSION['success_msg'] = "Cart cleared.";
    }

    header("Location: cart.php");
    exit;
}

$cart_items = $_SESSION['cart'] ?? [];
$subtotal = get_cart_total();
$shipping = $subtotal > 499 || $subtotal == 0 ? 0.00 : 50.00;
$grand_total = $subtotal + $shipping;
$free_shipping_thresh = 500;
$free_shipping_pct = min(100, ($subtotal / $free_shipping_thresh) * 100);
?>

<!-- Page Header Banner -->
<div style="background: linear-gradient(135deg, #1b4332, #2d6a4f); color: #fff; padding: 45px 0 40px; margin-bottom: 40px;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <span style="font-size: 0.85rem; color: var(--secondary-color); text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Home / Shopping Cart</span>
                <h1 style="color: #fff; font-size: 2.4rem; margin-top: 4px; font-family: var(--font-heading);">Your Shopping Cart</h1>
            </div>
            
            <!-- Checkout Progress Stepper -->
            <div style="display: flex; align-items: center; gap: 15px; font-size: 0.9rem;">
                <div style="background: var(--secondary-color); color: #1b4332; padding: 8px 16px; border-radius: 20px; font-weight: 700;">1. Cart Review</div>
                <div style="color: rgba(255,255,255,0.4);"><i class="fas fa-chevron-right"></i></div>
                <div style="color: rgba(255,255,255,0.6);">2. Shipping Details</div>
                <div style="color: rgba(255,255,255,0.4);"><i class="fas fa-chevron-right"></i></div>
                <div style="color: rgba(255,255,255,0.6);">3. Payment</div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    <?php if (count($cart_items) > 0): ?>
        
        <!-- Free Shipping Progress Bar Banner -->
        <div style="background: #e8f5e9; border: 1px solid #c8e6c9; padding: 18px 24px; border-radius: 16px; margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 0.95rem; color: #1b4332; font-weight: 600;">
                    <?php if ($subtotal >= $free_shipping_thresh): ?>
                        🎉 <strong>Congratulations!</strong> You qualify for <strong>FREE Pan-India Shipping</strong>!
                    <?php else: ?>
                        🚚 Add <strong><?= format_price($free_shipping_thresh - $subtotal) ?></strong> more to unlock <strong>FREE Shipping</strong>!
                    <?php endif; ?>
                </span>
                <span style="font-size: 0.85rem; color: #2e7d32; font-weight: 700;"><?= round($free_shipping_pct) ?>%</span>
            </div>
            <div style="width: 100%; height: 8px; background: #c8e6c9; border-radius: 10px; overflow: hidden;">
                <div style="width: <?= $free_shipping_pct ?>%; height: 100%; background: #008744; border-radius: 10px; transition: width 0.4s ease;"></div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 35px; align-items: start;">
            <!-- Left Side: Cart Product Item Cards -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 1.3rem; color: #1b4332;">Cart Items (<?= count($cart_items) ?>)</h3>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" style="background: none; border: none; color: #e76f51; cursor: pointer; font-size: 0.88rem; font-weight: 600; text-decoration: underline;">
                            <i class="fas fa-trash-alt" style="margin-right: 4px;"></i> Clear All Items
                        </button>
                    </form>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <?php foreach ($cart_items as $item): 
                        if (!is_array($item)) continue;
                        $item_total = (float)($item['price'] ?? 0) * (int)($item['quantity'] ?? 1);
                    ?>
                        <div style="background: #fff; border-radius: 18px; padding: 20px; display: flex; align-items: center; justify-content: space-between; gap: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid var(--border-color);">
                            
                            <!-- Product Image & Details -->
                            <div style="display: flex; align-items: center; gap: 18px; flex: 1.2;">
                                <div style="width: 80px; height: 80px; background: #fdfbf7; border-radius: 14px; padding: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(0,0,0,0.05);">
                                    <img src="<?= sanitize($item['image'] ?? '') ?>" alt="<?= sanitize($item['name'] ?? 'Product') ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                                <div>
                                    <span style="font-size: 0.72rem; color: #008744; font-weight: 700; text-transform: uppercase;">100% Organic</span>
                                    <h4 style="font-size: 1.05rem; color: #1b4332; margin: 2px 0 4px;">
                                        <a href="product.php?id=<?= $item['id'] ?>"><?= sanitize($item['name'] ?? 'Product') ?></a>
                                    </h4>
                                    <div style="font-size: 0.82rem; color: var(--text-muted);"><i class="fas fa-weight-hanging"></i> <?= sanitize($item['weight'] ?? '500g') ?> | <?= format_price($item['price'] ?? 0) ?> each</div>
                                </div>
                            </div>

                            <!-- Qty Control -->
                            <div style="flex: 0.8; text-align: center;">
                                <form action="cart.php" method="POST" style="display: inline-block;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <div class="qty-control" style="background: #f8f9fa; border-radius: 20px; padding: 2px 8px;">
                                        <button type="button" class="qty-btn" onclick="updateQty(this, -1); this.form.submit();">-</button>
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?? 1 ?>" min="1" class="qty-input" onchange="this.form.submit()" style="font-weight: 700;">
                                        <button type="button" class="qty-btn" onclick="updateQty(this, 1); this.form.submit();">+</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Item Total & Delete Action -->
                            <div style="display: flex; align-items: center; gap: 20px;">
                                <div style="font-size: 1.15rem; font-weight: 800; color: #008744; min-width: 90px; text-align: right;">
                                    <?= format_price($item_total) ?>
                                </div>

                                <form action="cart.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <button type="submit" style="background: #fff0f0; border: none; color: #e76f51; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: var(--transition);" title="Remove Item">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top: 28px; display: flex; justify-content: space-between;">
                    <a href="shop.php" class="btn ref-purchase-btn" style="background: #ffffff !important; color: #1b4332 !important; border: 1px solid var(--border-color); border-radius: 30px !important; padding: 12px 24px !important; box-shadow: var(--shadow-sm) !important;">
                        <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Right Side: Order Summary Card -->
            <div>
                <div style="background: #fff; border-radius: 20px; padding: 28px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid var(--border-color); position: sticky; top: 100px;">
                    <h3 style="font-size: 1.3rem; color: #1b4332; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">Order Summary</h3>
                    
                    <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #4a5568;">
                        <span>Items Subtotal</span>
                        <span style="font-weight: 700; color: #1b4332;"><?= format_price($subtotal) ?></span>
                    </div>

                    <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #4a5568;">
                        <span>Pan-India Delivery</span>
                        <span><?= $shipping == 0 ? '<span style="color:#008744; font-weight:800;">FREE</span>' : format_price($shipping) ?></span>
                    </div>

                    <!-- Promo Coupon Code Box -->
                    <div style="margin: 20px 0; padding: 16px; background: #faf9f5; border-radius: 14px; border: 1px dashed #d4a373;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: #1b4332; display: block; margin-bottom: 8px;"><i class="fas fa-ticket" style="color: #f59e0b;"></i> Have a Coupon Code?</span>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" placeholder="Enter WELCOME10" value="WELCOME10" style="flex: 1; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color); font-size: 0.88rem; font-weight: 700;">
                            <button type="button" onclick="alert('Coupon WELCOME10 applied! 10% Discount will be applied at checkout.');" style="background: #1b4332; color: #fff; border: none; padding: 8px 14px; border-radius: 8px; font-weight: 700; font-size: 0.82rem; cursor: pointer;">Apply</button>
                        </div>
                    </div>

                    <div style="border-top: 2px solid var(--border-color); padding-top: 16px; margin-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 1.1rem; font-weight: 800; color: #1b4332;">Grand Total</span>
                        <span style="font-size: 1.6rem; font-weight: 800; color: #008744; font-family: var(--font-heading);"><?= format_price($grand_total) ?></span>
                    </div>

                    <a href="checkout.php" class="btn ref-purchase-btn" style="width: 100%; text-align: center; margin-top: 24px; padding: 16px !important; font-size: 1.1rem !important; border-radius: 16px !important; display: block;">
                        Proceed to Checkout <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    </a>

                    <!-- Security Trust Badges -->
                    <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 10px; font-size: 0.8rem; color: #718096; border-top: 1px solid var(--border-color); padding-top: 18px;">
                        <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-lock" style="color: #008744;"></i> 256-Bit SSL Encrypted Secure Checkout</div>
                        <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-truck" style="color: #008744;"></i> Fast Doorstep Dispatch Within 24 Hours</div>
                        <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-shield" style="color: #008744;"></i> 100% Quality & Freshness Guarantee</div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Empty Cart State -->
        <div style="text-align: center; padding: 80px 20px; background: #fff; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); max-width: 600px; margin: 0 auto; border: 1px solid var(--border-color);">
            <div style="font-size: 4rem; color: #52b788; margin-bottom: 16px;"><i class="fas fa-shopping-basket"></i></div>
            <h2 style="font-size: 2rem; color: #1b4332; margin-bottom: 10px;">Your Shopping Cart Feels Empty</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 28px; line-height: 1.6;">Explore our 100% organic Karnataka masalas, sprouted ragi baby food, and homemade dry fruit laddus!</p>
            <a href="shop.php" class="btn ref-purchase-btn" style="border-radius: 30px !important; padding: 14px 36px !important;">Start Shopping Now <i class="fas fa-arrow-right"></i></a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
