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
<style>
.about-story{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
.about-story .imgwrap{position:relative;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg)}
.about-story .imgwrap img{width:100%;aspect-ratio:4/3;object-fit:cover}
.about-story .badge{position:absolute;left:24px;bottom:24px;background:var(--gold-500);color:var(--navy-900);padding:16px 22px;border-radius:14px;box-shadow:var(--shadow-md)}
.about-story .badge b{font-family:'Playfair Display',serif;font-size:30px;display:block;line-height:1}
.about-story .badge span{font-size:13px;font-weight:600}
.about-text .eyebrow{margin-bottom:14px}
.about-text h2{font-size:clamp(26px,3.5vw,38px);color:var(--navy-800);margin-bottom:18px}
.about-text p{color:var(--gray-700);margin-bottom:16px}
.mvv-grid{grid-template-columns:repeat(3,1fr)}
.mvv-card .ico{width:58px;height:58px;border-radius:14px;display:grid;place-items:center;background:linear-gradient(135deg,var(--navy-800),var(--navy-600));color:var(--gold-400);margin-bottom:20px}
.mvv-card h3{font-size:20px;color:var(--navy-800);margin-bottom:10px}
.mvv-card p{color:var(--gray-500);font-size:15px}
.values-grid{grid-template-columns:repeat(4,1fr)}
.value{text-align:center}
.value .n{font-family:'Playfair Display',serif;font-size:40px;font-weight:800;color:var(--gold-500);line-height:1}
.value h4{font-size:17px;color:var(--navy-800);margin:12px 0 6px}
.value p{font-size:14px;color:var(--gray-500)}
.principal{display:grid;grid-template-columns:.8fr 1.2fr;gap:50px;align-items:center;background:linear-gradient(135deg,var(--navy-900),var(--navy-700));border-radius:var(--radius);padding:52px;color:#fff;overflow:hidden;position:relative}
.principal::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 90% 10%,rgba(212,175,55,.18),transparent 55%)}
.principal>*{position:relative;z-index:2}
.principal img{width:100%;border-radius:var(--radius);aspect-ratio:3/4;object-fit:cover;box-shadow:var(--shadow-lg)}
.principal .quote{font-family:'Playfair Display',serif;font-size:60px;color:var(--gold-400);line-height:.5}
.principal blockquote{font-size:19px;line-height:1.7;margin:14px 0 22px;color:rgba(255,255,255,.92)}
.principal .who b{color:var(--gold-300);font-size:17px;display:block}
.principal .who span{color:rgba(255,255,255,.7);font-size:14px}
@media (max-width:900px){
    .about-story,.principal{grid-template-columns:1fr;gap:34px}
    .mvv-grid{grid-template-columns:1fr}
    .values-grid{grid-template-columns:1fr 1fr}
    .principal{padding:34px}
}
@media (max-width:560px){.values-grid{grid-template-columns:1fr 1fr}}
</style>

<!-- PAGE HERO -->
<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Maktab haqida</h1>
        <p data-aos="fade-up" data-aos-delay="100">Bilim, tarbiya va zamonaviy qadriyatlar uyg'unlashgan ta'lim maskani bilan tanishing.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; Maktab haqida</div>
    </div>
</header>

<!-- STORY -->
<section class="section">
    <div class="container">
        <div class="about-story">
            <div class="imgwrap" data-aos="fade-right">
                <img src="<?= upload_url('about-story.png') ?>" alt="Chimyon School o'quvchilari darsda">
                <div class="badge"><b>15+</b><span>yillik tajriba</span></div>
            </div>
            <div class="about-text" data-aos="fade-left">
                <span class="eyebrow">Bizning yo'l</span>
                <h2>Har bir bolaning imkoniyatiga ishonamiz</h2>
                <p>Chimyon School — Farg'ona viloyatining Chimyon tumanida joylashgan zamonaviy xususiy maktab. Biz o'quvchilarga nafaqat chuqur bilim, balki mustaqil fikrlash, mas'uliyat va yuksak insoniy qadriyatlarni singdiramiz.</p>
                <p>Kichik guruhlar, individual yondashuv va tajribali ustozlar jamoasi har bir o'quvchining o'z salohiyatini to'liq ochishiga sharoit yaratadi. Bizning maqsadimiz — farzandingizni kelajakning ishonchli va bilimli fuqarosi qilib tarbiyalash.</p>
                <a href="admission.php" class="btn btn-navy" style="margin-top:8px">Qabulga ariza qoldirish</a>
            </div>
        </div>
    </div>
</section>

<!-- MISSION / VISION / VALUES -->
<section class="section features">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Bizning tamoyillar</span>
            <h2 class="section-title">Missiya, vazifa va maqsad</h2>
        </div>
        <div class="grid mvv-grid" style="margin-top:52px">
            <?php
            $mvv = [
                ['M12 2l2.4 7.4H22l-6 4.6 2.3 7.4-6.3-4.6L5.7 21.4 8 14 2 9.4h7.6z', 'Missiyamiz', 'Zamonaviy va sifatli ta\'lim orqali har bir o\'quvchini bilimli, tarbiyali va mas\'uliyatli shaxs sifatida voyaga yetkazish.'],
                ['M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z M12 15a3 3 0 100-6 3 3 0 000 6z', 'Vazifamiz', 'O\'quvchilarda ijodiy tafakkur, tanqidiy fikrlash va uzluksiz o\'rganishga ishtiyoqni shakllantirish.'],
                ['M22 11.08V12a10 10 0 11-5.93-9.14 M22 4L12 14.01l-3-3', 'Maqsadimiz', 'Xalqaro standartlarga mos, raqobatbardosh va ma\'naviy barkamol avlodni tayyorlash.'],
            ];
            foreach ($mvv as $i => $m): ?>
                <div class="card mvv-card" data-aos="fade-up" data-aos-delay="<?= $i*120 ?>">
                    <div class="ico"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $m[0] ?>"/></svg></div>
                    <h3><?= e($m[1]) ?></h3>
                    <p><?= e($m[2]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="section">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Qadriyatlar</span>
            <h2 class="section-title">Biz nimalarga tayanamiz</h2>
        </div>
        <div class="grid values-grid" style="margin-top:52px">
            <?php
            $values = [
                ['01', 'Sifat', 'Ta\'lim jarayonining har bir bosqichida yuqori sifat.'],
                ['02', 'Halollik', 'Ochiqlik, adolat va o\'zaro ishonchga asoslangan muhit.'],
                ['03', 'Rivojlanish', 'O\'quvchi ham, ustoz ham doimiy o\'sishda.'],
                ['04', 'Mehr', 'Har bir bolaga individual g\'amxo\'rlik va e\'tibor.'],
            ];
            foreach ($values as $i => $v): ?>
                <div class="value" data-aos="fade-up" data-aos-delay="<?= $i*90 ?>">
                    <div class="n"><?= e($v[0]) ?></div>
                    <h4><?= e($v[1]) ?></h4>
                    <p><?= e($v[2]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PRINCIPAL MESSAGE -->
<section class="section features">
    <div class="container">
        <div class="principal" data-aos="fade-up">
            <div><img src="<?= upload_url('principal.png') ?>" alt="Maktab direktori"></div>
            <div>
                <span class="quote">&ldquo;</span>
                <blockquote>Bizning maktabimizga ishonch bildirgan har bir ota-onaga minnatdorman. Farzandingiz bu yerda nafaqat bilim oladi, balki o'ziga bo'lgan ishonchni, do'stlikni va kelajakka intilishni kashf etadi. Sizning farzandingiz muvaffaqiyati — bizning eng katta mukofotimizdir.</blockquote>
                <div class="who"><b>Nilufar Abdullayeva</b><span>Maktab direktori</span></div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
