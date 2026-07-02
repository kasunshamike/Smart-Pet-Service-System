<?php
/**
 * Customer login — gradient hero + glass card.
 */
require_once __DIR__ . '/db/database.php';

session_start();
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email.';
    }
    if ($password === '') {
        $errors[] = 'Please enter your password.';
    }

    if (empty($errors)) {
        $pdo = get_db();
        $stmt = $pdo->prepare('SELECT id, name, email, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $row['id'];
            $_SESSION['user'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header('Location: dashboard.php');
            exit();
        }
        $errors[] = 'Invalid email or password.';
    }
}

$pageTitle = 'Login — Smart Pet Service System';
$activeNav = 'login';
require_once __DIR__ . '/includes/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-7 col-xl-6">
                <div data-aos="zoom-in-up">
                    <div class="text-center text-white mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-25 p-3 mb-3 shadow">
                            <i class="fa-solid fa-right-to-bracket fa-lg"></i>
                        </span>
                        <h1 class="fw-bold display-6">Welcome back</h1>
                        <p class="text-white-50 mb-0">Care dashboards, bookings, and treats await.</p>
                    </div>
                    <?php foreach ($errors as $msg): ?>
                        <div class="alert alert-danger border-0 rounded-4"><?php echo htmlspecialchars($msg); ?></div>
                    <?php endforeach; ?>
                    <div class="auth-card p-4 p-md-5">
                        <form method="post" action="login.php" autocomplete="on">
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@email.com" required value="<?php echo htmlspecialchars($email); ?>">
                                <label for="email">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                                <label for="password">Password</label>
                            </div>
                            <button type="submit" class="btn btn-gradient w-100 btn-lg rounded-pill btn-animate shadow-glow"><i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Log in</button>
                        </form>
                        <p class="text-center text-white-50 small mt-4 mb-0">New here? <a href="register.php" class="text-warning fw-semibold text-decoration-none">Create an account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
