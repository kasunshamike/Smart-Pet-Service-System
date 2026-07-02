<?php
/**
 * Public site header — sticky glass navbar, fonts & icon CDNs.
 * Set $pageTitle, optional $activeNav ('home','services','pricing','booking','contact','login','register','dashboard').
 * For admin login standalone bar: set $omitNavigation = true before include.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = $pageTitle ?? 'Smart Pet Service System — Pet Sitting';
$activeNav = $activeNav ?? '';
$omitNavigation = !empty($omitNavigation);
$bodyClass = trim(($bodyClass ?? '') . ' page-fade d-flex flex-column min-vh-100');

$base = (basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'admin') ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>css/style.css">
</head>
<body class="<?php echo htmlspecialchars($bodyClass); ?>">
<?php if ($omitNavigation): ?>
    <div class="minimal-top-bar glass-nav py-3 px-4 d-flex align-items-center justify-content-between">
        <a class="navbar-brand d-flex align-items-center gap-2 text-white text-decoration-none fw-bold" href="<?php echo $base; ?>index.php">
            <span class="brand-icon"><i class="fa-solid fa-paw"></i></span>
            <span>Smart Pet Service System</span>
        </a>
        <a class="btn btn-sm btn-outline-light rounded-pill" href="<?php echo $base; ?>index.php"><i class="fa-solid fa-arrow-left me-1"></i> Back to site</a>
    </div>
<?php else: ?>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top glass-nav shadow-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?php echo $base; ?>index.php">
            <span class="brand-icon"><i class="fa-solid fa-paw"></i></span>
            <span>Smart Pet Service System</span>
        </a>
        <button class="navbar-toggler rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link nav-pill<?php echo $activeNav === 'home' ? ' active' : ''; ?>" href="<?php echo $base; ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link nav-pill<?php echo $activeNav === 'services' ? ' active' : ''; ?>" href="<?php echo $base; ?>services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link nav-pill<?php echo $activeNav === 'pricing' ? ' active' : ''; ?>" href="<?php echo $base; ?>pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link nav-pill<?php echo $activeNav === 'booking' ? ' active' : ''; ?>" href="<?php echo $base; ?>booking.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link nav-pill<?php echo $activeNav === 'contact' ? ' active' : ''; ?>" href="<?php echo $base; ?>contact.php">Contact</a></li>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link nav-pill<?php echo $activeNav === 'dashboard' ? ' active' : ''; ?>" href="<?php echo $base; ?>dashboard.php"><i class="fa-solid fa-gauge-high me-1"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="btn btn-gradient-outline btn-sm ms-lg-2 mt-2 mt-lg-0 rounded-pill px-3" href="<?php echo $base; ?>logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link nav-pill<?php echo $activeNav === 'login' ? ' active' : ''; ?>" href="<?php echo $base; ?>login.php">Login</a></li>
                    <li class="nav-item"><a class="btn btn-gradient btn-sm ms-lg-2 mt-2 mt-lg-0 rounded-pill px-4 shadow-glow" href="<?php echo $base; ?>register.php">Register</a></li>
                <?php endif; ?>
                <?php if ($base === ''): ?>
                    <li class="nav-item"><a class="nav-link text-warning fw-semibold<?php echo $activeNav === 'admin' ? ' active' : ''; ?>" href="admin/admin_login.php"><i class="fa-solid fa-lock me-1"></i> Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>
<main class="flex-grow-1">
