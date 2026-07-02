<?php
/**
 * Protects customer-only pages. Include at the top of any page that requires a logged-in user.
 * If the session is not set, redirects to login.php and stops execution.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
