<?php
/**
 * Contact — glass form, interactive map, and local Vavuniya contact channels.
 */
require_once __DIR__ . '/db/database.php';

$strLen = static function (string $s): int {
    return function_exists('mb_strlen') ? mb_strlen($s) : strlen($s);
};

$errors = [];
$sent = false;
$name = '';
$email = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $strLen($name) < 2) {
        $errors[] = 'Please enter your name.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email.';
    }
    if ($message === '' || $strLen($message) < 10) {
        $errors[] = 'Message must be at least 10 characters.';
    }
    if ($strLen($message) > 4000) {
        $errors[] = 'Message is too long.';
    }

    if (empty($errors)) {
        $pdo = get_db();
        $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)');
        $stmt->execute([
            ':name'    => $name,
            ':email'   => $email,
            ':message' => $message,
        ]);
        $sent = true;
        $name = '';
        $email = '';
        $message = '';
    }
}

$pageTitle = 'Contact — Smart Pet Service System';
$activeNav = 'contact';
require_once __DIR__ . '/includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="section-title display-5 mb-3">Let’s chat</h1>
            <p class="section-sub mx-auto">Questions about boarding, grooming combos, or shy pets? We’re quick on replies.</p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- LEFT COLUMN: CONTACT INPUT FORM FRAME -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="glass-panel p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <?php if ($sent): ?>
                            <div class="alert alert-success rounded-4 border-0 shadow-sm p-3 mb-4">
                                <i class="fa-solid fa-circle-check me-2"></i>Thanks! Your message is tucked safely in our inbox.
                            </div>
                        <?php endif; ?>
                        
                        <?php foreach ($errors as $msg): ?>
                            <div class="alert alert-danger rounded-4 border-0 shadow-sm p-3 mb-4">
                                <i class="fa-solid fa-triangle-exclamation me-2"></i><?php echo htmlspecialchars($msg); ?>
                            </div>
                        <?php endforeach; ?>

                        <form method="post" action="contact.php" class="d-grid gap-4">
                            <div class="form-floating">
                                <input class="form-control rounded-4" type="text" id="name" name="name" placeholder="Name" required maxlength="120" value="<?php echo htmlspecialchars($name); ?>">
                                <label for="name">Your name</label>
                            </div>
                            <div class="form-floating">
                                <input class="form-control rounded-4" type="email" id="email" name="email" placeholder="Email" required maxlength="190" value="<?php echo htmlspecialchars($email); ?>">
                                <label for="email">Email address</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control rounded-4" id="message" name="message" placeholder="Message" style="height: 160px" required maxlength="4000"><?php echo htmlspecialchars($message); ?></textarea>
                                <label for="message">How can we help?</label>
                            </div>
                            <button type="submit" class="btn btn-gradient btn-lg rounded-pill btn-animate text-white fw-bold shadow-sm" style="background: linear-gradient(135deg, #6366f1, #4f46e5);"><i class="fa-solid fa-paper-plane me-2"></i>Send message</button>
                        </form>
                    </div>

                    <div>
                        <hr class="my-4 opacity-25">
                        <p class="small text-muted mb-2 fw-semibold text-uppercase tracking-wider">Ping us socially</p>
                        <div class="social-icons justify-content-start gap-2">
                            <a href="#" class="social-btn text-dark border-0 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg,#e0e7ff,#fce7f3);"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="social-btn text-dark border-0 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg,#fce7f3,#ffedd5);"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="social-btn text-dark border-0 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg,#dbeafe,#e0e7ff);"><i class="fa-brands fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT COLUMN: GOOGLE MAP (VAVUNIYA) & REGIONAL METADATA CARD -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="d-flex flex-column h-100 g-4">
                    
                    <!-- Interactive Google Map pointing to Vavuniya town center -->
                    <div class="w-100 rounded-4 overflow-hidden shadow-sm border mb-4 flex-grow-1" style="min-height: 320px;">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31481.565860710664!2d80.48154564999999!3d8.7516928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afdf98da1cf4d0d%3A0x6bba847c1b500366!2sVavuniya%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1710000000000!5m2!1sen!2slk" 
                            width="100%" 
                            height="100%" 
                            style="border:0; min-height: 320px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    
                    <!-- Localized Northern Province Support Info Ledger -->
                    <div class="glass-card p-4 rounded-4 border bg-white shadow-sm">
                        <h2 class="h5 fw-bold mb-3 text-dark">
                            <i class="fa-solid fa-headset text-primary me-2"></i>Smart Pet Service System
                        </h2>
                        <p class="text-muted small mb-2">
                            <i class="fa-solid fa-map-pin text-danger me-2"></i>A9 Road, Vavuniya, Sri Lanka
                        </p>
                        <p class="text-muted small mb-3">
                            Operating straight from the heart of the Northern Province. Our operations desk manages dynamic regional bookings and supports local pet owners seamlessly.
                        </p>
                        <hr class="opacity-25">
                        <div class="d-flex align-items-center justify-content-between pt-1">
                            <span class="small fw-semibold text-uppercase text-muted">Vavuniya Desk Hotline:</span>
                            <!-- Uses regional landline prefix 024 for Vavuniya district -->
                            <a href="tel:+94242220000" class="fw-bold text-success text-decoration-none fs-5 btn-animate">
                                <i class="fa-solid fa-phone-volume me-2"></i>+94 24 222 0000
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>