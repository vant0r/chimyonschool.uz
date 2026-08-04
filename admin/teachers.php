<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — O'QITUVCHILAR BOSHQARUVI (admin/teachers.php)
 * ---------------------------------------------------------------------
 * O'qituvchilarni qo'shish, tahrirlash va o'chirish.
 * =====================================================================
 */
require_once __DIR__ . '/../config/config.php';

// Session tekshiruvi
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Sahifalash
$limit = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    $count_sql = "SELECT COUNT(*) FROM teachers";
    $total = (int) db()->query($count_sql)->fetchColumn();
    $total_pages = ceil($total / $limit);
    
    $sql = "SELECT * FROM teachers ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $stmt = db()->query($sql);
    $oqituvchilar = $stmt->fetchAll();
} catch (Throwable $ex) {
    $oqituvchilar = [];
    $total = 0;
    $total_pages = 0;
    $error = "Ma'lumotlarni yuklashda xatolik: " . $ex->getMessage();
}

// O'qituvchini o'chirish
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        // Rasmni ham o'chirish
        $stmt = db()->prepare("SELECT rasm FROM teachers WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $teacher = $stmt->fetch();
        
        if ($teacher && $teacher['rasm'] && file_exists(UPLOAD_DIR . $teacher['rasm'])) {
            unlink(UPLOAD_DIR . $teacher['rasm']);
        }
        
        $stmt = db()->prepare("DELETE FROM teachers WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        header('Location: teachers.php?deleted=1');
        exit;
    } catch (Throwable $ex) {
        $error = "O'chirishda xatolik: " . $ex->getMessage();
    }
}

$xabar_bildirish = '';
if (isset($_GET['deleted'])) $xabar_bildirish = "O'qituvchi o'chirildi!";
if (isset($_GET['created'])) $xabar_bildirish = "O'qituvchi qo'shildi!";
if (isset($_GET['updated'])) $xabar_bildirish = "O'qituvchi yangilandi!";

$page_title = "O'qituvchilar";
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?> — Chimyon School Admin</title>
    <style>
        :root{
            --dark:#17433F;--secondary:#558467;
            
            --gray-50:#f7f8fa;--gray-100:#eef1f5;--gray-300:#cbd2dc;--gray-500:#6b7688;--gray-700:#3a4355;
            --shadow-sm:0 4px 14px rgba(10,31,68,.08);--radius:14px;
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',system-ui,sans-serif;background:var(--gray-50);color:var(--gray-700)}
        
        .sidebar{position:fixed;left:0;top:0;bottom:0;width:260px;background:var(--dark);padding:24px 18px;z-index:100}
        .logo{display:flex;align-items:center;gap:12px;padding:12px 14px;margin-bottom:28px}
        .logo-mark{width:42px;height:42px;border-radius:11px;display:grid;place-items:center;background:linear-gradient(135deg,var(--primary),var(--accent));color:var(--dark);font-family:'Playfair Display',serif;font-weight:800;font-size:22px}
        .logo-txt b{font-family:'Playfair Display',serif;font-size:16px;color:#fff;display:block}
        .logo-txt span{font-size:10px;color:var(--accent);letter-spacing:.2em;text-transform:uppercase}
        
        .nav-menu a{display:flex;align-items:center;gap:12px;padding:12px 14px;color:rgba(255,255,255,.75);border-radius:10px;margin-bottom:6px;transition:.25s;font-size:14.5px}
        .nav-menu a:hover,.nav-menu a.active{background:rgba(255,255,255,.08);color:#fff}
        .nav-menu a svg{flex:0 0 18px}
        .logout{position:absolute;bottom:24px;left:18px;right:18px}
        .logout a{display:flex;align-items:center;gap:10px;padding:12px 14px;color:#ff9a9a;border-radius:10px;transition:.25s}
        
        .main{margin-left:260px;padding:32px}
        .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px}
        .header h1{font-size:26px;color:var(--dark)}
        
        .card{background:#fff;border-radius:var(--radius);padding:24px;box-shadow:var(--shadow-sm);margin-bottom:24px}
        
        .teachers-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:20px}
        .teacher-card{border:1px solid var(--gray-100);border-radius:12px;overflow:hidden;background:#fff;transition:.3s}
        .teacher-card:hover{box-shadow:0 8px 24px rgba(0,0,0,.1)}
        .teacher-img{width:100%;height:200px;object-fit:cover;background:#f0f0f0}
        .teacher-info{padding:16px}
        .teacher-name{font-size:16px;font-weight:700;color:var(--dark);margin-bottom:4px}
        .teacher-subject{font-size:13px;color:var(--primary);margin-bottom:8px}
        .teacher-desc{font-size:13px;color:var(--gray-500);line-height:1.5}
        
        .btn{padding:6px 12px;border:none;border-radius:6px;cursor:pointer;font-size:13px;text-decoration:none;display:inline-block}
        .btn-gold{background:var(--primary);color:var(--dark)}
        .btn-danger{background:#dc3545;color:#fff}
        .btn-add{background:var(--primary);color:var(--dark);padding:10px 20px;font-size:14px}
        
        .alert{padding:14px 16px;border-radius:12px;margin-bottom:20px;background:#e7f7ee;border:1px solid #c3eed3;color:#1c7a44}
        
        .pagination{display:flex;gap:8px;justify-content:center;margin-top:20px}
        .pagination a{padding:8px 14px;border:1px solid var(--gray-300);border-radius:6px;color:var(--gray-700);text-decoration:none}
        .pagination a.active{background:var(--primary);border-color:var(--primary);color:var(--dark)}
        
        .actions{display:flex;gap:8px;margin-top:12px}
        
        @media (max-width:900px){
            .sidebar{transform:translateX(-100%);transition:.3s}
            .sidebar.open{transform:translateX(0)}
            .main{margin-left:0}
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            <span class="logo-mark">C</span>
            <span class="logo-txt"><b>Chimyon</b><span>Admin</span></span>
        </div>
        
        <nav class="nav-menu">
            <a href="index.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="news.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l2 2v12a2 2 0 01-2 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                Yangiliklar
            </a>
            <a href="admissions.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Arizalar
            </a>
            <a href="messages.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Xabarlar
            </a>
            <a href="teachers.php" class="active">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2 M9 11a4 4 0 100-8 4 4 0 000 8z M23 21v-2a4 4 0 00-3-3.87 M16 3.13a4 4 0 010 7.75"/></svg>
                O'qituvchilar
            </a>
            <a href="settings.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                Sozlamalar
            </a>
            <a href="../index.php" target="_blank">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Saytni ko'rish
            </a>
        </nav>
        
        <div class="logout">
            <a href="logout.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Chiqish
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
        <div class="header">
            <h1>O'qituvchilar</h1>
            <a href="teacher_create.php" class="btn btn-add">+ Yangi O'qituvchi</a>
        </div>

        <?php if ($xabar_bildirish): ?>
            <div class="alert"><?= e($xabar_bildirish) ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert" style="background:#fee;border-color:#f5c2c2;color:#b02a2a"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="card">
            <?php if ($oqituvchilar): ?>
                <div class="teachers-grid">
                    <?php foreach ($oqituvchilar as $t): ?>
                        <div class="teacher-card">
                            <img src="<?= e(upload_url($t['rasm'], 'https://placehold.co/400x300/0a1f44/d4af37?text=Teacher')) ?>" alt="<?= e($t['ism_familiya']) ?>" class="teacher-img">
                            <div class="teacher-info">
                                <div class="teacher-name"><?= e($t['ism_familiya']) ?></div>
                                <div class="teacher-subject"><?= e($t['fan']) ?></div>
                                <div class="teacher-desc"><?= e(mb_substr($t['tajriba'], 0, 80)) ?><?= mb_strlen($t['tajriba']) > 80 ? '...' : '' ?></div>
                                <div class="actions">
                                    <a href="teacher_edit.php?id=<?= (int)$t['id'] ?>" class="btn btn-gold">Tahrirlash</a>
                                    <a href="?delete=<?= (int)$t['id'] ?>" class="btn btn-danger" onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">O'chirish</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p style="color:var(--gray-500)">Hozircha o'qituvchilar yo'q.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
