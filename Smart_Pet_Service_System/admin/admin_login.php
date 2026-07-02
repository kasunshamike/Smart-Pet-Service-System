<?php
/**
 * Admin login — standalone minimal chrome + gradient panel.
 */
require_once __DIR__ . '/../db/database.php';

session_start();
if (!empty($_SESSION['admin_id'])) {
    header('Location: admin_dashboard.php');
    exit();
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '') {
        $errors[] = 'Username is required.';
    }
    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        $pdo = get_db();
        $stmt = $pdo->prepare('SELECT id, username, password FROM admins WHERE username = :u LIMIT 1');
        $stmt->execute([':u' => $username]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            header('Location: admin_dashboard.php');
            exit();
        }
        $errors[] = 'Invalid administrator credentials.';
    }
}

$pageTitle = 'Admin Login — Smart Pet Service System';
$omitNavigation = true;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="admin-login-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6">
                <div class="glass-card p-4 p-md-5 text-dark shadow-lg" data-aos="zoom-in">
                    <div class="text-center mb-4">
                        <span class="d-inline-flex rounded-circle p-3 mb-3" style="background: linear-gradient(135deg,#6366f1,#ec4899); color:#fff;">
                            <i class="fa-solid fa-user-shield fa-lg"></i>
                        </span>
                        <h1 class="h3 fw-bold">Administrator login</h1>
                        <p class="text-muted small mb-0">Demo: <strong>admin</strong> / <strong>password</strong> — change on production.</p>
                    </div>
                    <?php foreach ($errors as $msg): ?>
                        <div class="alert alert-danger rounded-3"><?php echo htmlspecialchars($msg); ?></div>
                    <?php endforeach; ?>
                    <form method="post" action="admin_login.php" autocomplete="off">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="username" name="username" placeholder="User" required maxlength="80" value="<?php echo htmlspecialchars($username); ?>">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Pass" required>
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" class="btn btn-gradient w-100 btn-lg rounded-pill btn-animate shadow-glow"><i class="fa-solid fa-lock-open me-2"></i>Enter dashboard</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
