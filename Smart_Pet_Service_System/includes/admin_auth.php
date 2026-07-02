<?php
/**
 * Protects admin-only pages under /admin/. Include at the top of each admin page.
 * Redirects to admin_login.php if not authenticated as admin.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    header('Location: admin_login.php');
    exit();
}
