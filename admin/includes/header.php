<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — ADMIN HEADER
 * Apple-Inspired Premium Design
 * =====================================================================
 */
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
$active_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Chimyon School</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
    <?php include __DIR__ . '/../../assets/css/admin-style.css'; ?>
    </style>
</head>
<body>
    <nav class="admin-nav">
        <div class="admin-nav-container">
            <a href="dashboard.php" class="admin-logo">
                <span class="admin-logo-mark">C</span>
                <span>Chimyon Admin</span>
            </a>
            
            <div class="admin-nav-links">
                <a href="dashboard.php" class="<?= $active_page === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="news.php" class="<?= $active_page === 'news' || $active_page === 'news_create' || $active_page === 'news_edit' ? 'active' : '' ?>">Yangiliklar</a>
                <a href="admissions.php" class="<?= $active_page === 'admissions' ? 'active' : '' ?>">Qabul</a>
                <a href="messages.php" class="<?= $active_page === 'messages' ? 'active' : '' ?>">Xabarlar</a>
                <a href="teachers.php" class="<?= $active_page === 'teachers' || $active_page === 'teacher_create' || $active_page === 'teacher_edit' ? 'active' : '' ?>">O'qituvchilar</a>
                <a href="gallery.php" class="<?= $active_page === 'gallery' ? 'active' : '' ?>">Galereya</a>
                <a href="settings.php" class="<?= $active_page === 'settings' ? 'active' : '' ?>">Sozlamalar</a>
            </div>
            
            <div class="admin-nav-actions">
                <a href="../index.php" target="_blank">Saytni ko'rish</a>
                <a href="logout.php" class="logout-btn">Chiqish</a>
            </div>
        </div>
    </nav>
    
    <main class="admin-content">