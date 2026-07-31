<?php
require_once __DIR__ . '/includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Customer';
$user_email = $_SESSION['user_email'] ?? '';

$user_orders = [];
if ($GLOBALS['db_connected']) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? OR email = ? ORDER BY id DESC");
        $stmt->execute([$user_id, $user_email]);
        $user_orders = $stmt->fetchAll();
    } catch (Exception $e) {
        $user_orders = [];
    }
}
?>

<!-- Account Page Banner (Signature Theme Banner) -->
<div class="page-banner">
    <div class="container">
        <span style="color: var(--secondary-color); font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1.5px;">CUSTOMER DASHBOARD</span>
        <h1 style="font-size: 2.5rem; font-weight: 900; margin-top: 6px;">My Account Dashboard</h1>
        <p>Manage your account profile and track live order progress in real-time.</p>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    <div class="account-dashboard-grid" style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 40px;">
        <!-- User Sidebar Profile -->
        <div style="background: #fff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); text-align: center; height: fit-content;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; font-weight: bold; margin: 0 auto 16px;">
                <?= strtoupper(substr($user_name, 0, 1)) ?>
            </div>
            <h3 style="font-size: 1.2rem; margin-bottom: 4px;"><?= sanitize($user_name) ?></h3>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;"><?= sanitize($user_email) ?></p>

            <hr style="border: 0; border-top: 1px solid var(--border-color); margin-bottom: 20px;">

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="shop.php" class="btn btn-outline" style="font-size: 0.88rem;"><i class="fas fa-store"></i> Browse Catalog</a>
                <a href="logout.php" class="btn" style="background: #ffebee; color: #c62828; font-size: 0.88rem;"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Orders Section -->
        <div>
            <div style="background: #fff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                <h3 style="font-size: 1.4rem; color: #0D5728; margin-bottom: 20px; font-weight: 800;">My Order History</h3>

                <?php if (count($user_orders) > 0): ?>
                    <table class="cart-table" style="box-shadow: none; margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th style="text-align: center;">Track & Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_orders as $order): 
                                $st = strtoupper($order['order_status'] ?? 'PROCESSING');
                                $badge_bg = '#e8f5e9';
                                $badge_clr = '#2e7d32';
                                if ($st === 'SHIPPED') {
                                    $badge_bg = '#e0f2f1';
                                    $badge_clr = '#00695c';
                                } elseif ($st === 'OUT FOR DELIVERY') {
                                    $badge_bg = '#f1f8e9';
                                    $badge_clr = '#33691e';
                                } elseif ($st === 'DELIVERED') {
                                    $badge_bg = '#d4edda';
                                    $badge_clr = '#155724';
                                } elseif ($st === 'CANCELLED') {
                                    $badge_bg = '#ffebee';
                                    $badge_clr = '#c62828';
                                }
                            ?>
                                <tr>
                                    <td style="font-weight: 800; color: #0D5728;"><?= sanitize($order['order_number']) ?></td>
                                    <td style="font-size: 0.85rem; color: var(--text-muted);"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></td>
                                    <td>
                                        <span class="badge" style="background: <?= $badge_bg ?>; color: <?= $badge_clr ?>; font-weight: 800; font-size: 0.78rem; padding: 5px 10px;">
                                            <?= sanitize($order['order_status']) ?>
                                        </span>
                                    </td>
                                    <td style="font-weight: 800; color: #0D5728;"><?= format_price($order['total_amount']) ?></td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn-track-order" onclick='openOrderTracker(<?= json_encode($order) ?>)'>
                                            <i class="fas fa-truck-fast"></i> Track Order
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px 0;">
                        <i class="fas fa-box" style="font-size: 2.5rem; color: #5CB832; margin-bottom: 12px;"></i>
                        <p style="color: var(--text-muted);">You haven't placed any orders yet.</p>
                        <a href="shop.php" class="btn btn-primary" style="margin-top: 16px;">Explore Products</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Order Tracking Interactive Modal Popup -->
<div id="trackerModalOverlay" class="tracker-modal-overlay">
    <div class="tracker-modal-container">
        <div class="tracker-modal-header">
            <div style="display: flex; justify-content: space-between; align-items: center; padding-right: 40px;">
                <div>
                    <h3>Live Order Tracking</h3>
                    <p style="font-size: 0.85rem; color: #b7e4c7; margin: 0;">Order #: <span id="modalOrderNum" style="font-weight: 800; color: #fff;"></span></p>
                </div>
                <div id="modalStatusBadge"></div>
            </div>
            <button type="button" class="tracker-modal-close" onclick="closeOrderTracker()">&times;</button>
        </div>

        <div class="tracker-modal-body">
            <!-- Cancelled Alert Banner -->
            <div id="cancelledAlert" style="display: none; background: #ffebee; border: 1px solid #ffcdd2; color: #c62828; padding: 14px 18px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; margin-bottom: 20px; align-items: center; gap: 10px;">
                <i class="fas fa-circle-xmark" style="font-size: 1.3rem;"></i>
                <span>This order was cancelled. Please contact support if you have any questions.</span>
            </div>

            <!-- Progress Stepper Timeline -->
            <div class="tracker-stepper">
                <!-- Step 1 -->
                <div id="step-placed" class="tracker-step completed">
                    <div class="step-icon-circle"><i class="fas fa-check"></i></div>
                    <div class="step-label">Order Placed<br><span style="font-size:0.7rem; font-weight:normal; opacity:0.8;">Confirmed</span></div>
                </div>
                <!-- Step 2 -->
                <div id="step-processing" class="tracker-step">
                    <div class="step-icon-circle"><i class="fas fa-boxes-packing"></i></div>
                    <div class="step-label">Processing<br><span style="font-size:0.7rem; font-weight:normal; opacity:0.8;">Quality Check</span></div>
                </div>
                <!-- Step 3 -->
                <div id="step-shipped" class="tracker-step">
                    <div class="step-icon-circle"><i class="fas fa-truck-ramp-box"></i></div>
                    <div class="step-label">Dispatched<br><span style="font-size:0.7rem; font-weight:normal; opacity:0.8;">In Transit</span></div>
                </div>
                <!-- Step 4 -->
                <div id="step-delivered" class="tracker-step">
                    <div class="step-icon-circle"><i class="fas fa-house-chimney-user"></i></div>
                    <div class="step-label">Delivered<br><span style="font-size:0.7rem; font-weight:normal; opacity:0.8;">Handed Over</span></div>
                </div>
            </div>

            <!-- Order Details Card -->
            <div style="background: #faf6f0; border-radius: 16px; padding: 20px; border: 1px solid #e8dfd5; margin-top: 24px;">
                <h4 style="font-size: 1rem; color: #0D5728; font-weight: 800; margin-bottom: 12px; border-bottom: 1px solid #e0e9e3; padding-bottom: 8px;">Order Details Summary</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.88rem;">
                    <div>
                        <span style="color: #66776c;">Placed On:</span><br>
                        <strong id="modalOrderDate" style="color: #0D5728;"></strong>
                    </div>
                    <div>
                        <span style="color: #66776c;">Total Paid:</span><br>
                        <strong id="modalOrderTotal" style="color: #0D5728;"></strong>
                    </div>
                    <div>
                        <span style="color: #66776c;">Payment Method:</span><br>
                        <strong id="modalOrderPayment" style="color: #0D5728;"></strong>
                    </div>
                    <div>
                        <span style="color: #66776c;">Shipping Address:</span><br>
                        <span id="modalOrderAddress" style="color: #1a2e22; font-weight: 600;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openOrderTracker(order) {
    document.getElementById('modalOrderNum').innerText = order.order_number || '';
    document.getElementById('modalOrderDate').innerText = order.created_at || '';
    document.getElementById('modalOrderTotal').innerText = '₹' + parseFloat(order.total_amount || 0).toFixed(2);
    document.getElementById('modalOrderAddress').innerText = order.address || 'Registered Shipping Address';
    document.getElementById('modalOrderPayment').innerText = order.payment_method || 'Online Payment';
    
    const status = (order.order_status || 'Processing').toLowerCase();
    
    const step1 = document.getElementById('step-placed');
    const step2 = document.getElementById('step-processing');
    const step3 = document.getElementById('step-shipped');
    const step4 = document.getElementById('step-delivered');
    const cancelledAlert = document.getElementById('cancelledAlert');
    const modalStatusBadge = document.getElementById('modalStatusBadge');

    step1.className = 'tracker-step completed';
    step2.className = 'tracker-step';
    step3.className = 'tracker-step';
    step4.className = 'tracker-step';
    cancelledAlert.style.display = 'none';

    modalStatusBadge.innerHTML = `<span style="background: #ffffff; color: #0D5728; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 0.8rem; text-transform: uppercase;">${order.order_status}</span>`;

    if (status === 'cancelled') {
        cancelledAlert.style.display = 'flex';
    } else if (status === 'delivered') {
        step2.className = 'tracker-step completed';
        step3.className = 'tracker-step completed';
        step4.className = 'tracker-step completed active';
    } else if (status === 'out for delivery') {
        step2.className = 'tracker-step completed';
        step3.className = 'tracker-step completed';
        step4.className = 'tracker-step active';
    } else if (status === 'shipped') {
        step2.className = 'tracker-step completed';
        step3.className = 'tracker-step active';
    } else {
        step2.className = 'tracker-step active';
    }

    document.getElementById('trackerModalOverlay').classList.add('active');
}

function closeOrderTracker() {
    document.getElementById('trackerModalOverlay').classList.remove('active');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
