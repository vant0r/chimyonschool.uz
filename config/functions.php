<?php
/**
 * Umumiy funksiyalar va yordamchi vositalar
 */

// Xavfsiz ma'lumotlarni tozalash
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Fayl yuklash funksiyasi
function upload_file($file, $target_dir, $allowed_types = ['image/jpeg', 'image/png', 'image/gif']) {
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Fayl turi tekshiruvi
    $check = getimagesize($file["tmp_name"]);
    if($check === false && !empty($file["name"])) {
        return ['success' => false, 'message' => "Fayl rasm emas."];
    }

    // Fayl hajmi (5MB)
    if ($file["size"] > 5000000) {
        return ['success' => false, 'message' => "Fayl hajmi juda katta."];
    }

    // Ruxsat etilgan formatlar
    $ext_allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if(!in_array($imageFileType, $ext_allowed)) {
        return ['success' => false, 'message' => "Faqat JPG, JPEG, PNG, GIF formatlari ruxsat etiladi."];
    }

    // Yangi unikal nom yaratish
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_path = $target_dir . $new_filename;

    if (move_uploaded_file($file["tmp_name"], $target_path)) {
        return ['success' => true, 'filename' => $new_filename];
    } else {
        return ['success' => false, 'message' => "Faylni yuklashda xatolik."];
    }
}

// Session tekshiruvi (Admin uchun)
function check_admin_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}

// URL generatsiya qilish
function base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $base_dir = dirname($_SERVER['SCRIPT_NAME']);
    // install.php papkasidan chiqish
    if (strpos($base_dir, 'admin') !== false) {
        $base_dir = dirname($base_dir);
    }
    return $protocol . $host . $base_dir . '/' . ltrim($path, '/');
}
?>
