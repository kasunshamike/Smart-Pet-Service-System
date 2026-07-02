<?php
/**
 * Registration — gradient shell + validation (bcrypt).
 */
require_once __DIR__ . '/db/database.php';

session_start();
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$errors = [];
$success = false;
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password_confirm'] ?? '';

    $nameLen = function_exists('mb_strlen') ? mb_strlen($name) : strlen($name);
    if ($name === '' || $nameLen < 2) {
        $errors[] = 'Please enter your full name (at least 2 characters).';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($password !== $password2) {
        $errors[] = 'Password confirmation does not match.';
    }

    if (empty($errors)) {
        try {
            $pdo = get_db();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if ($hash === false) {
                $errors[] = 'Could not process password on this server.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
                $stmt->execute([
                    ':name'     => $name,
                    ':email'    => $email,
                    ':password' => $hash,
                ]);
                $success = true;
                $name = '';
                $email = '';
            }
        } catch (PDOException $e) {
            $errno = isset($e->errorInfo[1]) ? (int) $e->errorInfo[1] : 0;
            $msg = $e->getMessage();
            $dup = $errno === 1062
                || ($errno === 0 && strpos($msg, 'Duplicate') !== false)
                || (($e->errorInfo[0] ?? '') === '23000' && strpos($msg, 'Duplicate') !== false);

            if ($dup) {
                $errors[] = 'That email is already registered. Try logging in instead.';
            } elseif ($errno === 1045) {
                $errors[] = 'Database login failed: check db/database.php.';
            } elseif ($errno === 2002 || $errno === 2006) {
                $errors[] = 'Cannot reach MySQL. Start the service or try DB_HOST 127.0.0.1.';
            } elseif ($errno === 1049) {
                $errors[] = 'Database missing — import db/schema.sql or refresh after fixing credentials.';
            } elseif ($errno === 1146) {
                $errors[] = 'Tables missing — reload once or import db/schema.sql.';
            } else {
                $errors[] = 'Registration failed (' . ($errno ?: 'connection') . '). Check MySQL and db/database.php.';
            }
        }
    }
}

$pageTitle = 'Register — Smart Pet Service System';
$activeNav = 'register';
require_once __DIR__ . '/includes/header.php';
?>

<section class="auth-section">
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div data-aos="zoom-in-up">
                    <div class="text-center text-white mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-25 p-3 mb-3 shadow">
                            <i class="fa-solid fa-user-plus fa-lg"></i>
                        </span>
                        <h1 class="fw-bold display-6">Join the pack</h1>
                        <p class="text-white-50 mb-0">Free account · colourful booking tools · tailored reminders.</p>
                    </div>

                    <?php if ($success): ?>
                        <div class="alert alert-success border-0 rounded-4 text-center">You’re in! <a href="login.php" class="alert-link">Log in</a>.</div>
                    <?php endif; ?>
                    <?php foreach ($errors as $msg): ?>
                        <div class="alert alert-danger border-0 rounded-4"><?php echo htmlspecialchars($msg); ?></div>
                    <?php endforeach; ?>

                    <div class="auth-card p-4 p-md-5">
                        <form method="post" action="register.php" novalidate>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required maxlength="120" value="<?php echo htmlspecialchars($name); ?>">
                                <label for="name">Full name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required maxlength="190" value="<?php echo htmlspecialchars($email); ?>">
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required minlength="8" autocomplete="new-password">
                                <label for="password">Password (8+ chars)</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm" required minlength="8" autocomplete="new-password">
                                <label for="password_confirm">Confirm password</label>
                            </div>
                            <button type="submit" class="btn btn-gradient w-100 btn-lg rounded-pill btn-animate shadow-glow"><i class="fa-solid fa-leaf me-2"></i>Create account</button>
                        </form>
                        <p class="text-center text-white-50 small mt-4 mb-0">Already registered? <a href="login.php" class="text-warning fw-semibold text-decoration-none">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
