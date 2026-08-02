<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — ADMIN DASHBOARD (admin/index.php)
 * ---------------------------------------------------------------------
 * Admin panel bosh sahifasi. Statistikalar va tezkor havolalar.
 * =====================================================================
 */
require_once __DIR__ . '/../config/config.php';

// Session tekshiruvi
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Statistika
try {
    $stats = [
        'news' => (int) db()->query("SELECT COUNT(*) FROM news")->fetchColumn(),
        'admissions' => (int) db()->query("SELECT COUNT(*) FROM admissions")->fetchColumn(),
        'messages' => (int) db()->query("SELECT COUNT(*) FROM messages WHERE oqilgan=0")->fetchColumn(),
        'teachers' => (int) db()->query("SELECT COUNT(*) FROM teachers")->fetchColumn(),
    ];
    
    // Oxirgi arizalar
    $stmt = db()->query("SELECT * FROM admissions ORDER BY sana DESC LIMIT 5");
    $recentAdmissions = $stmt->fetchAll();
    
    // Oxirgi xabarlar
    $stmt = db()->query("SELECT * FROM messages ORDER BY sana DESC LIMIT 5");
    $recentMessages = $stmt->fetchAll();
} catch (Throwable $ex) {
    $stats = ['news'=>0,'admissions'=>0,'messages'=>0,'teachers'=>0];
    $recentAdmissions = [];
    $recentMessages = [];
}

$page_title = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?> — Chimyon School Admin</title>
    <style>
        :root{
            --navy-900:#061530;--navy-800:#0a1f44;--navy-700:#102a5c;--navy-600:#1a3a73;
            --gold-500:#d4af37;--gold-400:#e6c765;--gold-300:#f2dfa0;
            --gray-50:#f7f8fa;--gray-100:#eef1f5;--gray-300:#cbd2dc;--gray-500:#6b7688;--gray-700:#3a4355;
            --shadow-sm:0 4px 14px rgba(10,31,68,.08);--shadow-md:0 14px 40px rgba(10,31,68,.14);
            --radius:14px;
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',system-ui,sans-serif;background:var(--gray-50);color:var(--gray-700)}
        
        /* Sidebar */
        .sidebar{position:fixed;left:0;top:0;bottom:0;width:260px;background:var(--navy-900);padding:24px 18px;z-index:100}
        .logo{display:flex;align-items:center;gap:12px;padding:12px 14px;margin-bottom:28px}
        .logo-mark{width:42px;height:42px;border-radius:11px;display:grid;place-items:center;background:linear-gradient(135deg,var(--gold-500),var(--gold-300));color:var(--navy-900);font-family:'Playfair Display',serif;font-weight:800;font-size:22px}
        .logo-txt b{font-family:'Playfair Display',serif;font-size:16px;color:#fff;display:block}
        .logo-txt span{font-size:10px;color:var(--gold-300);letter-spacing:.2em;text-transform:uppercase}
        
        .nav-menu a{display:flex;align-items:center;gap:12px;padding:12px 14px;color:rgba(255,255,255,.75);border-radius:10px;margin-bottom:6px;transition:.25s;font-size:14.5px}
        .nav-menu a:hover,.nav-menu a.active{background:rgba(255,255,255,.08);color:#fff}
        .nav-menu a svg{flex:0 0 18px}
        .nav-menu .badge{margin-left:auto;background:var(--gold-500);color:var(--navy-900);font-size:11px;font-weight:700;padding:2px 8px;border-radius:6px}
        
        .logout{position:absolute;bottom:24px;left:18px;right:18px}
        .logout a{display:flex;align-items:center;gap:10px;padding:12px 14px;color:#ff9a9a;border-radius:10px;transition:.25s}
        .logout a:hover{background:rgba(255,154,154,.1)}
        
        /* Main */
        .main{margin-left:260px;padding:32px}
        .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px}
        .header h1{font-size:26px;color:var(--navy-800)}
        .user-info{display:flex;align-items:center;gap:12px}
        .user-avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--gold-500),var(--gold-300));display:grid;place-items:center;color:var(--navy-900);font-weight:700;font-family:'Playfair Display',serif}
        
        /* Stats */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;margin-bottom:32px}
        .stat-card{background:#fff;border-radius:var(--radius);padding:24px;box-shadow:var(--shadow-sm)}
        .stat-card .ico{width:48px;height:48px;border-radius:12px;display:grid;place-items:center;background:var(--cream);color:var(--gold-500);margin-bottom:14px}
        .stat-card .num{font-size:28px;font-weight:800;color:var(--navy-800)}
        .stat-card .lbl{font-size:13.5px;color:var(--gray-500)}
        
        /* Tables */
        .card{background:#fff;border-radius:var(--radius);padding:24px;box-shadow:var(--shadow-sm);margin-bottom:24px}
        .card h3{font-size:18px;color:var(--navy-800);margin-bottom:18px}
        table{width:100%;border-collapse:collapse}
        th,td{padding:12px 14px;text-align:left;border-bottom:1px solid var(--gray-100);font-size:14px}
        th{color:var(--gray-500);font-weight:600;font-size:13px}
        tr:last-child td{border-bottom:none}
        .status{padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600}
        .status-new{background:#e7f7ee;color:#1c7a44}
        .status-view{background:#fff4e6;color:#b56a00}
        
        @media (max-width:900px){
            .sidebar{transform:translateX(-100%);transition:.3s}
            .sidebar.open{transform:translateX(0)}
            .main{margin-left:0}
            .stats-grid{grid-template-columns:1fr 1fr}
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
            <a href="index.php" class="active">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="news.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l2 2v12a2 2 0 01-2 2z"/><path d="M12 11v4M12 17h.01"/></svg>
                Yangiliklar
            </a>
            <a href="admissions.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Arizalar
            </a>
            <a href="messages.php">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Xabarlar
                <?php if ($stats['messages'] > 0): ?><span class="badge"><?= $stats['messages'] ?></span><?php endif; ?>
            </a>
            <a href="teachers.php">
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
            <h1>Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar"><?= mb_strtoupper(mb_substr($_SESSION['admin_login'], 0, 1)) ?></div>
                <span><?= e($_SESSION['admin_login']) ?></span>
            </div>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l2 2v12a2 2 0 01-2 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div class="num"><?= $stats['news'] ?></div>
                <div class="lbl">Yangiliklar</div>
            </div>
            <div class="stat-card">
                <div class="ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div class="num"><?= $stats['admissions'] ?></div>
                <div class="lbl">Arizalar</div>
            </div>
            <div class="stat-card">
                <div class="ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                </div>
                <div class="num"><?= $stats['messages'] ?></div>
                <div class="lbl">O'qilmagan xabarlar</div>
            </div>
            <div class="stat-card">
                <div class="ico">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2 M9 11a4 4 0 100-8 4 4 0 000 8z M23 21v-2a4 4 0 00-3-3.87 M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div class="num"><?= $stats['teachers'] ?></div>
                <div class="lbl">O'qituvchilar</div>
            </div>
        </div>

        <!-- RECENT ADMISSIONS -->
        <div class="card">
            <h3>Oxirgi arizalar</h3>
            <?php if ($recentAdmissions): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Ism-familiya</th>
                            <th>Sinf</th>
                            <th>Telefon</th>
                            <th>Holati</th>
                            <th>Sana</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentAdmissions as $a): ?>
                            <tr>
                                <td><?= e($a['ism_familiya']) ?></td>
                                <td><?= e($a['sinf']) ?></td>
                                <td><?= e($a['telefon']) ?></td>
                                <td><span class="status status-new"><?= e($a['holat']) ?></span></td>
                                <td><?= date('d.m.Y H:i', strtotime($a['sana'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color:var(--gray-500)">Hozircha arizalar yo'q.</p>
            <?php endif; ?>
        </div>

        <!-- RECENT MESSAGES -->
        <div class="card">
            <h3>Oxirgi xabarlar</h3>
            <?php if ($recentMessages): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Ism</th>
                            <th>Aloqa</th>
                            <th>Xabar</th>
                            <th>Sana</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentMessages as $m): ?>
                            <tr>
                                <td><?= e($m['ism']) ?></td>
                                <td><?= e($m['aloqa']) ?></td>
                                <td><?= e(mb_substr($m['xabar'], 0, 50)) ?>...</td>
                                <td><?= date('d.m.Y H:i', strtotime($m['sana'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color:var(--gray-500)">Hozircha xabarlar yo'q.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
