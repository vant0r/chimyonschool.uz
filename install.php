<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — O'RNATISH (install.php)
 * ---------------------------------------------------------------------
 * Brauzerda bir marta oching:  https://sayt.uz/install.php
 * Bu skript:
 *   1) sql/schema.sql ni ishga tushiradi (jadvallar + namuna ma'lumot);
 *   2) standart admin foydalanuvchini bcrypt bilan yaratadi.
 * O'rnatib bo'lgach, ushbu faylni serverdan O'CHIRING!
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

$log = [];
$err = null;

try {
    // --- 1. Sxemani bo'laklarga ajratib ishga tushirish ---
    $sql = file_get_contents(__DIR__ . '/sql/schema.sql');
    if ($sql === false) {
        throw new RuntimeException('sql/schema.sql fayli topilmadi.');
    }

    // "USE `db`" va "CREATE DATABASE" qatorlarini olib tashlaymiz —
    // MB config.php'da allaqachon tanlangan.
    $pdo = db();
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $stmt) {
        if ($stmt === '' || str_starts_with($stmt, '--')) {
            continue;
        }
        // CREATE DATABASE / USE ni o'tkazib yuboramiz
        if (preg_match('/^(CREATE\s+DATABASE|USE)\b/i', $stmt)) {
            continue;
        }
        $pdo->exec($stmt);
    }
    $log[] = 'Jadvallar va namuna ma\'lumotlar muvaffaqiyatli yaratildi.';

    // --- 2. Standart adminni yaratish ---
    $login  = 'admin';
    $parol  = 'admin12345';
    $hash   = password_hash($parol, PASSWORD_DEFAULT);

    $exists = $pdo->prepare('SELECT id FROM admin WHERE login = ?');
    $exists->execute([$login]);
    if ($exists->fetch()) {
        $log[] = 'Admin allaqachon mavjud — o\'zgartirilmadi.';
    } else {
        $ins = $pdo->prepare('INSERT INTO admin (login, parol_hash) VALUES (?, ?)');
        $ins->execute([$login, $hash]);
        $log[] = 'Standart admin yaratildi (login: admin, parol: admin12345).';
    }
} catch (Throwable $ex) {
    $err = $ex->getMessage();
}
?>
<!doctype html>
<html lang="uz">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>O'rnatish — Chimyon School</title>
<style>
  body{font-family:system-ui,Segoe UI,Roboto,sans-serif;background:#0a1f44;color:#e8eefb;margin:0;min-height:100vh;display:grid;place-items:center;padding:24px}
  .box{background:#0f274f;border:1px solid rgba(212,175,55,.35);border-radius:18px;max-width:560px;width:100%;padding:36px;box-shadow:0 30px 60px rgba(0,0,0,.4)}
  h1{margin:0 0 6px;font-size:24px;color:#f2dfa0}
  p.sub{margin:0 0 22px;color:#9fb2d6;font-size:14px}
  .item{display:flex;gap:10px;align-items:flex-start;background:rgba(255,255,255,.04);border-radius:10px;padding:12px 14px;margin-bottom:10px;font-size:14.5px}
  .ok{color:#7ee0a8}.bad{color:#ff9a9a}
  .warn{margin-top:20px;background:rgba(212,175,55,.12);border:1px solid rgba(212,175,55,.4);border-radius:10px;padding:14px 16px;font-size:14px;color:#f2dfa0}
  a.btn{display:inline-block;margin-top:22px;background:#d4af37;color:#0a1f44;text-decoration:none;font-weight:700;padding:12px 22px;border-radius:10px}
  code{background:rgba(0,0,0,.3);padding:2px 6px;border-radius:5px}
</style>
</head>
<body>
  <div class="box">
    <h1>Chimyon School — O'rnatish</h1>
    <p class="sub">Ma'lumotlar bazasini tayyorlash natijasi</p>

    <?php if ($err): ?>
      <div class="item bad">Xatolik: <?= e($err) ?></div>
      <p class="sub" style="margin-top:16px">config/config.php dagi MB ma'lumotlarini tekshiring va sahifani yangilang.</p>
    <?php else: ?>
      <?php foreach ($log as $line): ?>
        <div class="item ok">&#10003; <?= e($line) ?></div>
      <?php endforeach; ?>
      <div class="warn">
        <b>Xavfsizlik:</b> O'rnatish tugadi. Endi ushbu <code>install.php</code> faylini serverdan
        <b>o'chirib tashlang</b> va admin panelga kirib parolni o'zgartiring.
      </div>
      <a class="btn" href="admin/login.php">Admin panelga kirish &rarr;</a>
    <?php endif; ?>
  </div>
</body>
</html>
