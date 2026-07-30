<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — QABUL / ARIZA (admission.php)
 * ---------------------------------------------------------------------
 * Ariza formasi: ism, tug'ilgan sana, sinf, telefon, hujjat (ixtiyoriy).
 * Xavfsizlik: CSRF token, server tomonida validatsiya, fayl tekshiruvi.
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$errors  = [];
$success = false;
$old     = ['ism_familiya' => '', 'tugilgan_sana' => '', 'sinf' => '', 'telefon' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF
    if (!csrf_check($_POST['csrf'] ?? null)) {
        $errors[] = 'Xavfsizlik tekshiruvi muvaffaqiyatsiz. Sahifani yangilab, qayta urinib ko\'ring.';
    }

    $old['ism_familiya']  = trim($_POST['ism_familiya'] ?? '');
    $old['tugilgan_sana'] = trim($_POST['tugilgan_sana'] ?? '');
    $old['sinf']          = trim($_POST['sinf'] ?? '');
    $old['telefon']       = trim($_POST['telefon'] ?? '');

    if (mb_strlen($old['ism_familiya']) < 3) {
        $errors[] = 'Ism va familiyani to\'liq kiriting.';
    }
    if ($old['telefon'] === '' || !preg_match('/^[0-9+\s\-()]{7,20}$/', $old['telefon'])) {
        $errors[] = 'To\'g\'ri telefon raqamini kiriting.';
    }
    if ($old['sinf'] === '') {
        $errors[] = 'Sinfni tanlang.';
    }

    // Hujjat fayli (ixtiyoriy)
    $savedFile = null;
    if (!empty($_FILES['hujjat']['name']) && $_FILES['hujjat']['error'] !== UPLOAD_ERR_NO_FILE) {
        $f = $_FILES['hujjat'];
        if ($f['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Faylni yuklashda xatolik yuz berdi.';
        } elseif ($f['size'] > 5 * 1024 * 1024) {
            $errors[] = 'Fayl hajmi 5 MB dan oshmasligi kerak.';
        } else {
            $allowed = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime  = $finfo->file($f['tmp_name']);
            if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) {
                $errors[] = 'Faqat PDF, JPG yoki PNG formatidagi hujjat yuklang.';
            } else {
                if (!is_dir(UPLOAD_DIR)) @mkdir(UPLOAD_DIR, 0755, true);
                $savedFile = 'ariza_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                if (!move_uploaded_file($f['tmp_name'], UPLOAD_DIR . $savedFile)) {
                    $errors[] = 'Faylni saqlab bo\'lmadi.';
                    $savedFile = null;
                }
            }
        }
    }

    if (!$errors) {
        try {
            $stmt = db()->prepare(
                "INSERT INTO admissions (ism_familiya, tugilgan_sana, sinf, telefon, hujjat_fayl, holat)
                 VALUES (?, ?, ?, ?, ?, 'yangi')"
            );
            $stmt->execute([
                $old['ism_familiya'],
                $old['tugilgan_sana'] ?: null,
                $old['sinf'],
                $old['telefon'],
                $savedFile,
            ]);
            $success = true;
            $old = ['ism_familiya' => '', 'tugilgan_sana' => '', 'sinf' => '', 'telefon' => ''];
        } catch (Throwable $ex) {
            $errors[] = 'Arizani saqlab bo\'lmadi. Iltimos, keyinroq urinib ko\'ring.';
        }
    }
}

$page_title = 'Qabul / Ariza';
$page_desc  = 'Chimyon School qabuliga onlayn ariza qoldiring — mutaxassislarimiz siz bilan bog\'lanadi.';
$active     = '';
require __DIR__ . '/includes/header.php';
?>
<style>
.adm-wrap{display:grid;grid-template-columns:1fr 1.1fr;gap:56px;align-items:start}
.adm-info .eyebrow{margin-bottom:14px}
.adm-info h2{font-size:clamp(26px,3.5vw,38px);color:var(--navy-800);margin-bottom:16px}
.adm-info p{color:var(--gray-700);margin-bottom:26px}
.steps{margin-top:10px}
.step{display:flex;gap:16px;margin-bottom:22px}
.step .n{flex:0 0 42px;width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,var(--navy-800),var(--navy-600));color:var(--gold-400);display:grid;place-items:center;font-family:'Playfair Display',serif;font-weight:700}
.step h4{font-size:16px;color:var(--navy-800);margin-bottom:2px}
.step p{font-size:14px;color:var(--gray-500);margin:0}
.adm-form{background:#fff;border-radius:var(--radius);padding:38px;box-shadow:var(--shadow-md);border:1px solid var(--gray-100)}
.field{margin-bottom:20px}
.field label{display:block;font-size:14px;font-weight:600;color:var(--navy-800);margin-bottom:8px}
.field input,.field select{width:100%;padding:14px 16px;border:1.5px solid var(--gray-300);border-radius:12px;font-size:15px;font-family:'Inter';color:var(--ink);transition:.25s;background:#fff}
.field input:focus,.field select:focus{outline:none;border-color:var(--gold-500);box-shadow:0 0 0 4px rgba(212,175,55,.15)}
.field .file{padding:13px 16px;border:1.5px dashed var(--gray-300);border-radius:12px;font-size:14px;color:var(--gray-500);cursor:pointer;display:block}
.field .hint{font-size:12.5px;color:var(--gray-500);margin-top:6px}
.alert{padding:16px 18px;border-radius:12px;margin-bottom:22px;font-size:14.5px}
.alert-ok{background:#e7f7ee;border:1px solid #b6e6c9;color:#1c7a44}
.alert-err{background:#fdeaea;border:1px solid #f5c2c2;color:#b02a2a}
.alert-err ul{margin:6px 0 0;padding-left:18px;list-style:disc}
.adm-form .btn{width:100%;margin-top:6px}
@media (max-width:900px){.adm-wrap{grid-template-columns:1fr;gap:36px}.adm-form{padding:28px}}
</style>

<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Qabulga ariza qoldirish</h1>
        <p data-aos="fade-up" data-aos-delay="100">Formani to'ldiring — qabul bo'limi mutaxassisi eng qisqa vaqtda siz bilan bog'lanadi.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; Qabul</div>
    </div>
</header>

<section class="section">
    <div class="container">
        <div class="adm-wrap">
            <!-- LEFT: info + steps -->
            <div class="adm-info" data-aos="fade-right">
                <span class="eyebrow">Qabul jarayoni</span>
                <h2>Bor-yo'g'i 4 qadam</h2>
                <p>Farzandingizni Chimyon School'ga yozdirish oson. Ariza qoldiring — qolganini biz uddalaymiz.</p>
                <div class="steps">
                    <?php
                    $steps = [
                        ['1', 'Ariza qoldiring', 'Ushbu formani to\'ldiring yoki bizga qo\'ng\'iroq qiling.'],
                        ['2', 'Bog\'lanish', 'Mutaxassisimiz siz bilan bog\'lanib, uchrashuv belgilaydi.'],
                        ['3', 'Suhbat va tanishuv', 'Maktab bilan tanishasiz va savollaringizga javob olasiz.'],
                        ['4', 'Ro\'yxatdan o\'tish', 'Hujjatlar rasmiylashtiriladi va o\'quvchi qabul qilinadi.'],
                    ];
                    foreach ($steps as $s): ?>
                        <div class="step">
                            <div class="n"><?= e($s[0]) ?></div>
                            <div><h4><?= e($s[1]) ?></h4><p><?= e($s[2]) ?></p></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- RIGHT: form -->
            <div class="adm-form" data-aos="fade-left">
                <?php if ($success): ?>
                    <div class="alert alert-ok">
                        <b>Rahmat!</b> Arizangiz muvaffaqiyatli qabul qilindi. Tez orada siz bilan bog'lanamiz.
                    </div>
                <?php endif; ?>
                <?php if ($errors): ?>
                    <div class="alert alert-err">
                        <b>Iltimos, quyidagilarni to'g'rilang:</b>
                        <ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

                    <div class="field">
                        <label for="ism">O'quvchi ism-familiyasi *</label>
                        <input type="text" id="ism" name="ism_familiya" value="<?= e($old['ism_familiya']) ?>" placeholder="Masalan: Ali Valiyev" required>
                    </div>

                    <div class="field">
                        <label for="tug">Tug'ilgan sana</label>
                        <input type="date" id="tug" name="tugilgan_sana" value="<?= e($old['tugilgan_sana']) ?>">
                    </div>

                    <div class="field">
                        <label for="sinf">Qaysi sinfga *</label>
                        <select id="sinf" name="sinf" required>
                            <option value="">— Sinfni tanlang —</option>
                            <?php for ($c = 1; $c <= 11; $c++): ?>
                                <option value="<?= $c ?>-sinf" <?= $old['sinf'] === "$c-sinf" ? 'selected' : '' ?>><?= $c ?>-sinf</option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="tel">Telefon raqamingiz *</label>
                        <input type="tel" id="tel" name="telefon" value="<?= e($old['telefon']) ?>" placeholder="+998 90 123 45 67" required>
                    </div>

                    <div class="field">
                        <label for="hujjat">Hujjat (ixtiyoriy)</label>
                        <input type="file" id="hujjat" name="hujjat" class="file" accept=".pdf,.jpg,.jpeg,.png">
                        <span class="hint">Tug'ilganlik guvohnomasi yoki tabel. PDF/JPG/PNG, 5 MB gacha.</span>
                    </div>

                    <button type="submit" class="btn btn-gold">Arizani yuborish</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
