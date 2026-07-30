<?php
// Umumiy funksiyalar

// Sozlamalarni olish
function getSettings($pdo) {
    $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
    $settings = $stmt->fetch();
    if (!$settings) {
        return [
            'telefon' => '+998 71 200 00 00',
            'email' => 'info@chimyonschool.uz',
            'manzil' => 'Chimyon sh., Maktab ko\'chasi 1',
            'ish_vaqti' => 'Dush-Shan: 8:00 - 18:00',
            'telegram' => '',
            'instagram' => ''
        ];
    }
    return $settings;
}

// Yangiliklarni olish
function getNews($pdo, $limit = 3, $offset = 0, $status = 'published') {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE holat = ? ORDER BY sana DESC LIMIT ? OFFSET ?");
    $stmt->execute([$status, $limit, $offset]);
    return $stmt->fetchAll();
}

// Bitta yangilikni olish
function getNewsById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// O'qituvchilarni olish
function getTeachers($pdo, $limit = null) {
    $sql = "SELECT * FROM teachers ORDER BY id DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Galereyani olish
function getGallery($pdo, $limit = null, $category = null) {
    $sql = "SELECT * FROM gallery";
    $params = [];
    if ($category) {
        $sql .= " WHERE kategoriya = ?";
        $params[] = $category;
    }
    $sql .= " ORDER BY id DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Arizalarni olish
function getAdmissions($pdo, $limit = null, $status = null) {
    $sql = "SELECT * FROM admissions";
    $params = [];
    if ($status) {
        $sql .= " WHERE holat = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY sana DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Sahifa kontentini olish
function getPageBySlug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

// Statistika uchun
function getCount($pdo, $table, $where = '', $params = []) {
    $sql = "SELECT COUNT(*) as count FROM $table";
    if ($where) {
        $sql .= " WHERE $where";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result['count'];
}

// Fayl yuklash funksiyasi
function uploadFile($file, $targetDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'], $maxSize = 5242880) {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'message' => 'Fayl tanlanmagan'];
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Yuklashda xatolik'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => 'Fayl hajmi katta'];
    }
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedTypes)) {
        return ['success' => false, 'message' => 'Noto\'g\'ri fayl turi'];
    }
    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    $newName = uniqid() . '.' . $ext;
    $targetPath = $targetDir . '/' . $newName;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $newName];
    }
    
    return ['success' => false, 'message' => 'Yuklash muvaffaqiyatsiz'];
}

// CSRF token yaratish
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// CSRF token tekshirish
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Admin login tekshirish
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']) && $_SESSION['admin_logged_in'] === true;
}

// Login qilish
function loginAdmin($pdo, $login, $password) {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE login = ?");
    $stmt->execute([$login]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['parol_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_login'] = $admin['login'];
        $_SESSION['admin_logged_in'] = true;
        return true;
    }
    return false;
}

// Logout qilish
function logoutAdmin() {
    session_unset();
    session_destroy();
}
?>
