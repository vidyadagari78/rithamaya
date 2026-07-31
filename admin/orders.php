<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';

// Update Order Status
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = sanitize($_POST['order_status']);

    if ($GLOBALS['db_connected']) {
        try {
            $stmt = $pdo->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
            $stmt->execute([$new_status, $order_id]);
            $msg = "Order status updated to <strong>$new_status</strong>.";
        } catch (Exception $e) {
            $msg = "Error updating order status.";
        }
    }
}

// Fetch orders
$orders = [];
if ($GLOBALS['db_connected']) {
    try {
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY id DESC");
        $orders = $stmt->fetchAll();
    } catch (Exception $e) {
        $orders = [];
    }
}
?>

<div style="margin-bottom: 24px;">
    <h3 style="font-size: 1.4rem; color: var(--primary-color);">Customer Orders Management</h3>
    <p style="font-size: 0.9rem; color: var(--text-muted);">View customer order details and update shipping status</p>
</div>

<?php if (!empty($msg)): ?>
    <div class="alert alert-success"><?= $msg ?></div>
<?php endif; ?>

<div style="background: #fff; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow-x: auto; border: 1px solid var(--border-color);">
    <?php if (count($orders) > 0): ?>
        <table class="cart-table" style="box-shadow: none; margin-bottom: 0; width: 100%;">
            <thead>
                <tr>
                    <th style="white-space: nowrap;">Order #</th>
                    <th style="white-space: nowrap;">Date</th>
                    <th>Customer Contact</th>
                    <th>Address</th>
                    <th style="white-space: nowrap;">Payment</th>
                    <th style="white-space: nowrap;">Total</th>
                    <th style="white-space: nowrap;">Status</th>
                    <th style="white-space: nowrap; text-align: center;">Update Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td style="font-weight: 800; color: #0D5728; white-space: nowrap; font-size: 0.8rem;"><?= sanitize($o['order_number']) ?></td>
                        <td style="font-size: 0.8rem; color: var(--text-muted); white-space: nowrap;">
                            <?= date('d M Y', strtotime($o['created_at'])) ?><br>
                            <span style="font-size: 0.75rem; opacity: 0.85;"><?= date('h:i A', strtotime($o['created_at'])) ?></span>
                        </td>
                        <td style="font-size: 0.82rem; max-width: 170px;">
                            <strong style="color: #1a2e22;"><?= sanitize($o['full_name']) ?></strong><br>
                            <span style="font-size: 0.76rem; color: var(--text-muted);"><?= sanitize($o['phone']) ?></span>
                        </td>
                        <td style="font-size: 0.8rem; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= sanitize($o['address']) ?>">
                            <?= sanitize($o['address']) ?>
                        </td>
                        <td style="white-space: nowrap; font-size: 0.8rem;"><?= sanitize($o['payment_method']) ?></td>
                        <td style="font-weight: 800; color: #0D5728; white-space: nowrap; font-size: 0.88rem;"><?= format_price($o['total_amount']) ?></td>
                        <td style="white-space: nowrap;">
                            <span class="badge" style="background: #e8f5e9; color: #2e7d32; font-weight: 800; font-size: 0.72rem; padding: 4px 8px;">
                                <?= sanitize($o['order_status']) ?>
                            </span>
                        </td>
                        <td style="text-align: center; white-space: nowrap; padding: 8px 6px;">
                            <form action="orders.php" method="POST" style="display: inline-block;">
                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                <input type="hidden" name="update_status" value="1">
                                <select name="order_status" class="form-control" style="padding: 5px 8px; font-size: 0.78rem; font-weight: 800; border-radius: 6px; border: 1px solid var(--border-color); background: #ffffff; cursor: pointer; color: #0D5728;" onchange="this.form.submit()">
                                    <option value="Processing" <?= $o['order_status'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="Shipped" <?= $o['order_status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="Out for Delivery" <?= $o['order_status'] == 'Out for Delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                                    <option value="Delivered" <?= $o['order_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="Cancelled" <?= $o['order_status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 50px 0; color: var(--text-muted);">
            <i class="fas fa-box-open" style="font-size: 2.5rem; color: var(--secondary-color); margin-bottom: 12px;"></i>
            <p>No customer orders placed in the database yet.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
