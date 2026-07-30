<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — O'QITUVCHILAR (teachers.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

try {
    $teachers = db()->query("SELECT * FROM teachers ORDER BY tartib ASC, id ASC")->fetchAll();
} catch (Throwable $ex) {
    $teachers = [];
}

$page_title = 'O\'qituvchilar';
$page_desc  = 'Chimyon School tajribali va malakali o\'qituvchilar jamoasi bilan tanishing.';
$active     = 'teachers';
require __DIR__ . '/includes/header.php';
?>
<style>
.t-grid{grid-template-columns:repeat(4,1fr)}
.t-card{padding:0;overflow:hidden;text-align:center}
.t-card .ph{aspect-ratio:1;overflow:hidden;position:relative}
.t-card .ph img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.t-card:hover .ph img{transform:scale(1.08)}
.t-card .ph::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(6,21,48,.35),transparent 45%);opacity:0;transition:.4s}
.t-card:hover .ph::after{opacity:1}
.t-body{padding:24px 20px}
.t-body h3{font-size:19px;color:var(--navy-800);margin-bottom:4px}
.t-body .spec{color:var(--gold-500);font-size:14px;font-weight:600;margin-bottom:10px}
.t-body .exp{display:inline-block;background:var(--cream);color:var(--navy-700);font-size:13px;font-weight:600;padding:5px 12px;border-radius:50px;margin-bottom:12px}
.t-body p{color:var(--gray-500);font-size:14px}
.join{background:linear-gradient(135deg,var(--navy-900),var(--navy-700));border-radius:var(--radius);padding:52px;text-align:center;color:#fff;position:relative;overflow:hidden}
.join::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 50% 0%,rgba(212,175,55,.2),transparent 55%)}
.join>*{position:relative;z-index:2}
.join h2{font-size:clamp(24px,3.5vw,36px);margin-bottom:12px}
.join p{color:rgba(255,255,255,.8);max-width:560px;margin:0 auto 26px}
@media (max-width:992px){.t-grid{grid-template-columns:1fr 1fr}}
@media (max-width:560px){.t-grid{grid-template-columns:1fr}.join{padding:34px}}
</style>

<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Bizning o'qituvchilar</h1>
        <p data-aos="fade-up" data-aos-delay="100">Har biri o'z sohasining ustasi bo'lgan, mehrli va tajribali ustozlar jamoasi.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; O'qituvchilar</div>
    </div>
</header>

<section class="section">
    <div class="container">
        <?php if ($teachers): ?>
            <div class="grid t-grid">
                <?php foreach ($teachers as $i => $t): ?>
                    <div class="card t-card" data-aos="fade-up" data-aos-delay="<?= ($i%4)*90 ?>">
                        <div class="ph"><img src="<?= upload_url($t['rasm']) ?>" alt="<?= e($t['ism']) ?>"></div>
                        <div class="t-body">
                            <h3><?= e($t['ism']) ?></h3>
                            <div class="spec"><?= e($t['mutaxassislik']) ?></div>
                            <span class="exp"><?= (int)$t['tajriba_yil'] ?> yillik tajriba</span>
                            <?php if (!empty($t['tavsif'])): ?><p><?= e($t['tavsif']) ?></p><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="center section-sub">O'qituvchilar ma'lumotlari tez orada qo'shiladi.</p>
        <?php endif; ?>
    </div>
</section>

<section class="section features">
    <div class="container">
        <div class="join" data-aos="fade-up">
            <h2>Jamoamizga qo'shiling</h2>
            <p>Agar siz o'z ishiga fidoyi, tajribali o'qituvchi bo'lsangiz — biz siz bilan tanishishdan mamnun bo'lamiz.</p>
            <a href="contact.php" class="btn btn-gold">Bog'lanish</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
