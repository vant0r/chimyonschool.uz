<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — Asosiy konfiguratsiya va MB ulanishi (PDO)
 * ---------------------------------------------------------------------
 * Bu fayl har bir sahifada bir marta ulanadi.
 * Hosting'ga joylashtirganda quyidagi ma'lumotlarni o'zgartiring.
 * =====================================================================
 */

// -------- Ma'lumotlar bazasi sozlamalari --------
define('DB_HOST', 'localhost');
define('DB_NAME', 'pvycpxdh_school');
define('DB_USER', 'pvycpxdh_school');        // hosting login'ingiz
define('DB_PASS', 'UNYnVVUTLu76TcNy3cF2');            // hosting parolingiz
define('DB_CHARSET', 'utf8mb4');

// -------- Sayt sozlamalari --------
define('SITE_NAME', 'Chimyon School');
define('SITE_URL', 'https://webhub.x10.network');

// Yuklangan fayllar joylashadigan papka (server ildizidan)
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_URL', '/uploads/');

// -------- Xatoliklarni ko'rsatish (ishlab chiqishda 1, saytda 0) --------
define('DEBUG', true);
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// -------- Vaqt zonasi --------
date_default_timezone_set('Asia/Tashkent');

/**
 * PDO ulanishini qaytaradi (bitta nusxa — singleton).
 * Barcha so'rovlar prepared statements orqali (SQL-injection himoyasi).
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (DEBUG) {
                die('Ma\'lumotlar bazasiga ulanishda xatolik: ' . $e->getMessage());
            }
            die('Ma\'lumotlar bazasiga ulanib bo\'lmadi. Iltimos, keyinroq urinib ko\'ring.');
        }
    }
    return $pdo;
}

/**
 * Sayt sozlamalarini (settings jadvali) qaytaradi — keshlangan.
 */
function get_settings(): array
{
    static $cache = null;
    if ($cache === null) {
        $stmt = db()->query('SELECT * FROM settings WHERE id = 1 LIMIT 1');
        $cache = $stmt->fetch() ?: [];
    }
    return $cache;
}

/**
 * XSS himoyasi — chiqishda matnni tozalash.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * CSRF token generatsiya / tekshirish.
 */
function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_check(?string $token): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['csrf_token'])
        && is_string($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Rasm URL'ini qaytaradi (yuklanmagan bo'lsa — placeholder).
 */
function upload_url(?string $file, string $fallback = ''): string
{
    if ($file && file_exists(UPLOAD_DIR . $file)) {
        return UPLOAD_URL . rawurlencode($file);
    }
    return $fallback ?: 'https://placehold.co/600x400/0a1f44/d4af37?text=Chimyon+School';
}

/**
 * Sanani o'zbekcha formatda qaytaradi.
 */
function uz_date(string $datetime): string
{
    $oylar = [
        1 => 'yanvar', 2 => 'fevral', 3 => 'mart', 4 => 'aprel',
        5 => 'may', 6 => 'iyun', 7 => 'iyul', 8 => 'avgust',
        9 => 'sentabr', 10 => 'oktabr', 11 => 'noyabr', 12 => 'dekabr',
    ];
    $ts = strtotime($datetime);
    return date('j', $ts) . ' ' . $oylar[(int) date('n', $ts)] . ', ' . date('Y', $ts);
}
