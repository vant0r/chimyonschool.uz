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
    background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(245,247,250,0.8) 100%);
    margin-top: calc(-1 * var(--nav-h));
    padding-top: var(--nav-h);
}

.hero-bg-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    object-fit: contain;
    z-index: 0;
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 2rem;
    max-width: 900px;
}

.hero-content h1 {
    font-size: clamp(2.5rem, 6vw, 5rem);
    font-weight: 700;
    letter-spacing: -0.02em;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--navy-800) 0%, #1d1d1f 50%, var(--gold-500) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-content p {
    font-size: clamp(1.1rem, 2.5vw, 1.5rem);
    line-height: 1.6;
    color: var(--gray-700);
    margin-bottom: 2rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
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
    <img src="assets/img/hero-bg.png" alt="Chimyon School" class="hero-bg-image">
    <div class="hero-content">
        <h1>Chimyon School</h1>
        <p>Farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta'lim maskani.</p>
        <div class="hero-buttons">
            <a href="admission.php" class="btn btn-gold">Ariza qoldirish</a>
            <a href="about.php" class="btn btn-outline">Batafsil</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
