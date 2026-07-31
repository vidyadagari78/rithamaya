<?php
require_once __DIR__ . '/includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        if ($GLOBALS['db_connected']) {
            try {
                $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $phone, $subject, $message]);
                $success = true;
            } catch (Exception $e) {
                $error = "Error saving message. Please try again.";
            }
        } else {
            $success = true;
        }

        if ($success) {
            $_SESSION['success_msg'] = "Thank you, <strong>$name</strong>! Your message has been sent. We will respond within 24 hours.";
            header("Location: contact.php");
            exit;
        }
    } else {
        $error = "Please fill in all required fields (Name, Email, Message).";
    }
}
?>

<!-- Contact Page Hero Banner (Signature Theme Banner) -->
<div class="page-banner">
    <div class="container">
        <span style="color: var(--secondary-color); font-weight: 800; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1.5px;">GET IN TOUCH</span>
        <h1 style="font-size: 2.5rem; font-weight: 900; margin-top: 6px;">Contact Us & Support</h1>
        <p>Have questions about our organic products or custom order inquiries? We'd love to hear from you!</p>
    </div>
</div>

<div class="container" style="margin-bottom: 80px;">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px;">
        <!-- Contact Form -->
        <div style="background: #fff; padding: 36px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 1.6rem; margin-bottom: 20px;">Send Us A Message</h2>

            <form action="contact.php" method="POST">
                <div class="form-group">
                    <label class="form-label">Your Name *</label>
                    <input type="text" name="name" class="form-control" required placeholder="Enter full name">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="e.g. Bulk Order Inquiry / Product Question">
                </div>

                <div class="form-group">
                    <label class="form-label">Your Message *</label>
                    <textarea name="message" rows="5" class="form-control" required placeholder="Write your message here..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

        <!-- Contact Information & Address -->
        <div>
            <div style="background: linear-gradient(135deg, #1b4332, #2d6a4f); color: #fff; padding: 36px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin-bottom: 30px;">
                <h3 style="color: #fff; font-size: 1.5rem; margin-bottom: 20px;">Store Information</h3>
                
                <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                    <i class="fas fa-map-marker-alt" style="font-size: 1.4rem; color: var(--secondary-color); margin-top: 4px;"></i>
                    <div>
                        <h4 style="color: #fff; font-size: 1.05rem;">Our Office & Kitchen</h4>
                        <p style="color: #d8f3dc; font-size: 0.9rem;">RM's Sampoorna Food Products<br>Bengaluru, Karnataka - 560001, India</p>
                    </div>
                </div>

                <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                    <i class="fas fa-phone-alt" style="font-size: 1.4rem; color: var(--secondary-color); margin-top: 4px;"></i>
                    <div>
                        <h4 style="color: #fff; font-size: 1.05rem;">Call / WhatsApp Us</h4>
                        <p style="color: #d8f3dc; font-size: 0.9rem;">+91 98765 43210 / +91 98765 43211</p>
                    </div>
                </div>

                <div style="display: flex; gap: 16px;">
                    <i class="fas fa-envelope" style="font-size: 1.4rem; color: var(--secondary-color); margin-top: 4px;"></i>
                    <div>
                        <h4 style="color: #fff; font-size: 1.05rem;">Email Support</h4>
                        <p style="color: #d8f3dc; font-size: 0.9rem;">support@rithamaya.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
