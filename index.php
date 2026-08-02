<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — BOSH SAHIFA (index.php)
 * Apple Glassmorphism Style
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
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> - Chimyon School</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Full Screen Hero Section with Background Image */
        .hero-section {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(245,247,250,0.85) 100%);
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
            background: linear-gradient(135deg, #0a1f44 0%, #1d1d1f 50%, #5856D6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-content p {
            font-size: clamp(1.1rem, 2.5vw, 1.5rem);
            line-height: 1.6;
            color: var(--text-secondary);
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
        
        .btn-outline {
            background: transparent !important;
            border: 2px solid var(--primary-color);
            color: var(--primary-color) !important;
            box-shadow: none !important;
        }
        
        .btn-outline:hover {
            background: var(--primary-color) !important;
            color: white !important;
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
</head>
<body>
    <!-- Dynamic Background Blobs (for other sections) -->
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    
    <!-- Glass Header -->
    <header>
        <a href="/" class="logo">Chimyon School</a>
        <nav>
            <ul>
                <li><a href="#home">Bosh sahifa</a></li>
                <li><a href="about.php">Biz haqimizda</a></li>
                <li><a href="teachers.php">O'qituvchilar</a></li>
                <li><a href="admission.php">Qabul</a></li>
                <li><a href="contact.php">Aloqa</a></li>
            </ul>
        </nav>
    </header>
    
    <!-- Full Screen Hero Section -->
    <section class="hero-section" id="home">
        <img src="assets/img/hero-bg.png" alt="Chimyon School" class="hero-bg-image">
        <div class="hero-content">
            <h1>Chimyon School</h1>
            <p>Farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta'lim maskani.</p>
            <div class="hero-buttons">
                <a href="admission.php" class="btn-apple">Ariza qoldirish</a>
                <a href="about.php" class="btn-apple btn-outline">Batafsil</a>
            </div>
        </div>
    </section>
</body>
</html>
