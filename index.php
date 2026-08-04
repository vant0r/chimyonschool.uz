<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — BOSH SAHIFA (index.php)
 * Premium Design v3.0 - Apple/Stripe Style
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

// --- Dinamik ma'lumotlar (MB'dan) ---
try {
    $teachers = db()->query("SELECT * FROM teachers ORDER BY tartib ASC, id ASC LIMIT 4")->fetchAll();
    $news     = db()->query("SELECT * FROM news WHERE holat='chop_etilgan' ORDER BY sana DESC LIMIT 3")->fetchAll();
    $gallery  = db()->query("SELECT * FROM gallery ORDER BY id DESC LIMIT 6")->fetchAll();
    $stats    = db()->query("SELECT * FROM settings WHERE id = 1")->fetch();
} catch (Throwable $ex) {
    $teachers = $news = $gallery = [];
    $stats = [];
}

$page_title = 'Bosh sahifa';
$page_desc  = 'Chimyon School — farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta\'lim maskani.';
$active     = 'index';

require __DIR__ . '/includes/header.php';
?>
<main id="main-content" role="main">

<!-- ======================= HERO SECTION ======================= -->
<section class="hero-section">
    <!-- Ambient Background Glow -->
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>
    
    <div class="container hero-container">
        <div class="hero-content">
            <span class="eyebrow reveal-up">Xususiy maktab №1</span>
            <h1 class="hero-title reveal-up delay-1">
                Kelajakni bugundan <span class="text-accent">boshlang</span>
            </h1>
            <p class="hero-description reveal-up delay-2">
                Chimyon School — zamonaviy texnologiyalar, tajribali o'qituvchilar va individual yondashuv bilan farzandingizning potensialini maksimal darajada ochib beramiz.
            </p>
            <div class="hero-cta reveal-up delay-3">
                <a href="admission.php" class="btn btn-primary btn-lg btn-magnetic">
                    Ariza qoldirish
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#about-preview" class="btn btn-secondary btn-lg">
                    Batafsil ma'lumot
                </a>
            </div>
            
            <!-- Stats Row -->
            <div class="hero-stats reveal-up delay-4">
                <div class="stat-item">
                    <div class="counter" data-target="15">0</div>
                    <div class="stat-label">Yillik tajriba</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="counter" data-target="500">0</div>
                    <div class="stat-label">O'quvchilar</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="counter" data-target="100" data-suffix="%">0</div>
                    <div class="stat-label">Qabul foizi</div>
                </div>
            </div>
        </div>
        
        <!-- Hero Image -->
        <div class="hero-visual reveal-scale delay-5">
            <div class="hero-image-wrapper">
                <img src="https://placehold.co/600x700/17433F/A1BC98?text=Chimyon+Students" alt="Chimyon School o'quvchilari" loading="eager" class="hero-image">
                <!-- Glass Overlay Card -->
                <div class="hero-glass-card">
                    <div class="glass-card-content">
                        <div class="glass-card-icon">C</div>
                        <div class="glass-card-text">
                            <div class="glass-card-title">Chimyon School</div>
                            <div class="glass-card-subtitle">Premium ta'lim muassasasi</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="hero-decor hero-decor-1"></div>
            <div class="hero-decor hero-decor-2"></div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator reveal-up delay-6">
        <div class="scroll-mouse">
            <div class="scroll-wheel"></div>
        </div>
    </div>
</section>

<!-- ======================= ABOUT PREVIEW ======================= -->
<section id="about-preview" class="section-padding" style="background:var(--color-bg-body);">
    <div class="container">
        <div class="text-center reveal-up" style="max-width:700px;margin:0 auto 64px;">
            <span class="eyebrow">Biz haqimizda</span>
            <h2 class="section-title" style="color:var(--color-dark);">Zamonaviy ta'lim — ishonchli kelajak</h2>
            <p style="font-size:17px;color:var(--color-text-muted);line-height:1.7;">
                Chimyon School har bir o'quvchining noyob qobiliyatlarini kashf etish va rivojlantirishga qaratilgan individual yondashuvni taklif etadi.
            </p>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:32px;">
            <div class="card reveal-up stagger-delay-1" style="padding:40px 32px;text-align:center;">
                <div style="width:64px;height:64px;margin:0 auto 24px;background:rgba(64,129,117,0.1);border-radius:16px;display:grid;place-items:center;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <h3 style="font-size:20px;margin-bottom:12px;color:var(--color-dark);">Zamonaviy binolar</h3>
                <p style="color:var(--color-text-muted);line-height:1.6;">Yangi avlod o'quv xonalari, laboratoriyalar va sport zallari bilan jihozlangan.</p>
            </div>
            
            <div class="card reveal-up stagger-delay-2" style="padding:40px 32px;text-align:center;">
                <div style="width:64px;height:64px;margin:0 auto 24px;background:rgba(64,129,117,0.1);border-radius:16px;display:grid;place-items:center;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <h3 style="font-size:20px;margin-bottom:12px;color:var(--color-dark);">Tajribali jamoa</h3>
                <p style="color:var(--color-text-muted);line-height:1.6;">Malakali o'qituvchilar va murabbiylar har bir bolaga individual yondashadi.</p>
            </div>
            
            <div class="card reveal-up stagger-delay-3" style="padding:40px 32px;text-align:center;">
                <div style="width:64px;height:64px;margin:0 auto 24px;background:rgba(64,129,117,0.1);border-radius:16px;display:grid;place-items:center;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3 style="font-size:20px;margin-bottom:12px;color:var(--color-dark);">Innovatsion dasturlar</h3>
                <p style="color:var(--color-text-muted);line-height:1.6;">Xalqaro standartlarga mos o'quv dasturlari va STEM yo'nalishlari.</p>
            </div>
        </div>
    </div>
</section>

<!-- ======================= DYNAMIC CONTENT FROM DB ======================= -->
<?php if (!empty($teachers)): ?>
<section class="section-padding" style="background:#fff;">
    <div class="container">
        <div class="text-center reveal-up" style="max-width:700px;margin:0 auto 64px;">
            <span class="eyebrow">Bizning jamoa</span>
            <h2 class="section-title" style="color:var(--color-dark);">Tajribali o'qituvchilar</h2>
            <p style="color:var(--color-text-muted);">Har bir o'qituvchi — o'z fanining professional mutaxassisi</p>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:24px;">
            <?php foreach ($teachers as $teacher): ?>
            <div class="card reveal-up" style="text-align:center;padding:0;overflow:hidden;" data-aos="fade-up" data-aos-delay="100">
                <div class="card-image-wrapper" style="aspect-ratio:4/5;background:var(--color-bg-gray);">
                    <img src="<?= upload_url($teacher['rasm'], 'https://placehold.co/400x500/e5e7eb/6b7280?text=' . urlencode($teacher['ism'])) ?>" 
                         alt="<?= e($teacher['ism']) ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="padding:24px;">
                    <h3 style="font-size:18px;margin-bottom:4px;color:var(--color-dark);"><?= e($teacher['ism']) ?></h3>
                    <p style="color:var(--color-primary);font-size:14px;font-weight:500;"><?= e($teacher['lavozim']) ?></p>
                    <?php if (!empty($teacher['tajriba'])): ?>
                    <p style="color:var(--color-text-muted);font-size:13px;margin-top:8px;"><?= e($teacher['tajriba']) ?> yillik tajriba</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center" style="margin-top:48px;">
            <a href="teachers.php" class="btn btn-secondary">Barcha o'qituvchilarni ko'rish</a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($news)): ?>
<section class="section-padding" style="background:var(--color-bg-body);">
    <div class="container">
        <div class="text-center reveal-up" style="max-width:700px;margin:0 auto 64px;">
            <span class="eyebrow">Yangiliklar</span>
            <h2 class="section-title" style="color:var(--color-dark);">So'nggi voqealar</h2>
        </div>
        
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:32px;">
            <?php foreach ($news as $item): ?>
            <article class="card reveal-up" style="overflow:hidden;">
                <div class="card-image-wrapper" style="aspect-ratio:16/9;">
                    <img src="<?= upload_url($item['rasm'], 'https://placehold.co/600x340/e5e7eb/6b7280?text=News') ?>" 
                         alt="<?= e($item['sarlavha']) ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="padding:24px;">
                    <div style="font-size:13px;color:var(--color-text-muted);margin-bottom:12px;"><?= uz_date($item['sana']) ?></div>
                    <h3 style="font-size:18px;margin-bottom:12px;color:var(--color-dark);line-height:1.4;"><?= e($item['sarlavha']) ?></h3>
                    <p style="color:var(--color-text-muted);font-size:15px;line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= strip_tags($item['matn']) ?></p>
                    <a href="news-single.php?id=<?= $item['id'] ?>" class="btn btn-secondary" style="margin-top:20px;width:100%;justify-content:center;">Batafsil</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center" style="margin-top:48px;">
            <a href="news.php" class="btn btn-primary">Barcha yangiliklar</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ======================= CTA SECTION ======================= -->
<section class="section-padding" style="background:linear-gradient(135deg,var(--color-primary),var(--color-dark));position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');opacity:0.3;"></div>
    <div class="container text-center reveal-up" style="position:relative;z-index:2;max-width:800px;">
        <h2 class="section-title" style="color:#fff;font-size:clamp(32px,5vw,48px);margin-bottom:24px;">Farzandingiz kelajagini bugundan boshlang</h2>
        <p style="font-size:18px;color:rgba(255,255,255,0.85);margin-bottom:40px;line-height:1.7;">
            Qabul jarayoni boshlandi. Hoziroq ariza topshiring va Chimyon School oilasiga qo'shiling.
        </p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="admission.php" class="btn btn-lg" style="background:var(--primary);color:var(--dark);">Ariza qoldirish</a>
            <a href="contact.php" class="btn btn-lg" style="background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.3);">Bog'lanish</a>
        </div>
    </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
