<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — BOSH SAHIFA (index.php)
 * Apple-Inspired Premium Design
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

// --- Dinamik ma'lumotlar (MB'dan) ---
try {
    $teachers = db()->query("SELECT * FROM teachers ORDER BY tartib ASC, id ASC LIMIT 4")->fetchAll();
    $news     = db()->query("SELECT * FROM news WHERE holat='chop_etilgan' ORDER BY sana DESC LIMIT 3")->fetchAll();
    $gallery  = db()->query("SELECT * FROM gallery ORDER BY id DESC LIMIT 6")->fetchAll();
} catch (Throwable $ex) {
    $teachers = $news = $gallery = [];
}

$page_title = 'Bosh sahifa';
$page_desc  = 'Chimyon School — farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta\'lim maskani.';
$active     = 'index';
require __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="hero" style="padding: 160px 0 100px; background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <span class="eyebrow" data-aos="fade-up">Kelajakni barpo etamiz</span>
            <h1 data-aos="fade-up" data-aos-delay="100">Chimyon School</h1>
            <p data-aos="fade-up" data-aos-delay="200" style="font-size: 20px; margin-bottom: 40px;">Farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta'lim maskani. Har bir o'quvchining potensialini maksimal darajada ochib beramiz.</p>
            <div data-aos="fade-up" data-aos-delay="300" style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="admission.php" class="btn btn-primary">Ariza qoldirish</a>
                <a href="about.php" class="btn btn-secondary">Biz haqimizda</a>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="section">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Afzalliklar</span>
            <h2>Nega aynan Chimyon School?</h2>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); margin-top: 60px;">
            <?php
            $features = [
                ['M9 12l2 2 4-4 M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'Sifatli Ta\'lim', 'Zamonaviy dasturlar va xalqaro standartlarga mos ta\'lim.'],
                ['M12 4.354a4 4 0 110 5.292 M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'Kichik Guruhlar', 'Har bir o\'quvchiga individual yondashuv.'],
                ['M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'Ijodiy Muhit', 'O\'quvchilarning ijodiy salohiyatini rivojlantirish.'],
                ['M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20a8 8 0 00-8-8H4a8 8 0 00-8 8', 'Xavfsizlik', 'Bolalar uchun to\'liq xavfsiz va qulay muhit.'],
            ];
            foreach ($features as $i => $f): ?>
                <div class="card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>" style="text-align: center;">
                    <div style="width: 64px; height: 64px; border-radius: 20px; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; display: grid; place-items: center; margin: 0 auto 24px; box-shadow: 0 8px 24px rgba(64, 129, 117, 0.3);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="<?= $f[0] ?>"/></svg>
                    </div>
                    <h3 style="font-size: 20px; margin-bottom: 12px;"><?= e($f[1]) ?></h3>
                    <p style="color: var(--text-secondary); font-size: 15px;"><?= e($f[2]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TEACHERS -->
<?php if ($teachers): ?>
<section class="section" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Jamoa</span>
            <h2>Tajribali o'qituvchilar</h2>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); margin-top: 60px;">
            <?php foreach ($teachers as $i => $t): ?>
                <div class="card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>" style="padding: 0; overflow: hidden; text-align: center;">
                    <div style="aspect-ratio: 1; overflow: hidden;">
                        <img src="<?= upload_url($t['rasm']) ?>" alt="<?= e($t['ism']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 24px 20px;">
                        <h3 style="font-size: 18px; margin-bottom: 4px;"><?= e($t['ism']) ?></h3>
                        <p style="color: var(--primary); font-size: 14px; font-weight: 600; margin-bottom: 8px;"><?= e($t['mutaxassislik']) ?></p>
                        <p style="color: var(--text-tertiary); font-size: 13px;"><?= (int)$t['tajriba_yil'] ?> yillik tajriba</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 48px;" data-aos="fade-up">
            <a href="teachers.php" class="btn btn-secondary">Barcha o'qituvchilar</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- NEWS -->
<?php if ($news): ?>
<section class="section">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Yangiliklar</span>
            <h2>Oxirgi yangiliklar</h2>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); margin-top: 60px;">
            <?php foreach ($news as $i => $n): ?>
                <a href="news-single.php?id=<?= (int)$n['id'] ?>" class="card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="height: 220px; overflow: hidden;">
                        <img src="<?= upload_url($n['rasm']) ?>" alt="<?= e($n['sarlavha']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 28px; flex: 1; display: flex; flex-direction: column;">
                        <p style="color: var(--primary); font-size: 13px; font-weight: 600; margin-bottom: 12px;"><?= e(uz_date($n['sana'])) ?></p>
                        <h3 style="font-size: 19px; margin-bottom: 12px; line-height: 1.4;"><?= e($n['sarlavha']) ?></h3>
                        <p style="color: var(--text-secondary); font-size: 15px; margin-bottom: 20px; flex: 1;"><?= e(mb_substr($n['qisqa_tavsif'], 0, 100)) ?>...</p>
                        <span style="color: var(--primary); font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">Batafsil <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 48px;" data-aos="fade-up">
            <a href="news.php" class="btn btn-secondary">Barcha yangiliklar</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- GALLERY -->
<?php if ($gallery): ?>
<section class="section" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Infratuzilma</span>
            <h2>Zamonaviy muhit</h2>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); margin-top: 60px;">
            <?php foreach (array_slice($gallery, 0, 4) as $i => $g): ?>
                <div class="card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>" style="padding: 0; overflow: hidden; position: relative;">
                    <img src="<?= upload_url($g['rasm']) ?>" alt="<?= e($g['kategoriya']) ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover;">
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 20px; background: linear-gradient(to top, rgba(23, 67, 63, 0.8), transparent); color: #fff;">
                        <p style="color: #fff; font-size: 15px; font-weight: 600;"><?= e($g['kategoriya']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center; margin-top: 48px;" data-aos="fade-up">
            <a href="gallery.php" class="btn btn-secondary">Barchasi</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="section" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); color: #fff; text-align: center;">
    <div class="container" style="max-width: 700px;">
        <h2 data-aos="fade-up" style="color: #fff; margin-bottom: 16px;">Farzandingiz kelajagini bugundan boshlang</h2>
        <p data-aos="fade-up" data-aos-delay="100" style="color: rgba(255, 255, 255, 0.85); font-size: 18px; margin-bottom: 40px;">Qabulga ariza qoldiring va bizning mutaxassislarimiz siz bilan bog'lanadi.</p>
        <a href="admission.php" class="btn" data-aos="fade-up" data-aos-delay="200" style="background: #fff; color: var(--primary-dark);">Ariza qoldirish</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
