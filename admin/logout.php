<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — ADMIN LOGOUT (admin/logout.php)
 * ---------------------------------------------------------------------
 * Admin sessiyani tugatish va login sahifasiga yo'naltirish.
 * =====================================================================
 */
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session ma'lumotlarni tozalash
$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

// Login sahifasiga yo'naltirish
header('Location: login.php');
exit;
