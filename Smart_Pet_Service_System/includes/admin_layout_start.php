<?php
/**
 * Opens HTML shell for admin panel (requires admin_auth.php already loaded).
 * Sets $pageTitle before including.
 */
$pageTitle = $pageTitle ?? 'Admin — Smart Pet Service System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-app page-fade">
<div class="admin-shell d-flex min-vh-100">
    <aside class="admin-sidebar text-white p-4 d-flex flex-column">
        <a href="admin_dashboard.php" class="text-white text-decoration-none fw-bold fs-5 mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-shield-cat"></i> Admin
        </a>
        <nav class="nav flex-column gap-1 flex-grow-1">
            <a class="nav-link admin-nav-link active" href="admin_dashboard.php"><i class="fa-solid fa-chart-line me-2"></i> Overview</a>
            <a class="nav-link admin-nav-link" href="#section-users"><i class="fa-solid fa-users me-2"></i> Users</a>
            <a class="nav-link admin-nav-link" href="#section-bookings"><i class="fa-solid fa-calendar-check me-2"></i> Bookings</a>
            <a class="nav-link admin-nav-link" href="#section-contacts"><i class="fa-solid fa-envelope me-2"></i> Messages</a>
        </nav>
        <div class="mt-4 pt-3 border-top border-secondary">
            <a class="btn btn-outline-light btn-sm w-100 rounded-pill mb-2" href="../index.php" target="_blank"><i class="fa-solid fa-globe me-1"></i> View site</a>
            <a class="btn btn-danger btn-sm w-100 rounded-pill" href="admin_logout.php"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a>
        </div>
    </aside>
    <div class="flex-grow-1 d-flex flex-column min-vh-100 bg-admin-content">
        <header class="admin-topbar border-bottom bg-white px-4 py-3 d-flex justify-content-between align-items-center">
            <h1 class="h5 mb-0 text-secondary"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <span class="small text-muted"><i class="fa-solid fa-user-shield me-1"></i><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
        </header>
        <main class="admin-main flex-grow-1 p-4">
