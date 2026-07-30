<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — ALOQA (contact.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$S       = get_settings();
$errors  = [];
$success = false;
$old     = ['ism' => '', 'aloqa' => '', 'xabar' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf'] ?? null)) {
        $errors[] = 'Xavfsizlik tekshiruvi muvaffaqiyatsiz. Sahifani yangilang.';
    }
    $old['ism']   = trim($_POST['ism'] ?? '');
    $old['aloqa'] = trim($_POST['aloqa'] ?? '');
    $old['xabar'] = trim($_POST['xabar'] ?? '');

    if (mb_strlen($old['ism']) < 2)   $errors[] = 'Ismingizni kiriting.';
    if ($old['aloqa'] === '')          $errors[] = 'Telefon yoki email kiriting.';
    if (mb_strlen($old['xabar']) < 5)  $errors[] = 'Xabar matnini kiriting.';

    if (!$errors) {
        try {
            $stmt = db()->prepare("INSERT INTO messages (ism, aloqa, xabar) VALUES (?, ?, ?)");
            $stmt->execute([$old['ism'], $old['aloqa'], $old['xabar']]);
            $success = true;
            $old = ['ism' => '', 'aloqa' => '', 'xabar' => ''];
        } catch (Throwable $ex) {
            $errors[] = 'Xabar yuborilmadi. Iltimos, keyinroq urinib ko\'ring.';
        }
    }
}

$lat = (float)($S['xarita_lat'] ?? 40.0333);
$lng = (float)($S['xarita_lng'] ?? 71.7167);
$d   = 0.01; // xarita ko'rinish maydoni
$bbox = ($lng - $d) . '%2C' . ($lat - $d) . '%2C' . ($lng + $d) . '%2C' . ($lat + $d);

$page_title = 'Aloqa';
$page_desc  = 'Chimyon School bilan bog\'laning — manzil, telefon, email va onlayn xabar formasi.';
$active     = 'contact';
require __DIR__ . '/includes/header.php';
?>
<style>
.contact-grid{display:grid;grid-template-columns:1fr 1.2fr;gap:52px;align-items:start}
.info-card{display:flex;gap:16px;align-items:flex-start;background:#fff;border:1px solid var(--gray-100);border-radius:14px;padding:22px;box-shadow:var(--shadow-sm);margin-bottom:16px}
.info-card .ico{flex:0 0 48px;width:48px;height:48px;border-radius:12px;display:grid;place-items:center;background:linear-gradient(135deg,var(--navy-800),var(--navy-600));color:var(--gold-400)}
.info-card h4{font-size:15px;color:var(--navy-800);margin-bottom:3px}
.info-card p,.info-card a{color:var(--gray-600);font-size:14.5px}
.info-card a:hover{color:var(--gold-500)}
.c-form{background:#fff;border-radius:var(--radius);padding:38px;box-shadow:var(--shadow-md);border:1px solid var(--gray-100)}
.field{margin-bottom:20px}
.field label{display:block;font-size:14px;font-weight:600;color:var(--navy-800);margin-bottom:8px}
.field input,.field textarea{width:100%;padding:14px 16px;border:1.5px solid var(--gray-300);border-radius:12px;font-size:15px;font-family:'Inter';color:var(--ink);transition:.25s}
.field textarea{resize:vertical;min-height:130px}
.field input:focus,.field textarea:focus{outline:none;border-color:var(--gold-500);box-shadow:0 0 0 4px rgba(212,175,55,.15)}
.c-form .btn{width:100%}
.alert{padding:16px 18px;border-radius:12px;margin-bottom:22px;font-size:14.5px}
.alert-ok{background:#e7f7ee;border:1px solid #b6e6c9;color:#1c7a44}
.alert-err{background:#fdeaea;border:1px solid #f5c2c2;color:#b02a2a}
.alert-err ul{margin:6px 0 0;padding-left:18px;list-style:disc}
.map-wrap{margin-top:0}
.map-wrap iframe{width:100%;height:420px;border:0;border-radius:var(--radius);box-shadow:var(--shadow-sm)}
@media (max-width:900px){.contact-grid{grid-template-columns:1fr;gap:36px}.c-form{padding:28px}}
</style>

<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Biz bilan bog'laning</h1>
        <p data-aos="fade-up" data-aos-delay="100">Savollaringiz bormi? Qo'ng'iroq qiling, yozing yoki tashrif buyuring — biz doim ochiqmiz.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; Aloqa</div>
    </div>
</header>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <!-- LEFT: info -->
            <div data-aos="fade-right">
                <div class="info-card">
                    <div class="ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                    <div><h4>Manzil</h4><p><?= e($S['manzil'] ?? 'Farg\'ona viloyati, Chimyon tumani') ?></p></div>
                </div>
                <div class="info-card">
                    <div class="ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.13.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0122 16.92z"/></svg></div>
                    <div><h4>Telefon</h4><a href="tel:<?= e(str_replace(' ', '', $S['telefon'] ?? '')) ?>"><?= e($S['telefon'] ?? '') ?></a></div>
                </div>
                <div class="info-card">
                    <div class="ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 6L2 7"/></svg></div>
                    <div><h4>Email</h4><a href="mailto:<?= e($S['email'] ?? '') ?>"><?= e($S['email'] ?? '') ?></a></div>
                </div>
                <div class="info-card">
                    <div class="ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div>
                    <div><h4>Ish vaqti</h4><p><?= e($S['ish_vaqti'] ?? '') ?></p></div>
                </div>
            </div>

            <!-- RIGHT: form -->
            <div class="c-form" data-aos="fade-left">
                <?php if ($success): ?>
                    <div class="alert alert-ok"><b>Rahmat!</b> Xabaringiz yuborildi. Tez orada javob beramiz.</div>
                <?php endif; ?>
                <?php if ($errors): ?>
                    <div class="alert alert-err"><b>Xatolik:</b><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
                <?php endif; ?>
                <form method="post" novalidate>
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <div class="field">
                        <label for="ism">Ismingiz *</label>
                        <input type="text" id="ism" name="ism" value="<?= e($old['ism']) ?>" placeholder="Ism-familiya" required>
                    </div>
                    <div class="field">
                        <label for="aloqa">Telefon yoki email *</label>
                        <input type="text" id="aloqa" name="aloqa" value="<?= e($old['aloqa']) ?>" placeholder="+998 90 123 45 67 yoki email" required>
                    </div>
                    <div class="field">
                        <label for="xabar">Xabaringiz *</label>
                        <textarea id="xabar" name="xabar" placeholder="Savol yoki taklifingizni yozing..." required><?= e($old['xabar']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-gold">Xabarni yuborish</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- MAP -->
<section class="section" style="padding-top:0">
    <div class="container">
        <div class="map-wrap" data-aos="fade-up">
            <iframe
                title="Chimyon School joylashuvi"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.openstreetmap.org/export/embed.html?bbox=<?= e($lng) ?>%2C<?= e($lat) ?>%2C<?= e($lng) ?>%2C<?= e($lat) ?>&layer=mapnik&marker=<?= e($lat) ?>%2C<?= e($lng) ?>">
            </iframe>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
