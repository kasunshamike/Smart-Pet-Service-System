<?php
/**
 * Ends the admin session only (customer session, if any, stays untouched).
 */
session_start();
unset($_SESSION['admin_id'], $_SESSION['admin_username']);
if (empty($_SESSION)) {
    session_destroy();
}
header('Location: admin_login.php');
exit();
