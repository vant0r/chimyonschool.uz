<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — TA'LIM DASTURI (education.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

$page_title = 'Ta\'lim dasturi';
$page_desc  = 'Chimyon School o\'quv bosqichlari, fanlar va qo\'shimcha to\'garaklar haqida to\'liq ma\'lumot.';
$active     = 'education';
require __DIR__ . '/includes/header.php';
?>
<style>
.stage{display:grid;grid-template-columns:.5fr 1.5fr;gap:0;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-sm);border:1px solid var(--gray-100);margin-bottom:26px;background:#fff}
.stage .side{background:linear-gradient(135deg,var(--dark),var(--secondary));color:#fff;padding:38px;display:flex;flex-direction:column;justify-content:center}
.stage .side .num{font-family:'Playfair Display',serif;font-size:46px;font-weight:800;color:var(--accent);line-height:1}
.stage .side h3{font-size:22px;margin-top:8px}
.stage .side .cls{color:var(--accent);font-size:14px;margin-top:6px;font-weight:600}
.stage .body{padding:38px}
.stage .body p{color:var(--gray-700);margin-bottom:18px}
.subj{display:flex;flex-wrap:wrap;gap:10px}
.subj span{background:var(--gray-50);border:1px solid var(--gray-100);color:var(--secondary);font-size:13.5px;font-weight:500;padding:8px 14px;border-radius:50px}
.clubs-grid{grid-template-columns:repeat(3,1fr)}
.club{display:flex;gap:16px;align-items:flex-start}
.club .ico{flex:0 0 50px;width:50px;height:50px;border-radius:12px;display:grid;place-items:center;background:var(--cream);color:var(--primary)}
.club h4{font-size:17px;color:var(--dark);margin-bottom:4px}
.club p{font-size:14px;color:var(--gray-500)}
.day-grid{grid-template-columns:repeat(2,1fr);gap:16px}
.day{display:flex;gap:18px;align-items:center;background:#fff;border-radius:14px;padding:18px 22px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-100)}
.day .time{font-family:'Playfair Display',serif;font-weight:700;color:var(--primary);font-size:17px;flex:0 0 96px}
.day b{color:var(--dark);display:block;font-family:'Inter'}
.day span{color:var(--gray-500);font-size:14px}
@media (max-width:900px){.stage{grid-template-columns:1fr}.clubs-grid,.day-grid{grid-template-columns:1fr}}
</style>

<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Ta'lim dasturi</h1>
        <p data-aos="fade-up" data-aos-delay="100">Boshlang'ichdan bitiruvgacha — izchil, chuqur va zamonaviy o'quv tizimi.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; Ta'lim dasturi</div>
    </div>
</header>

<!-- STAGES -->
<section class="section">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">O'quv bosqichlari</span>
            <h2 class="section-title">Uch bosqichli ta'lim tizimi</h2>
        </div>
        <div style="margin-top:52px">
            <?php
            $stages = [
                ['1–4', 'Boshlang\'ich ta\'lim', 'Sinflar 1–4', 'O\'yin va amaliyot orqali o\'qish, yozish, hisoblash va mantiqiy fikrlash ko\'nikmalarini shakllantirish. Bolaning ijodiy salohiyatini erta aniqlash.', ['Ona tili', 'Matematika', 'Ingliz tili', 'Atrofimizdagi olam', 'Rasm', 'Musiqa', 'Jismoniy tarbiya']],
                ['5–9', 'O\'rta ta\'lim', 'Sinflar 5–9', 'Fundamental fanlarni chuqur o\'zlashtirish, ilmiy tafakkurni rivojlantirish va o\'quvchining qiziqish yo\'nalishini aniqlash.', ['Algebra', 'Geometriya', 'Fizika', 'Kimyo', 'Biologiya', 'Tarix', 'Geografiya', 'Ingliz tili', 'Informatika']],
                ['10–11', 'Yuqori ta\'lim', 'Sinflar 10–11', 'Oliygohga tayyorgarlik, kasb yo\'nalishini tanlash, xalqaro imtihonlar (IELTS/SAT) va olimpiadalarga chuqur tayyorlov.', ['Chuqurlashtirilgan matematika', 'Fizika', 'Kimyo', 'IELTS', 'Akademik yozuv', 'Iqtisodiyot', 'Dasturlash']],
            ];
            foreach ($stages as $i => $s): ?>
                <div class="stage" data-aos="fade-up" data-aos-delay="<?= $i*80 ?>">
                    <div class="side">
                        <span class="num"><?= e($s[0]) ?></span>
                        <h3><?= e($s[1]) ?></h3>
                        <span class="cls"><?= e($s[2]) ?></span>
                    </div>
                    <div class="body">
                        <p><?= e($s[3]) ?></p>
                        <div class="subj">
                            <?php foreach ($s[4] as $subj): ?><span><?= e($subj) ?></span><?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CLUBS -->
<section class="section features">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Qo'shimcha ta'lim</span>
            <h2 class="section-title">To'garaklar va klublar</h2>
            <p class="section-sub">Darsdan tashqari o'quvchi qiziqishlari va iqtidorini rivojlantiruvchi yo'nalishlar.</p>
        </div>
        <div class="grid clubs-grid" style="margin-top:52px">
            <?php
            $clubs = [
                ['M8 3v3a2 2 0 01-2 2H3m18 0h-3a2 2 0 01-2-2V3m0 18v-3a2 2 0 012-2h3M3 16h3a2 2 0 012 2v3', 'Robototexnika', 'STEM, dasturlash va muhandislik asoslari.'],
                ['M9 18V5l12-2v13 M9 9l12-2 M6 21a3 3 0 100-6 3 3 0 000 6z M18 19a3 3 0 100-6 3 3 0 000 6z', 'Musiqa', 'Vokal, cholg\'u asboblari va jamoaviy chiqishlar.'],
                ['M12 2l2.4 7.4H22l-6 4.6 2.3 7.4-6.3-4.6L5.7 21.4 8 14 2 9.4h7.6z', 'San\'at studiyasi', 'Rasm, dizayn va ijodiy hunarmandchilik.'],
                ['M4 4h16v12H5.17L4 17.17V4z', 'Debat klubi', 'Notiqlik, munozara va tanqidiy fikrlash.'],
                ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', 'Sport seksiyalari', 'Futbol, basketbol, shaxmat va suzish.'],
                ['M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z', 'Ingliz tili klubi', 'Suhbat amaliyoti va xalqaro imtihonlar.'],
            ];
            foreach ($clubs as $i => $c): ?>
                <div class="card club" data-aos="fade-up" data-aos-delay="<?= ($i%3)*100 ?>">
                    <div class="ico"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $c[0] ?>"/></svg></div>
                    <div><h4><?= e($c[1]) ?></h4><p><?= e($c[2]) ?></p></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- DAILY SCHEDULE -->
<section class="section">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Kun tartibi</span>
            <h2 class="section-title">Bir kun Chimyon School'da</h2>
        </div>
        <div class="grid day-grid" style="margin-top:52px">
            <?php
            $day = [
                ['08:00', 'Kunni boshlash', 'Yig\'ilish va ertalabki mashqlar'],
                ['08:30', 'Asosiy darslar', 'Akademik fanlar (1-blok)'],
                ['11:00', 'Tushlik tanaffusi', 'Sog\'lom ovqatlanish'],
                ['11:45', 'Asosiy darslar', 'Akademik fanlar (2-blok)'],
                ['14:00', 'To\'garaklar', 'Qiziqish bo\'yicha klublar'],
                ['16:00', 'Mustaqil ish', 'Uy vazifasi va maslahat'],
            ];
            foreach ($day as $i => $d): ?>
                <div class="day" data-aos="fade-up" data-aos-delay="<?= ($i%2)*80 ?>">
                    <span class="time"><?= e($d[0]) ?></span>
                    <div><b><?= e($d[1]) ?></b><span><?= e($d[2]) ?></span></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-band">
    <div class="container">
        <h2 data-aos="fade-up">Farzandingizga mos dasturni tanlang</h2>
        <p data-aos="fade-up" data-aos-delay="100">Bepul konsultatsiya uchun ariza qoldiring — mutaxassislarimiz siz bilan bog'lanadi.</p>
        <a href="admission.php" class="btn btn-gold" data-aos="fade-up" data-aos-delay="200">Ariza qoldirish</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
