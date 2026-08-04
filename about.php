<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — MAKTAB HAQIDA (about.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

try {
    $page = db()->query("SELECT * FROM pages WHERE slug='about' LIMIT 1")->fetch();
} catch (Throwable $ex) {
    $page = null;
}

$page_title = $page['seo_title'] ?? 'Maktab haqida';
$page_desc  = $page['seo_description'] ?? 'Chimyon School tarixi, missiyasi va qadriyatlari.';
$active     = 'about';
require __DIR__ . '/includes/header.php';
?>

<!-- PAGE HERO -->
<header class="page-hero" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="container">
        <div class="page-hero-content" style="max-width: 800px; margin: 0 auto; text-align: center;">
            <span class="eyebrow reveal-up" style="color: var(--color-primary); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; font-size: 14px;">Biz haqimizda</span>
            <h1 class="reveal-up" style="font-size: clamp(32px, 5vw, 56px); line-height: 1.1; margin: 16px 0 24px; color: var(--color-dark);">Maktab haqida</h1>
            <p class="reveal-up" style="font-size: 18px; line-height: 1.7; color: var(--color-text); opacity: 0.9;">Bilim, tarbiya va zamonaviy qadriyatlar uyg'unlashgan ta'lim maskani bilan tanishing.</p>
            <div class="crumbs reveal-up" style="margin-top: 32px; font-size: 14px; color: var(--color-text-light);"><a href="index.php" style="color: var(--color-primary); text-decoration: none;">Bosh sahifa</a> &nbsp;/&nbsp; <span>Maktab haqida</span></div>
        </div>
    </div>
</header>

<!-- STORY -->
<section class="section" style="padding: 128px 0;">
    <div class="container">
        <div class="about-story" style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;">
            <div class="imgwrap reveal-left" style="position: relative; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); aspect-ratio: 4/3;">
                <img src="<?= upload_url('about-story.png') ?>" alt="Chimyon School o'quvchilari darsda" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div class="badge" style="position: absolute; left: 24px; bottom: 24px; background: rgba(64, 129, 117, 0.95); backdrop-filter: blur(10px); color: white; padding: 20px 28px; border-radius: 16px; box-shadow: 0 10px 30px rgba(64, 129, 117, 0.3);">
                    <b style="font-family: 'Inter', sans-serif; font-size: 36px; font-weight: 700; display: block; line-height: 1;">15+</b>
                    <span style="font-size: 14px; font-weight: 500; opacity: 0.9;">yillik tajriba</span>
                </div>
            </div>
            <div class="about-text reveal-right">
                <span class="eyebrow" style="color: var(--color-primary); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; font-size: 14px; display: block; margin-bottom: 16px;">Bizning yo'l</span>
                <h2 style="font-size: clamp(28px, 4vw, 42px); line-height: 1.2; color: var(--color-dark); margin-bottom: 24px;">Har bir bolaning imkoniyatiga ishonamiz</h2>
                <p style="color: var(--color-text); line-height: 1.8; margin-bottom: 20px; font-size: 17px;">Chimyon School — Farg'ona viloyatining Chimyon tumanida joylashgan zamonaviy xususiy maktab. Biz o'quvchilarga nafaqat chuqur bilim, balki mustaqil fikrlash, mas'uliyat va yuksak insoniy qadriyatlarni singdiramiz.</p>
                <p style="color: var(--color-text); line-height: 1.8; margin-bottom: 32px; font-size: 17px;">Kichik guruhlar, individual yondashuv va tajribali ustozlar jamoasi har bir o'quvchining o'z salohiyatini to'liq ochishiga sharoit yaratadi. Bizning maqsadimiz — farzandingizni kelajakning ishonchli va bilimli fuqarosi qilib tarbiyalash.</p>
                <a href="admissions.php" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 10px; padding: 16px 32px; background: var(--color-primary); color: white; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 14px rgba(64, 129, 117, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(64, 129, 117, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(64, 129, 117, 0.3)'">Qabulga ariza qoldirish <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
            </div>
        </div>
    </div>
</section>

<!-- MISSION / VISION / VALUES -->
<section class="section" style="padding: 128px 0; background: var(--color-bg-soft);">
    <div class="container">
        <div class="center reveal-up" style="text-align: center; max-width: 700px; margin: 0 auto 64px;">
            <span class="eyebrow" style="color: var(--color-primary); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; font-size: 14px; display: block; margin-bottom: 16px;">Bizning tamoyillar</span>
            <h2 class="section-title" style="font-size: clamp(32px, 4vw, 48px); line-height: 1.2; color: var(--color-dark);">Missiya, vazifa va maqsad</h2>
        </div>
        <div class="grid mvv-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; margin-top: 52px;">
            <?php
            $mvv = [
                ['M12 2l2.4 7.4H22l-6 4.6 2.3 7.4-6.3-4.6L5.7 21.4 8 14 2 9.4h7.6z', 'Missiyamiz', 'Zamonaviy va sifatli ta\'lim orqali har bir o\'quvchini bilimli, tarbiyali va mas\'uliyatli shaxs sifatida voyaga yetkazish.'],
                ['M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z M12 15a3 3 0 100-6 3 3 0 000 6z', 'Vazifamiz', 'O\'quvchilarda ijodiy tafakkur, tanqidiy fikrlash va uzluksiz o\'rganishga ishtiyoqni shakllantirish.'],
                ['M22 11.08V12a10 10 0 11-5.93-9.14 M22 4L12 14.01l-3-3', 'Maqsadimiz', 'Xalqaro standartlarga mos, raqobatbardosh va ma\'naviy barkamol avlodni tayyorlash.'],
            ];
            foreach ($mvv as $i => $m): ?>
                <div class="card mvv-card reveal-up" style="background: white; padding: 40px 32px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); transition: all 0.4s ease; border: 1px solid rgba(0,0,0,0.03);" data-delay="<?= $i*100 ?>" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.05)'">
                    <div class="ico" style="width: 64px; height: 64px; border-radius: 16px; display: grid; place-items: center; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); color: white; margin-bottom: 24px; box-shadow: 0 8px 20px rgba(64, 129, 117, 0.3);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $m[0] ?>"/></svg>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 600; color: var(--color-dark); margin-bottom: 12px;"><?= e($m[1]) ?></h3>
                    <p style="color: var(--color-text); line-height: 1.7; font-size: 16px;"><?= e($m[2]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="section" style="padding: 128px 0;">
    <div class="container">
        <div class="center reveal-up" style="text-align: center; max-width: 700px; margin: 0 auto 64px;">
            <span class="eyebrow" style="color: var(--color-primary); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; font-size: 14px; display: block; margin-bottom: 16px;">Qadriyatlar</span>
            <h2 class="section-title" style="font-size: clamp(32px, 4vw, 48px); line-height: 1.2; color: var(--color-dark);">Biz nimalarga tayanamiz</h2>
        </div>
        <div class="grid values-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-top: 52px;">
            <?php
            $values = [
                ['01', 'Sifat', 'Ta\'lim jarayonining har bir bosqichida yuqori sifat.'],
                ['02', 'Halollik', 'Ochiqlik, adolat va o\'zaro ishonchga asoslangan muhit.'],
                ['03', 'Rivojlanish', 'O\'quvchi ham, ustoz ham doimiy o\'sishda.'],
                ['04', 'Mehr', 'Har bir bolaga individual g\'amxo\'rlik va e\'tibor.'],
            ];
            foreach ($values as $i => $v): ?>
                <div class="value reveal-up" style="text-align: center;" data-delay="<?= $i*100 ?>">
                    <div class="n" style="font-family: 'Inter', sans-serif; font-size: 56px; font-weight: 800; color: var(--color-accent); line-height: 1; opacity: 0.6; margin-bottom: 16px;"><?= e($v[0]) ?></div>
                    <h4 style="font-size: 20px; font-weight: 600; color: var(--color-dark); margin: 0 0 12px;"><?= e($v[1]) ?></h4>
                    <p style="font-size: 16px; color: var(--color-text); line-height: 1.6; margin: 0;"><?= e($v[2]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PRINCIPAL MESSAGE -->
<section class="section" style="padding: 128px 0;">
    <div class="container">
        <div class="principal reveal-up" style="display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 60px; align-items: center; background: linear-gradient(135deg, var(--color-dark), var(--color-secondary)); border-radius: 32px; padding: 64px; overflow: hidden; position: relative; box-shadow: 0 20px 50px rgba(23, 67, 63, 0.3);">
            <div style="position: relative; z-index: 2;">
                <img src="<?= upload_url('principal.png') ?>" alt="Maktab direktori" style="width: 100%; border-radius: 20px; aspect-ratio: 3/4; object-fit: cover; box-shadow: 0 15px 40px rgba(0,0,0,0.3);">
            </div>
            <div style="position: relative; z-index: 2; color: white;">
                <span class="quote" style="font-family: 'Playfair Display', serif; font-size: 80px; color: var(--color-accent); line-height: 0.5; display: block; margin-bottom: 20px;">&ldquo;</span>
                <blockquote style="font-size: 20px; line-height: 1.8; margin: 0 0 32px; color: rgba(255,255,255,0.95); font-weight: 400;">Bizning maktabimizga ishonch bildirgan har bir ota-onaga minnatdorman. Farzandingiz bu yerda nafaqat bilim oladi, balki o'ziga bo'lgan ishonchni, do'stlikni va kelajakka intilishni kashf etadi. Sizning farzandingiz muvaffaqiyati — bizning eng katta mukofotimizdir.</blockquote>
                <div class="who">
                    <b style="color: var(--color-accent); font-size: 20px; font-weight: 600; display: block; margin-bottom: 4px;">Nilufar Abdullayeva</b>
                    <span style="color: rgba(255,255,255,0.7); font-size: 15px; font-weight: 400;">Maktab direktori</span>
                </div>
            </div>
            <div style="position: absolute; inset: 0; background: radial-gradient(circle at 90% 10%, rgba(64, 129, 117, 0.2), transparent 55%); z-index: 1;"></div>
        </div>
    </div>
</section>

<style>
@media (max-width: 992px) {
    .about-story, .principal { grid-template-columns: 1fr !important; gap: 40px !important; }
    .principal { padding: 40px !important; }
}
@media (max-width: 768px) {
    .section { padding: 80px 0 !important; }
    .mvv-grid, .values-grid { grid-template-columns: 1fr !important; }
}
</style>

<?php require __DIR__ . '/includes/footer.php'; ?>
