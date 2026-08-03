<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — Umumiy HEADER (barcha ochiq sahifalar uchun)
 * ---------------------------------------------------------------------
 * Ishlatilishi:
 *   $page_title = 'Bosh sahifa';
 *   $page_desc  = 'SEO tavsif...';
 *   $active     = 'index';   // aktiv menyu uchun
 *   require __DIR__ . '/includes/header.php';
 * =====================================================================
 */
require_once __DIR__ . '/../config/config.php';

$S        = get_settings();
$title    = isset($page_title) ? $page_title . ' — ' . SITE_NAME : SITE_NAME . ' — Zamonaviy xususiy maktab';
$desc     = $page_desc ?? 'Chimyon School — farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta\'lim maskani.';
$active   = $active ?? '';

// Menyu tartibi
$menu = [
    'index'     => ['index.php', 'Bosh sahifa'],
    'about'     => ['about.php', 'Maktab haqida'],
    'admission' => ['admission.php', 'Qabul'],
    'education' => ['education.php', 'Ta\'lim dasturi'],
    'teachers'  => ['teachers.php', 'O\'qituvchilar'],
    'gallery'   => ['gallery.php', 'Infratuzilma'],
    'pricing'   => ['pricing.php', 'Narxlar'],
    'news'      => ['news.php', 'Yangiliklar'],
    'contact'   => ['contact.php', 'Aloqa'],
];
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($desc) ?>">
    <meta name="theme-color" content="#0a1f44">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($desc) ?>">
    <meta property="og:type" content="website">

    <!-- Google Fonts: Inter (Primary) + Playfair Display (Accent) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Premium Design System -->
    <link rel="stylesheet" href="<?= SITE_URL ?>assets/css/global.css">

    <!-- AOS.js — scroll-reveal animatsiyalar (CDN) -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
    /* ============================================================
       DIZAYN TIZIMI — Ranglar, tipografika, tokenlar
       ============================================================ */
    :root{
        --navy-900:#061530;
        --navy-800:#0a1f44;
        --navy-700:#102a5c;
        --navy-600:#1a3a73;
        --gold-500:#d4af37;
        --gold-400:#e6c765;
        --gold-300:#f2dfa0;
        --cream:#faf7f0;
        --white:#ffffff;
        --gray-50:#f7f8fa;
        --gray-100:#eef1f5;
        --gray-300:#cbd2dc;
        --gray-500:#6b7688;
        --gray-700:#3a4355;
        --ink:#0d1526;
        --radius:16px;
        --shadow-sm:0 4px 14px rgba(10,31,68,.08);
        --shadow-md:0 14px 40px rgba(10,31,68,.14);
        --shadow-lg:0 30px 70px rgba(10,31,68,.22);
        --container:1200px;
        --nav-h:76px;
    }

    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html{scroll-behavior:smooth}
    body{
        font-family:'Inter',system-ui,sans-serif;
        color:var(--ink);
        background:var(--white);
        line-height:1.6;
        overflow-x:hidden;
        -webkit-font-smoothing:antialiased;
    }
    h1,h2,h3,h4,.serif{font-family:'Playfair Display',Georgia,serif;line-height:1.15;font-weight:700}
    a{color:inherit;text-decoration:none}
    img{max-width:100%;display:block}
    ul{list-style:none}

    .container{width:100%;max-width:var(--container);margin:0 auto;padding:0 24px}
    .section{padding:96px 0}
    .center{text-align:center}
    .text-gold{color:var(--gold-500)}

    /* ---- Bo'lim sarlavhalari ---- */
    .eyebrow{
        display:inline-flex;align-items:center;gap:8px;
        font-size:13px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;
        color:var(--gold-500);margin-bottom:16px;
    }
    .eyebrow::before{content:"";width:28px;height:2px;background:var(--gold-500);display:inline-block}
    .section-title{font-size:clamp(28px,4vw,44px);color:var(--navy-800);margin-bottom:16px;text-wrap:balance}
    .section-sub{font-size:17px;color:var(--gray-500);max-width:620px;margin:0 auto;text-wrap:pretty}

    /* ---- Tugmalar ---- */
    .btn{
        display:inline-flex;align-items:center;justify-content:center;gap:10px;
        padding:15px 30px;border-radius:50px;font-weight:600;font-size:15px;
        cursor:pointer;border:none;position:relative;overflow:hidden;
        transition:transform .35s cubic-bezier(.2,.8,.2,1),box-shadow .35s,background .3s;
    }
    .btn-gold{background:var(--gold-500);color:var(--navy-900)}
    .btn-gold:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 16px 34px rgba(212,175,55,.4)}
    .btn-outline{background:transparent;color:var(--white);border:1.5px solid rgba(255,255,255,.5)}
    .btn-outline:hover{background:var(--white);color:var(--navy-800);transform:translateY(-3px)}
    .btn-navy{background:var(--navy-800);color:var(--white)}
    .btn-navy:hover{background:var(--navy-700);transform:translateY(-3px);box-shadow:var(--shadow-md)}
    /* Ripple effekt */
    .ripple{position:absolute;border-radius:50%;transform:scale(0);background:rgba(255,255,255,.5);animation:ripple .6s linear;pointer-events:none}
    @keyframes ripple{to{transform:scale(4);opacity:0}}

    /* ============================================================
       NAVIGATSIYA
       ============================================================ */
    .nav{
        position:fixed;top:0;left:0;right:0;z-index:1000;height:var(--nav-h);
        display:flex;align-items:center;
        transition:background .4s ease,box-shadow .4s ease,height .4s ease;
        background:transparent;
    }
    .nav.scrolled{background:rgba(6,21,48,.96);box-shadow:0 8px 30px rgba(0,0,0,.25);backdrop-filter:blur(10px);height:66px}
    .nav .container{display:flex;align-items:center;justify-content:space-between}
    .logo{display:flex;align-items:center;gap:12px;color:#fff}
    .logo-mark{
        width:42px;height:42px;border-radius:11px;display:grid;place-items:center;
        background:linear-gradient(135deg,var(--gold-500),var(--gold-300));
        color:var(--navy-900);font-family:'Playfair Display',serif;font-weight:800;font-size:22px;
        box-shadow:0 6px 18px rgba(212,175,55,.4);
    }
    .logo-txt b{font-family:'Playfair Display',serif;font-size:19px;display:block;line-height:1}
    .logo-txt span{font-size:11px;letter-spacing:.22em;text-transform:uppercase;color:var(--gold-300);opacity:.9}

    .menu{display:flex;align-items:center;gap:6px}
    .menu a{
        color:rgba(255,255,255,.85);font-size:14.5px;font-weight:500;
        padding:10px 14px;border-radius:8px;position:relative;transition:color .25s;
    }
    .menu a::after{
        content:"";position:absolute;left:14px;right:14px;bottom:6px;height:2px;
        background:var(--gold-500);transform:scaleX(0);transform-origin:left;transition:transform .3s;
    }
    .menu a:hover,.menu a.active{color:#fff}
    .menu a:hover::after,.menu a.active::after{transform:scaleX(1)}

    .nav-cta{margin-left:12px;padding:11px 22px;font-size:14px}
    .burger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:8px}
    .burger span{width:26px;height:2.5px;background:#fff;border-radius:2px;transition:.3s}
    .burger.open span:nth-child(1){transform:translateY(7.5px) rotate(45deg)}
    .burger.open span:nth-child(2){opacity:0}
    .burger.open span:nth-child(3){transform:translateY(-7.5px) rotate(-45deg)}

    /* Mobil menyu (slide-in) */
    .mobile-menu{
        position:fixed;top:0;right:0;bottom:0;width:min(84vw,340px);z-index:1001;
        background:var(--navy-900);padding:100px 28px 40px;
        transform:translateX(100%);transition:transform .45s cubic-bezier(.2,.8,.2,1);
        box-shadow:-20px 0 60px rgba(0,0,0,.4);overflow-y:auto;
    }
    .mobile-menu.open{transform:translateX(0)}
    .mobile-menu a{display:block;color:rgba(255,255,255,.9);font-size:17px;font-weight:500;padding:15px 0;border-bottom:1px solid rgba(255,255,255,.08)}
    .mobile-menu a.active{color:var(--gold-500)}
    .mobile-menu .btn{width:100%;margin-top:24px}
    .overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;opacity:0;visibility:hidden;transition:.35s}
    .overlay.open{opacity:1;visibility:visible}

    /* ============================================================
       UMUMIY KARTOCHKA / GRID YORDAMCHILAR
       ============================================================ */
    .grid{display:grid;gap:28px}
    .card{
        background:#fff;border-radius:var(--radius);padding:32px;
        box-shadow:var(--shadow-sm);border:1px solid var(--gray-100);
        transition:transform .4s,box-shadow .4s;
    }
    .card:hover{transform:translateY(-8px);box-shadow:var(--shadow-md)}

    /* Sarlavha sahifa banneri (bosh sahifadan tashqari) */
    .page-hero{
        position:relative;padding:calc(var(--nav-h) + 70px) 0 70px;
        background:linear-gradient(135deg,var(--navy-900),var(--navy-700));
        color:#fff;text-align:center;overflow:hidden;
    }
    .page-hero::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 80% 20%,rgba(212,175,55,.18),transparent 55%)}
    .page-hero .container{position:relative;z-index:2}
    .page-hero h1{font-size:clamp(30px,5vw,52px);margin-bottom:14px}
    .page-hero p{color:rgba(255,255,255,.8);max-width:600px;margin:0 auto;font-size:17px}
    .crumbs{margin-top:18px;font-size:14px;color:rgba(255,255,255,.65)}
    .crumbs a{color:var(--gold-300)}

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width:992px){
        .section{padding:70px 0}
        .menu,.nav-cta{display:none}
        .burger{display:flex}
    }
    @media (max-width:600px){
        .container{padding:0 18px}
        .btn{padding:14px 26px}
    }
    </style>
</head>
<body data-page="<?= e($active) ?>">

    <!-- Skip to Content Link (Accessibility) -->
    <a href="#main-content" class="skip-link">Asosiy kontentga o'tish</a>
<!-- ======================= NAVIGATSIYA ======================= -->
<nav class="nav" id="mainNav">
    <div class="container">
        <a href="index.php" class="logo" aria-label="Chimyon School bosh sahifa">
            <span class="logo-mark">C</span>
            <span class="logo-txt"><b>Chimyon School</b><span>Xususiy maktab</span></span>
        </a>

        <ul class="menu">
            <?php foreach ($menu as $key => $item): ?>
                <li><a href="<?= $item[0] ?>" class="<?= $active === $key ? 'active' : '' ?>"><?= e($item[1]) ?></a></li>
            <?php endforeach; ?>
        </ul>

        <a href="admission.php" class="btn btn-gold nav-cta">Ariza qoldirish</a>

        <button class="burger" id="burger" aria-label="Menyu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<div class="overlay" id="overlay"></div>
<aside class="mobile-menu" id="mobileMenu" aria-hidden="true">
    <?php foreach ($menu as $key => $item): ?>
        <a href="<?= $item[0] ?>" class="<?= $active === $key ? 'active' : '' ?>"><?= e($item[1]) ?></a>
    <?php endforeach; ?>
    <a href="admission.php" class="btn btn-gold">Ariza qoldirish</a>
</aside>
