<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — ADMIN LOGIN (admin/login.php)
 * ---------------------------------------------------------------------
 * Admin panelga kirish sahifasi. Session boshqaruvi va xavfsiz parol tekshiruvi.
 * =====================================================================
 */
require_once __DIR__ . '/../config/config.php';

// Agar allaqachon kirgan bo'lsa — dashboardga yo'naltirish
if (session_status() === PHP_SESSION_NONE) session_start();

// CSRF Token generatsiya qilish
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$errors = [];
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF tekshiruvi
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = 'Xavfsizlik tokeni noto\'g\'ri. Iltimos, qayta urinib ko\'ring.';
    } else {
        $login = trim($_POST['login'] ?? '');
        $parol = $_POST['parol'] ?? '';

        if ($login === '' || $parol === '') {
            $errors[] = 'Login va parolni kiriting.';
        } else {
            try {
                $stmt = db()->prepare('SELECT id, login, parol_hash FROM admin WHERE login = ? LIMIT 1');
                $stmt->execute([$login]);
                $user = $stmt->fetch();

                if ($user && password_verify($parol, $user['parol_hash'])) {
                    // Muvaffaqiyatli kirish
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_login'] = $user['login'];
                    header('Location: index.php');
                    exit;
                } else {
                    $errors[] = 'Login yoki parol noto\'g\'ri.';
                }
            } catch (Throwable $ex) {
                $errors[] = 'Tizimda xatolik yuz berdi. Iltimos, keyinroq urinib ko\'ring.';
            }
        }
    }
}

$page_title = 'Admin kirish';
$active = '';
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?> — Chimyon School</title>
    <style>
        :root{
            --primary:#408175;--primary-dark:#17433F;
            --bg:#F9FAFB;--text:#1F2937;
            --gray-100:#eef1f5;--gray-300:#cbd2dc;--gray-500:#6b7688;
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',system-ui,sans-serif;background:linear-gradient(135deg,var(--primary-dark),#2d5a54);min-height:100vh;display:grid;place-items:center;padding:24px}
        .box{background:#fff;border-radius:18px;max-width:420px;width:100%;padding:42px;box-shadow:0 30px 60px rgba(0,0,0,.3);animation:fadeInUp 0.6s cubic-bezier(0.16,1,0.3,1)}
        .logo{display:flex;align-items:center;gap:12px;margin-bottom:28px}
        .logo-mark{width:48px;height:48px;border-radius:12px;display:grid;place-items:center;background:linear-gradient(135deg,var(--primary),#558467);color:#fff;font-family:'Playfair Display',serif;font-weight:800;font-size:26px}
        .logo-txt b{font-family:'Playfair Display',serif;font-size:20px;color:var(--primary-dark)}
        .logo-txt span{font-size:12px;color:var(--gray-500);letter-spacing:.2em;text-transform:uppercase}
        h1{font-size:24px;color:var(--primary-dark);margin-bottom:8px}
        p.sub{color:var(--gray-500);font-size:14px;margin-bottom:26px}
        .field{margin-bottom:18px}
        .field label{display:block;font-size:14px;font-weight:600;color:var(--primary-dark);margin-bottom:8px}
        .field input{width:100%;padding:14px 16px;border:1.5px solid var(--gray-300);border-radius:12px;font-size:15px;transition:.25s}
        .field input:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 4px rgba(64,129,117,.15)}
        .btn{width:100%;padding:15px;background:var(--primary);color:#fff;border:none;border-radius:12px;font-weight:700;font-size:15px;cursor:pointer;transition:.3s}
        .btn:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(64,129,117,.35)}
        .alert{padding:14px 16px;border-radius:12px;margin-bottom:20px;font-size:14px;background:#fdeaea;border:1px solid #f5c2c2;color:#b02a2a}
        .alert ul{margin:6px 0 0;padding-left:18px;list-style:disc}
        .back{display:block;text-align:center;margin-top:22px;font-size:14px;color:var(--gray-500)}
        .back a{color:var(--primary)}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">
            <span class="logo-mark">C</span>
            <span class="logo-txt"><b>Chimyon School</b><span>Admin panel</span></span>
        </div>
        <h1>Kirish</h1>
        <p class="sub">Admin panelga kirish uchun ma'lumotlaringizni kiriting</p>

        <?php if ($errors): ?>
            <div class="alert">
                <b>Xatolik:</b>
                <ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <form method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="field">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" value="<?= e($login) ?>" placeholder="admin" required autofocus autocomplete="username">
            </div>
            <div class="field">
                <label for="parol">Parol</label>
                <input type="password" id="parol" name="parol" placeholder="••••••••" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn">Kirish</button>
        </form>

        <p class="back"><a href="../index.php">&larr; Saytga qaytish</a></p>
    </div>
</body>
</html>
