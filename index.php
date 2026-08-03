<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — BOSH SAHIFA (index.php)
 * Full Screen Hero with Transparent Header
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

require_once __DIR__ . '/includes/header.php';
?>

<style>
/* ============================================================
   HERO SECTION — Full Screen with Background Image
   ============================================================ */
.hero-section {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: transparent;
    margin-top: calc(-1 * var(--nav-h));
    padding-top: var(--nav-h);
}

.hero-bg-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    min-width: 100vw;
    min-height: 100vh;
    width: auto;
    height: auto;
    max-width: none;
    z-index: 0;
    pointer-events: none;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(6, 21, 48, 0.5);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 2rem;
    max-width: 900px;
    color: #fff;
}

.hero-content h1 {
    font-size: clamp(2.5rem, 6vw, 5rem);
    font-weight: 700;
    letter-spacing: -0.02em;
    margin-bottom: 1rem;
    color: #fff;
    text-shadow: 0 8px 32px rgba(0,0,0,0.5);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.hero-content p {
    font-size: clamp(1.1rem, 2.5vw, 1.5rem);
    line-height: 1.6;
    color: #f5f5f5;
    margin-bottom: 2rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    text-shadow: 0 4px 16px rgba(0,0,0,0.4);
    -webkit-font-smoothing: antialiased;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Asosiy sahifa kontenti - scroll qilinadigan bo'limlar */
.main-content {
    position: relative;
    z-index: 10;
    background: #fff;
}

/* Transparent header for hero page */
body[data-page="index"] .nav {
    background: transparent;
    box-shadow: none;
}

body[data-page="index"] .nav.scrolled {
    background: rgba(6,21,48,.96);
    box-shadow: 0 8px 30px rgba(0,0,0,.25);
}

body[data-page="index"] .logo-mark,
body[data-page="index"] .logo-txt b,
body[data-page="index"] .menu a,
body[data-page="index"] .burger span {
    color: #fff;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

body[data-page="index"] .logo-txt span {
    color: var(--gold-300);
}

@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }
    .hero-content p {
        font-size: 1.1rem;
    }
    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<!-- Full Screen Hero Section -->
<section class="hero-section" id="home">
    <img src="assets/img/hero-bg.png" alt="Chimyon School" class="hero-bg-image" loading="eager" fetchpriority="high">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Chimyon School</h1>
        <p>Farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta'lim maskani.</p>
        <div class="hero-buttons">
            <a href="admission.php" class="btn btn-gold">Ariza qoldirish</a>
            <a href="about.php" class="btn btn-outline">Batafsil</a>
        </div>
    </div>
</section>

<div class="main-content">
<?php if (!empty($teachers) || !empty($news) || !empty($gallery)): ?>
<!-- O'qituvchilar bo'limi -->
<?php if (!empty($teachers)): ?>
<section class="section" id="teachers">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Jamoa</span>
            <h2 class="section-title">Bizning o'qituvchilar</h2>
            <p class="section-sub">Tajribali, malakali va farzandlaringizga g'amxo'rlik qiladigan ustozlar.</p>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); margin-top: 48px;">
            <?php foreach ($teachers as $t): ?>
            <div class="card" data-aos="fade-up" data-aos-delay="50">
                <img src="<?= upload_url($t['rasmi'] ?? '', 'https://placehold.co/400x400/0a1f44/d4af37?text=Teacher') ?>" 
                     alt="<?= e($t['ism_familiya'] ?? '') ?>" 
                     style="width:100%; aspect-ratio:1; object-fit:cover; border-radius:12px; margin-bottom:16px;">
                <h3 style="font-size:18px; margin-bottom:6px;"><?= e($t['ism_familiya'] ?? '') ?></h3>
                <p style="color:var(--gray-500); font-size:14px;"><?= e($t['lavozim'] ?? '') ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Yangiliklar bo'limi -->
<?php if (!empty($news)): ?>
<section class="section" style="background:var(--gray-50);" id="news">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">So'nggi xabarlar</span>
            <h2 class="section-title">Yangiliklar</h2>
            <p class="section-sub">Maktab hayotidan eng so'nggi yangiliklar va voqealar.</p>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); margin-top: 48px;">
            <?php foreach ($news as $n): ?>
            <article class="card" data-aos="fade-up" data-aos-delay="50">
                <img src="<?= upload_url($n['rasmi'] ?? '', 'https://placehold.co/600x400/0a1f44/d4af37?text=News') ?>" 
                     alt="<?= e($n['sarlavha'] ?? '') ?>" 
                     style="width:100%; aspect-ratio:16/9; object-fit:cover; border-radius:12px; margin-bottom:16px;">
                <time style="font-size:13px; color:var(--gray-500);"><?= uz_date($n['sana']) ?></time>
                <h3 style="font-size:18px; margin:8px 0;"><?= e($n['sarlavha'] ?? '') ?></h3>
                <p style="font-size:14px; color:var(--gray-500); line-height:1.6;"><?= e(mb_substr(strip_tags($n['matn']), 0, 120)) ?>...</p>
                <a href="news-single.php?id=<?= $n['id'] ?>" class="btn btn-navy" style="margin-top:16px; padding:12px 24px; font-size:14px;">Batafsil</a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Galereya bo'limi -->
<?php if (!empty($gallery)): ?>
<section class="section" id="gallery">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Infratuzilma</span>
            <h2 class="section-title">Foto galereya</h2>
            <p class="section-sub">Zamonaviy sinfxonalar, sport zallari va dam olish hududlari.</p>
        </div>
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); margin-top: 48px;">
            <?php foreach ($gallery as $g): ?>
            <div class="card" style="padding:0; overflow:hidden;" data-aos="fade-up" data-aos-delay="50">
                <img src="<?= upload_url($g['rasm'] ?? '', 'https://placehold.co/600x400/0a1f44/d4af37?text=Gallery') ?>" 
                     alt="<?= e($g['nomi'] ?? 'Rasm') ?>" 
                     style="width:100%; aspect-ratio:4/3; object-fit:cover;">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
