<?php
require_once __DIR__ . '/includes/admin_header.php';

$message = '';
$error = '';

// Handle Add Product
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_product') {
    $name = sanitize($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 1);
    $price = (float)($_POST['price'] ?? 0);
    $weight = sanitize($_POST['weight'] ?? '250g');
    $badge = sanitize($_POST['badge'] ?? 'Organic');
    $stock = (int)($_POST['stock'] ?? 100);
    $short_desc = sanitize($_POST['short_description'] ?? '');
    $desc = sanitize($_POST['description'] ?? '');
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    $image_path = 'assets/images/products/multigrain-health-mix.png'; // default fallback

    // Image Upload Handling
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['product_image']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['product_image']['name']);
        $upload_dir = __DIR__ . '/../assets/images/products/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($file_tmp, $target_file)) {
            $image_path = 'assets/images/products/' . $file_name;
        }
    }

    if (!empty($name) && $price > 0) {
        if ($GLOBALS['db_connected']) {
            try {
                $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, short_description, description, price, weight, badge, stock, image, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
                $stmt->execute([$category_id, $name, $slug, $short_desc, $desc, $price, $weight, $badge, $stock, $image_path]);
                $message = "Product <strong>$name</strong> added successfully!";
            } catch (Exception $e) {
                $error = "Database error adding product.";
            }
        } else {
            $message = "Product added (Preview Mode).";
        }
    } else {
        $error = "Product Name and valid Price are required.";
    }
}

// Handle Edit Product
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_product') {
    $edit_id = (int)($_POST['product_id'] ?? 0);
    $name = sanitize($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 1);
    $price = (float)($_POST['price'] ?? 0);
    $weight = sanitize($_POST['weight'] ?? '250g');
    $badge = sanitize($_POST['badge'] ?? 'Organic');
    $stock = (int)($_POST['stock'] ?? 100);
    $short_desc = sanitize($_POST['short_description'] ?? '');
    $desc = sanitize($_POST['description'] ?? '');
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    $image_path = null;

    // Image Upload Handling if new image is provided
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['product_image']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['product_image']['name']);
        $upload_dir = __DIR__ . '/../assets/images/products/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($file_tmp, $target_file)) {
            $image_path = 'assets/images/products/' . $file_name;
        }
    }

    if ($edit_id > 0 && !empty($name) && $price > 0) {
        if ($GLOBALS['db_connected']) {
            try {
                if ($image_path) {
                    $stmt = $pdo->prepare("UPDATE products SET category_id = ?, name = ?, slug = ?, short_description = ?, description = ?, price = ?, weight = ?, badge = ?, stock = ?, image = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$category_id, $name, $slug, $short_desc, $desc, $price, $weight, $badge, $stock, $image_path, $edit_id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE products SET category_id = ?, name = ?, slug = ?, short_description = ?, description = ?, price = ?, weight = ?, badge = ?, stock = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$category_id, $name, $slug, $short_desc, $desc, $price, $weight, $badge, $stock, $edit_id]);
                }
                $message = "Product <strong>$name</strong> updated successfully!";
            } catch (Exception $e) {
                $error = "Database error updating product.";
            }
        } else {
            $message = "Product <strong>$name</strong> updated (Preview Mode).";
        }
    } else {
        $error = "Product ID, Name, and valid Price are required for editing.";
    }
}

// Handle Delete Product
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    if ($GLOBALS['db_connected']) {
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$delete_id]);
            $message = "Product deleted successfully.";
        } catch (Exception $e) {
            $error = "Error deleting product.";
        }
    }
}

// Fetch all products
$products = [];
if ($GLOBALS['db_connected']) {
    try {
        $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.updated_at DESC, p.id DESC");
        $products = $stmt->fetchAll();
    } catch (Exception $e) {
        $products = [];
    }
}
if (empty($products)) {
    $products = get_mock_products();
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h3 style="font-size: 1.4rem; color: var(--primary-color);">Manage Store Products</h3>
    <button onclick="document.getElementById('addProductModal').style.display='block'" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Product
    </button>
</div>

<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<!-- Products Data Table -->
<div style="background: #fff; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow: hidden; border: 1px solid var(--border-color);">
    <table class="cart-table" style="box-shadow: none; margin-bottom: 0;">
        <thead>
            <tr>
                <th style="width: 45px; text-align: center;">ID</th>
                <th style="width: 55px; text-align: center;">Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Weight</th>
                <th>Badge</th>
                <th>Stock</th>
                <th style="width: 90px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td style="text-align: center; font-weight: 700;">#<?= $p['id'] ?></td>
                    <td style="text-align: center;">
                        <img src="../<?= sanitize($p['image']) ?>" alt="<?= sanitize($p['name']) ?>" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color); display: block; margin: 0 auto;">
                    </td>
                    <td style="font-weight: 800; color: #0D5728; max-width: 180px; font-size: 0.88rem; line-height: 1.3;"><?= sanitize($p['name']) ?></td>
                    <td><span style="font-size: 0.82rem; color: #5CB832; font-weight: 700;"><?= sanitize($p['category_name']) ?></span></td>
                    <td style="font-weight: 800; color: #0D5728; white-space: nowrap;"><?= format_price($p['price']) ?></td>
                    <td style="font-weight: 600; white-space: nowrap;"><?= sanitize($p['weight']) ?></td>
                    <td><span class="badge badge-organic" style="font-weight: 800; font-size: 0.7rem; padding: 4px 8px;"><?= sanitize($p['badge']) ?></span></td>
                    <td style="white-space: nowrap;"><span style="color: #0D5728; font-weight: 800; font-size: 0.85rem;"><?= $p['stock'] ?> units</span></td>
                    <td style="text-align: center; padding: 10px 4px; width: 90px;">
                        <div style="display: flex; flex-direction: column; gap: 5px; align-items: center; justify-content: center;">
                            <button type="button" 
                                    onclick="openEditModal(<?= htmlspecialchars(json_encode([
                                        'id' => $p['id'],
                                        'name' => $p['name'],
                                        'category_id' => $p['category_id'] ?? 1,
                                        'price' => $p['price'],
                                        'weight' => $p['weight'],
                                        'badge' => $p['badge'],
                                        'stock' => $p['stock'],
                                        'short_description' => $p['short_description'] ?? '',
                                        'description' => $p['description'] ?? '',
                                        'image' => $p['image'] ?? ''
                                    ]), ENT_QUOTES, 'UTF-8') ?>)" 
                                    style="background: #e8f5e9; border: 1px solid #5CB832; color: #0D5728; width: 76px; padding: 5px 6px; border-radius: 6px; cursor: pointer; font-size: 0.78rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; gap: 4px;" 
                                    title="Edit Product Details">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <a href="products.php?delete=<?= $p['id'] ?>" 
                               onclick="return confirm('Are you sure you want to delete product #<?= $p['id'] ?> (<?= sanitize($p['name']) ?>)?');" 
                               style="background: #ffebee; border: 1px solid #ef9a9a; color: #c62828; width: 76px; padding: 5px 6px; border-radius: 6px; font-size: 0.78rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; gap: 4px; text-decoration: none;" 
                               title="Delete Product">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Product Modal Form -->
<div id="addProductModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 2000; overflow-y: auto; padding: 40px 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 1.3rem; color: var(--primary-color);"><i class="fas fa-plus-circle" style="color:#5CB832;"></i> Add New RM Sampoorna Product</h3>
            <span onclick="document.getElementById('addProductModal').style.display='none'" style="font-size: 1.5rem; cursor: pointer;">&times;</span>
        </div>

        <form action="products.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_product">

            <div class="form-group">
                <label class="form-label">Product Name *</label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Traditional Mysuru Sambar Powder">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control">
                        <option value="1">Health & Multigrain Mixes</option>
                        <option value="2">Masala & Spice Powders</option>
                        <option value="3">Baby & Infant Food</option>
                        <option value="4">Traditional Sweets & Laddus</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Price (₹) *</label>
                    <input type="number" step="0.01" name="price" class="form-control" required placeholder="249.00">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Net Weight</label>
                    <input type="text" name="weight" class="form-control" placeholder="250g / 500g" value="250g">
                </div>
                <div class="form-group">
                    <label class="form-label">Badge Tag</label>
                    <input type="text" name="badge" class="form-control" placeholder="Organic / Pure" value="Organic">
                </div>
                <div class="form-group">
                    <label class="form-label">Initial Stock</label>
                    <input type="number" name="stock" class="form-control" value="100">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Product Image (Pouch Photo)</label>
                <input type="file" name="product_image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label class="form-label">Short Summary</label>
                <input type="text" name="short_description" class="form-control" placeholder="100% natural homemade spice mix">
            </div>

            <div class="form-group">
                <label class="form-label">Full Description</label>
                <textarea name="description" rows="4" class="form-control" placeholder="Detailed ingredients & health benefits..."></textarea>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" onclick="document.getElementById('addProductModal').style.display='none'" class="btn" style="background: #e9ecef;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #703816 !important; border: none !important;"><i class="fas fa-save"></i> Save Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal Form -->
<div id="editProductModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 2000; overflow-y: auto; padding: 40px 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 1.3rem; color: #703816;"><i class="fas fa-edit" style="color:#5CB832;"></i> Edit Product Details</h3>
            <span onclick="document.getElementById('editProductModal').style.display='none'" style="font-size: 1.5rem; cursor: pointer;">&times;</span>
        </div>

        <form action="products.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit_product">
            <input type="hidden" name="product_id" id="edit_product_id" value="">

            <div class="form-group">
                <label class="form-label">Product Name *</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" id="edit_category_id" class="form-control">
                        <option value="1">Health & Multigrain Mixes</option>
                        <option value="2">Masala & Spice Powders</option>
                        <option value="3">Baby & Infant Food</option>
                        <option value="4">Traditional Sweets & Laddus</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Price (₹) *</label>
                    <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Net Weight</label>
                    <input type="text" name="weight" id="edit_weight" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Badge Tag</label>
                    <input type="text" name="badge" id="edit_badge" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock" id="edit_stock" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Product Image (Upload new image to replace current)</label>
                <input type="file" name="product_image" class="form-control" accept="image/*">
                <div id="edit_image_preview_box" style="margin-top: 10px; display: none; align-items: center; gap: 10px;">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Current Image:</span>
                    <img id="edit_current_image_preview" src="" alt="Current Product Image" style="height: 48px; width: 48px; object-fit: contain; border-radius: 6px; border: 1px solid #ddd; padding: 2px;">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Short Summary</label>
                <input type="text" name="short_description" id="edit_short_description" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Full Description</label>
                <textarea name="description" id="edit_description" rows="4" class="form-control"></textarea>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" onclick="document.getElementById('editProductModal').style.display='none'" class="btn" style="background: #e9ecef;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #703816 !important; border: none !important;"><i class="fas fa-check-circle"></i> Update Product</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(p) {
    document.getElementById('edit_product_id').value = p.id || '';
    document.getElementById('edit_name').value = p.name || '';
    document.getElementById('edit_category_id').value = p.category_id || 1;
    document.getElementById('edit_price').value = p.price || '';
    document.getElementById('edit_weight').value = p.weight || '';
    document.getElementById('edit_badge').value = p.badge || '';
    document.getElementById('edit_stock').value = p.stock || 100;
    document.getElementById('edit_short_description').value = p.short_description || '';
    document.getElementById('edit_description').value = p.description || '';
    
    if (p.image) {
        document.getElementById('edit_current_image_preview').src = '../' + p.image;
        document.getElementById('edit_image_preview_box').style.display = 'flex';
    } else {
        document.getElementById('edit_image_preview_box').style.display = 'none';
    }
    
    document.getElementById('editProductModal').style.display = 'block';
}
</script>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
