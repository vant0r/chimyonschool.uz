<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — BOSH SAHIFA (index.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

// --- Dinamik ma'lumotlar (MB'dan) ---
try {
    $teachers = db()->query("SELECT * FROM teachers ORDER BY tartib ASC, id ASC LIMIT 4")->fetchAll();
    $news     = db()->query("SELECT * FROM news WHERE holat='chop_etilgan' ORDER BY sana DESC LIMIT 3")->fetchAll();
    $gallery  = db()->query("SELECT * FROM gallery ORDER BY id DESC LIMIT 6")->fetchAll();
} catch (Throwable $ex) {
    // MB hali sozlanmagan bo'lsa — bo'sh massivlar bilan davom etadi
    $teachers = $news = $gallery = [];
}

$page_title = 'Bosh sahifa';
$page_desc  = 'Chimyon School — farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta\'lim maskani. Ariza qoldiring!';
$active     = 'index';
require __DIR__ . '/includes/header.php';
?>

<style>
/* ============================================================
   BOSH SAHIFAGA XOS USLUBLAR
   ============================================================ */
/* ---- HERO ---- */
.hero{position:relative;min-height:100vh;display:flex;align-items:center;color:#fff;overflow:hidden}
.hero-bg{position:absolute;inset:0;z-index:0}
.hero-bg img{width:100%;height:100%;object-fit:cover;animation:heroZoom 20s ease-in-out infinite alternate}
@keyframes heroZoom{from{transform:scale(1)}to{transform:scale(1.12)}}
.hero-bg::after{content:"";position:absolute;inset:0;background:linear-gradient(120deg,rgba(6,21,48,.92) 0%,rgba(10,31,68,.78) 45%,rgba(6,21,48,.55) 100%)}
.hero-glow{position:absolute;top:-10%;right:-5%;width:520px;height:520px;border-radius:50%;background:radial-gradient(circle,rgba(212,175,55,.28),transparent 65%);z-index:1;filter:blur(10px)}
.hero .container{position:relative;z-index:2;padding-top:var(--nav-h)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(212,175,55,.14);border:1px solid rgba(212,175,55,.4);color:var(--gold-300);padding:9px 18px;border-radius:50px;font-size:13.5px;font-weight:500;margin-bottom:26px;backdrop-filter:blur(6px)}
.hero-badge span{width:8px;height:8px;border-radius:50%;background:var(--gold-500);box-shadow:0 0 0 0 rgba(212,175,55,.6);animation:pulse 2s infinite}
@keyframes pulse{70%{box-shadow:0 0 0 12px rgba(212,175,55,0)}100%{box-shadow:0 0 0 0 rgba(212,175,55,0)}}
.hero h1{font-size:clamp(38px,6.5vw,76px);line-height:1.05;margin-bottom:22px;max-width:900px;text-wrap:balance}
.hero h1 em{font-style:normal;color:var(--gold-400);position:relative}
.hero p{font-size:clamp(16px,2vw,20px);color:rgba(255,255,255,.85);max-width:560px;margin-bottom:36px;text-wrap:pretty}
.hero-actions{display:flex;gap:16px;flex-wrap:wrap;align-items:center}
.hero-scroll{position:absolute;bottom:30px;left:50%;transform:translateX(-50%);z-index:2;color:rgba(255,255,255,.6);font-size:12px;letter-spacing:.15em;text-transform:uppercase;display:flex;flex-direction:column;align-items:center;gap:8px}
.hero-scroll .mouse{width:24px;height:38px;border:2px solid rgba(255,255,255,.4);border-radius:14px;position:relative}
.hero-scroll .mouse::after{content:"";position:absolute;top:7px;left:50%;transform:translateX(-50%);width:4px;height:7px;background:var(--gold-500);border-radius:2px;animation:scrollDot 1.6s infinite}
@keyframes scrollDot{0%{opacity:0;top:7px}40%{opacity:1}80%{opacity:0;top:18px}}

/* ---- FEATURES ---- */
.features{background:var(--gray-50)}
.feature-grid{grid-template-columns:repeat(3,1fr)}
.feature-card{text-align:left}
.feature-ico{width:60px;height:60px;border-radius:15px;display:grid;place-items:center;background:linear-gradient(135deg,var(--navy-800),var(--navy-600));color:var(--gold-400);margin-bottom:22px;transition:.4s}
.feature-card:hover .feature-ico{background:linear-gradient(135deg,var(--gold-500),var(--gold-300));color:var(--navy-900);transform:rotate(-6deg) scale(1.05)}
.feature-card h3{font-size:21px;color:var(--navy-800);margin-bottom:10px}
.feature-card p{color:var(--gray-500);font-size:15px}

/* ---- STATS ---- */
.stats{background:linear-gradient(135deg,var(--navy-900),var(--navy-700));color:#fff;position:relative;overflow:hidden}
.stats::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 15% 30%,rgba(212,175,55,.16),transparent 45%),radial-gradient(circle at 85% 80%,rgba(212,175,55,.12),transparent 45%)}
.stats .container{position:relative;z-index:2}
.stat-grid{grid-template-columns:repeat(4,1fr);text-align:center}
.stat-num{font-family:'Playfair Display',serif;font-size:clamp(40px,6vw,60px);font-weight:800;color:var(--gold-400);line-height:1}
.stat-label{margin-top:10px;color:rgba(255,255,255,.8);font-size:15px}
.stat-div{width:1px;background:rgba(255,255,255,.12)}

/* ---- PROGRAMS ---- */
.prog-grid{grid-template-columns:repeat(3,1fr)}
.prog-card{padding:0;overflow:hidden}
.prog-card .thumb{height:190px;background:linear-gradient(135deg,var(--navy-700),var(--navy-600));position:relative;display:grid;place-items:center;color:var(--gold-400)}
.prog-card .thumb .big{font-family:'Playfair Display',serif;font-size:64px;font-weight:800;opacity:.9}
.prog-body{padding:28px}
.prog-body h3{font-size:22px;color:var(--navy-800);margin-bottom:8px}
.prog-body p{color:var(--gray-500);font-size:14.5px;margin-bottom:16px}
.prog-body .tag{display:inline-block;font-size:13px;color:var(--gold-500);font-weight:600}

/* ---- TEACHERS PREVIEW ---- */
.teach-grid{grid-template-columns:repeat(4,1fr)}
.teach-card{padding:0;overflow:hidden;text-align:center}
.teach-card .ph{aspect-ratio:1;overflow:hidden}
.teach-card .ph img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.teach-card:hover .ph img{transform:scale(1.08)}
.teach-body{padding:22px 18px}
.teach-body h4{font-size:18px;color:var(--navy-800);margin-bottom:4px}
.teach-body .spec{color:var(--gold-500);font-size:13.5px;font-weight:600;margin-bottom:6px}
.teach-body .exp{color:var(--gray-500);font-size:13px}

/* ---- GALLERY PREVIEW ---- */
.gal-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.gal-item{position:relative;border-radius:14px;overflow:hidden;aspect-ratio:4/3;cursor:pointer;box-shadow:var(--shadow-sm)}
.gal-item img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.gal-item::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(6,21,48,.55),transparent 55%);opacity:0;transition:.4s}
.gal-item:hover img{transform:scale(1.12)}
.gal-item:hover::after{opacity:1}
.gal-cap{position:absolute;left:16px;bottom:14px;color:#fff;font-weight:600;z-index:2;opacity:0;transform:translateY(10px);transition:.4s;text-transform:capitalize}
.gal-item:hover .gal-cap{opacity:1;transform:translateY(0)}

/* ---- TESTIMONIALS ---- */
.testi{background:var(--cream);overflow:hidden}
.testi-track{display:flex;gap:28px;transition:transform .6s cubic-bezier(.2,.8,.2,1)}
.testi-card{flex:0 0 calc(33.333% - 19px);background:#fff;border-radius:var(--radius);padding:34px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-100)}
.testi-card .quote{font-size:44px;font-family:'Playfair Display',serif;color:var(--gold-500);line-height:.6;margin-bottom:14px}
.testi-card p{color:var(--gray-700);font-size:15.5px;margin-bottom:20px;font-style:italic}
.testi-who{display:flex;align-items:center;gap:14px}
.testi-who .av{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--navy-800),var(--navy-600));color:var(--gold-400);display:grid;place-items:center;font-weight:700;font-family:'Playfair Display',serif}
.testi-who b{color:var(--navy-800);font-size:15px;display:block}
.testi-who span{color:var(--gray-500);font-size:13px}
.testi-nav{display:flex;justify-content:center;gap:12px;margin-top:34px}
.testi-nav button{width:46px;height:46px;border-radius:50%;border:1.5px solid var(--gray-300);background:#fff;cursor:pointer;display:grid;place-items:center;color:var(--navy-800);transition:.3s}
.testi-nav button:hover{background:var(--navy-800);color:#fff;border-color:var(--navy-800)}

/* ---- NEWS ---- */
.news-grid{grid-template-columns:repeat(3,1fr)}
.news-card{padding:0;overflow:hidden}
.news-card .ph{height:200px;overflow:hidden}
.news-card .ph img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.news-card:hover .ph img{transform:scale(1.07)}
.news-body{padding:26px}
.news-date{font-size:13px;color:var(--gold-500);font-weight:600;margin-bottom:10px}
.news-body h3{font-size:19px;color:var(--navy-800);margin-bottom:10px;line-height:1.3}
.news-body p{color:var(--gray-500);font-size:14.5px;margin-bottom:16px}
.news-more{color:var(--navy-700);font-weight:600;font-size:14px;display:inline-flex;gap:6px;align-items:center;transition:gap .3s}
.news-card:hover .news-more{gap:12px}

/* ---- CTA ---- */
.cta-band{position:relative;padding:110px 0;color:#fff;text-align:center;overflow:hidden;background:linear-gradient(135deg,var(--navy-900),var(--navy-700))}
.cta-band::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 50% 120%,rgba(212,175,55,.28),transparent 55%)}
.cta-band .container{position:relative;z-index:2}
.cta-band h2{font-size:clamp(30px,5vw,52px);margin-bottom:18px;text-wrap:balance}
.cta-band p{color:rgba(255,255,255,.82);max-width:560px;margin:0 auto 34px;font-size:18px}

.sec-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:52px;flex-wrap:wrap}
.sec-head .section-title,.sec-head .section-sub{margin:0}
.sec-head .section-sub{text-align:left;margin-top:10px}
.link-arrow{color:var(--navy-700);font-weight:600;display:inline-flex;gap:8px;align-items:center;transition:gap .3s}
.link-arrow:hover{gap:14px}

@media (max-width:992px){
    .feature-grid,.prog-grid,.news-grid{grid-template-columns:1fr 1fr}
    .teach-grid{grid-template-columns:1fr 1fr}
    .stat-grid{grid-template-columns:1fr 1fr;gap:40px 20px}
    .stat-div{display:none}
    .testi-card{flex:0 0 calc(100% - 0px)}
    .gal-grid{grid-template-columns:1fr 1fr}
}
@media (max-width:600px){
    .feature-grid,.prog-grid,.news-grid,.teach-grid,.gal-grid{grid-template-columns:1fr}
    .hero{min-height:92vh}
}
</style>

<!-- ======================= HERO ======================= -->
<header class="hero">
    <div class="hero-bg">
        <img src="<?= upload_url('hero.png') ?>" alt="Chimyon School zamonaviy o'quv binosi">
    </div>
    <div class="hero-glow"></div>
    <div class="container">
        <div data-aos="fade-up">
            <span class="hero-badge"><span></span> 2026–2027 o'quv yiliga qabul ochiq</span>
        </div>
        <h1 data-aos="fade-up" data-aos-delay="100">Farzandingiz uchun <em>eng yaxshi</em> boshlang'ich shu yerda</h1>
        <p data-aos="fade-up" data-aos-delay="200">Chimyon School — zamonaviy metodika, tajribali ustozlar va nufuzli muhitda bilim va tarbiyani uyg'unlashtiruvchi xususiy maktab.</p>
        <div class="hero-actions" data-aos="fade-up" data-aos-delay="300">
            <a href="admission.php" class="btn btn-gold">Ariza qoldirish
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <a href="about.php" class="btn btn-outline">Maktab haqida</a>
        </div>
    </div>
    <div class="hero-scroll"><span>Pastga</span><span class="mouse"></span></div>
</header>

<!-- ======================= FEATURES ======================= -->
<section class="section features">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Nega aynan biz</span>
            <h2 class="section-title">Nega Chimyon School?</h2>
            <p class="section-sub">Biz shunchaki maktab emas — bu farzandingizning kelajagiga qo'yilgan ishonchli investitsiya.</p>
        </div>
        <div class="grid feature-grid" style="margin-top:56px">
            <?php
            $features = [
                ['M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.42a12 12 0 01.66 4.34c0 2.09-.7 4.13-2 5.79a11.94 11.94 0 01-9.64 0c-1.3-1.66-2-3.7-2-5.79 0-1.5.23-2.97.66-4.34L12 14z', 'Kuchli akademik dastur', 'Milliy standart va xalqaro tajriba uyg\'unlashtirilgan chuqurlashtirilgan o\'quv rejasi.'],
                ['M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2 M9 11a4 4 0 100-8 4 4 0 000 8z M23 21v-2a4 4 0 00-3-3.87 M16 3.13a4 4 0 010 7.75', 'Tajribali ustozlar', 'Oliy toifali, o\'z sohasining yetakchi mutaxassislari va olimpiada murabbiylari.'],
                ['M12 2l2.4 7.4H22l-6 4.6 2.3 7.4-6.3-4.6L5.7 21.4 8 14 2 9.4h7.6z', 'Individual yondashuv', 'Har bir o\'quvchi qobiliyatiga mos, kichik guruhlarda samarali ta\'lim.'],
                ['M3 3v18h18 M18.7 8l-5.1 5.2-2.8-2.8L7 14', 'Yuqori natijalar', 'Bitiruvchilarimiz nufuzli oliygohlar va xalqaro dasturlarga muvaffaqiyatli kirmoqda.'],
                ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', 'Xavfsiz muhit', 'Zamonaviy xavfsizlik tizimi, video kuzatuv va tibbiy nazorat.'],
                ['M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z', 'Til va ko\'nikmalar', 'Ingliz tili, IT, robototexnika, san\'at va sport bo\'yicha qo\'shimcha darslar.'],
            ];
            foreach ($features as $i => $f): ?>
                <div class="card feature-card" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                    <div class="feature-ico">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $f[0] ?>"/></svg>
                    </div>
                    <h3><?= e($f[1]) ?></h3>
                    <p><?= e($f[2]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ======================= STATS ======================= -->
<section class="section stats">
    <div class="container">
        <div class="grid stat-grid">
            <div data-aos="fade-up"><div class="stat-num" data-count="500" data-suffix="+">0</div><div class="stat-label">Baxtli o'quvchilar</div></div>
            <div class="stat-div" aria-hidden="true"></div>
            <div data-aos="fade-up" data-aos-delay="100"><div class="stat-num" data-count="45" data-suffix="+">0</div><div class="stat-label">Tajribali o'qituvchilar</div></div>
            <div data-aos="fade-up" data-aos-delay="200"><div class="stat-num" data-count="15" data-suffix="">0</div><div class="stat-label">Yillik tajriba</div></div>
            <div data-aos="fade-up" data-aos-delay="300"><div class="stat-num" data-count="98" data-suffix="%">0</div><div class="stat-label">Bitiruvchilar muvaffaqiyati</div></div>
        </div>
    </div>
</section>

<!-- ======================= PROGRAMS ======================= -->
<section class="section">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Ta'lim bosqichlari</span>
            <h2 class="section-title">Har bir yosh uchun mos dastur</h2>
            <p class="section-sub">Boshlang'ichdan yuqori sinfgacha — uzluksiz va izchil rivojlanish yo'li.</p>
        </div>
        <div class="grid prog-grid" style="margin-top:56px">
            <?php
            $programs = [
                ['1–4', 'Boshlang\'ich sinflar', 'O\'qish, yozish va mantiqiy fikrlash ko\'nikmalarini o\'yin orqali shakllantirish.', 'Sinflar: 1–4'],
                ['5–9', 'O\'rta sinflar', 'Fundamental fanlarni chuqur o\'zlashtirish va shaxsiy qiziqishlarni aniqlash.', 'Sinflar: 5–9'],
                ['10–11', 'Yuqori sinflar', 'Oliygohga tayyorgarlik, kasb yo\'nalishi va xalqaro imtihonlarga tayyorlov.', 'Sinflar: 10–11'],
            ];
            foreach ($programs as $i => $p): ?>
                <div class="card prog-card" data-aos="fade-up" data-aos-delay="<?= $i * 120 ?>">
                    <div class="thumb"><span class="big"><?= e($p[0]) ?></span></div>
                    <div class="prog-body">
                        <h3><?= e($p[1]) ?></h3>
                        <p><?= e($p[2]) ?></p>
                        <span class="tag"><?= e($p[3]) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="center" style="margin-top:44px" data-aos="fade-up">
            <a href="education.php" class="btn btn-navy">To'liq ta'lim dasturi</a>
        </div>
    </div>
</section>

<!-- ======================= TEACHERS ======================= -->
<section class="section features">
    <div class="container">
        <div class="sec-head" data-aos="fade-up">
            <div>
                <span class="eyebrow">Bizning jamoa</span>
                <h2 class="section-title">Tajribali o'qituvchilar</h2>
            </div>
            <a href="teachers.php" class="link-arrow">Barchasini ko'rish
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="grid teach-grid">
            <?php if ($teachers): foreach ($teachers as $i => $t): ?>
                <div class="card teach-card" data-aos="fade-up" data-aos-delay="<?= ($i % 4) * 90 ?>">
                    <div class="ph"><img src="<?= upload_url($t['rasm']) ?>" alt="<?= e($t['ism']) ?>"></div>
                    <div class="teach-body">
                        <h4><?= e($t['ism']) ?></h4>
                        <div class="spec"><?= e($t['mutaxassislik']) ?></div>
                        <div class="exp"><?= (int)$t['tajriba_yil'] ?> yillik tajriba</div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <p class="section-sub">O'qituvchilar ma'lumotlari tez orada qo'shiladi.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ======================= GALLERY ======================= -->
<section class="section">
    <div class="container">
        <div class="sec-head" data-aos="fade-up">
            <div>
                <span class="eyebrow">Infratuzilma</span>
                <h2 class="section-title">Zamonaviy o'quv muhiti</h2>
            </div>
            <a href="gallery.php" class="link-arrow">To'liq galereya
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="gal-grid">
            <?php if ($gallery): foreach ($gallery as $i => $g): ?>
                <div class="gal-item" data-aos="zoom-in" data-aos-delay="<?= ($i % 3) * 90 ?>">
                    <img src="<?= upload_url($g['rasm']) ?>" alt="Chimyon School — <?= e($g['kategoriya']) ?>">
                    <span class="gal-cap"><?= e($g['kategoriya']) ?></span>
                </div>
            <?php endforeach; else: ?>
                <p class="section-sub">Galereya rasmlari tez orada qo'shiladi.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ======================= TESTIMONIALS ======================= -->
<section class="section testi">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Ota-onalar fikri</span>
            <h2 class="section-title">Bizga ishonganlar</h2>
        </div>
        <div style="margin-top:52px;overflow:hidden" data-aos="fade-up">
            <div class="testi-track" id="testiTrack">
                <?php
                $testis = [
                    ['Farzandim shu maktabga kelgach, o\'qishga bo\'lgan qiziqishi butunlay o\'zgardi. Ustozlarga alohida rahmat!', 'Nodira Ahmedova', 'Ona, 5-sinf o\'quvchisi'],
                    ['Xavfsiz muhit va individual yondashuv biz uchun eng muhimi edi. Chimyon School kutganimizdan ham a\'lo.', 'Bekzod Tursunov', 'Ota, 2-sinf o\'quvchisi'],
                    ['Bitiruvchi farzandim nufuzli universitetga grant bilan kirdi. Bu maktab poydevorining natijasi.', 'Gulnora Qodirova', 'Ona, bitiruvchi'],
                    ['Zamonaviy laboratoriya va til darslari farzandimning dunyoqarashini kengaytirdi.', 'Sherzod Yo\'ldoshev', 'Ota, 8-sinf o\'quvchisi'],
                ];
                foreach ($testis as $t): ?>
                    <div class="testi-card">
                        <div class="quote">&ldquo;</div>
                        <p><?= e($t[0]) ?></p>
                        <div class="testi-who">
                            <div class="av"><?= e(mb_substr($t[1], 0, 1)) ?></div>
                            <div><b><?= e($t[1]) ?></b><span><?= e($t[2]) ?></span></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="testi-nav">
            <button id="testiPrev" aria-label="Oldingi"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button id="testiNext" aria-label="Keyingi"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 18l6-6-6-6"/></svg></button>
        </div>
    </div>
</section>

<!-- ======================= NEWS ======================= -->
<section class="section features">
    <div class="container">
        <div class="sec-head" data-aos="fade-up">
            <div>
                <span class="eyebrow">Yangiliklar</span>
                <h2 class="section-title">So'nggi yangiliklar</h2>
            </div>
            <a href="news.php" class="link-arrow">Barcha yangiliklar
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="grid news-grid">
            <?php if ($news): foreach ($news as $i => $n): ?>
                <a href="news-single.php?id=<?= (int)$n['id'] ?>" class="card news-card" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                    <div class="ph"><img src="<?= upload_url($n['rasm']) ?>" alt="<?= e($n['sarlavha']) ?>"></div>
                    <div class="news-body">
                        <div class="news-date"><?= e(uz_date($n['sana'])) ?></div>
                        <h3><?= e($n['sarlavha']) ?></h3>
                        <p><?= e(mb_strimwidth($n['qisqa_tavsif'] ?? '', 0, 110, '...')) ?></p>
                        <span class="news-more">Batafsil o'qish
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; else: ?>
                <p class="section-sub">Yangiliklar tez orada e'lon qilinadi.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ======================= CTA ======================= -->
<section class="cta-band">
    <div class="container" data-aos="zoom-in">
        <h2>Farzandingiz kelajagini biz bilan quring</h2>
        <p>Bugun ariza qoldiring — mutaxassislarimiz siz bilan bog'lanib, barcha savollaringizga javob beradi.</p>
        <a href="admission.php" class="btn btn-gold">Hoziroq ariza qoldirish
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</section>

<script>
/* ---- Testimonial slayder ---- */
(function(){
    var track = document.getElementById('testiTrack');
    if (!track) return;
    var cards = track.children.length;
    var index = 0;
    function perView(){ return window.innerWidth <= 992 ? 1 : 3; }
    function maxIndex(){ return Math.max(0, cards - perView()); }
    function go(){
        var card = track.children[0];
        var gap = 28;
        var w = card.getBoundingClientRect().width + gap;
        track.style.transform = 'translateX(' + (-index * w) + 'px)';
    }
    document.getElementById('testiPrev').addEventListener('click', function(){ index = index <= 0 ? maxIndex() : index - 1; go(); });
    document.getElementById('testiNext').addEventListener('click', function(){ index = index >= maxIndex() ? 0 : index + 1; go(); });
    var auto = setInterval(function(){ index = index >= maxIndex() ? 0 : index + 1; go(); }, 5000);
    track.parentElement.addEventListener('mouseenter', function(){ clearInterval(auto); });
    window.addEventListener('resize', function(){ index = Math.min(index, maxIndex()); go(); });
})();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
