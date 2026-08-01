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
</head>
<body>
    <!-- Dynamic Background -->
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
                <li><a href="#about">Biz haqimizda</a></li>
                <li><a href="#admission">Qabul</a></li>
                <li><a href="#contact">Aloqa</a></li>
            </ul>
        </nav>
    </header>

    <!-- Scroll Container -->
    <div class="scroll-container" id="scrollContainer">
        <!-- Section 1: Home -->
        <section id="home">
            <div class="glass-card">
                <h1>Chimyon School</h1>
                <p>Farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta'lim maskani.</p>
                <a href="#admission" class="btn-apple">Ariza qoldirish</a>
            </div>
        </section>

        <!-- Section 2: About -->
        <section id="about">
            <div class="glass-card">
                <h2>Biz haqimizda</h2>
                <p>Chimyon School — O'zbekistondagi eng zamonaviy ta'lim muassasalaridan biri. Bizning maqsadimiz — har bir o'quvchining potensialini maksimal darajada ochib berish.</p>
            </div>
        </section>

        <!-- Section 3: Admission -->
        <section id="admission">
            <div class="glass-card">
                <h2>Qabul</h2>
                <p>2024-2025 o'quv yili uchun qabul boshlandi. Arizalaringizni onlayn qoldiring va bizning jamoamizga qo'shiling.</p>
                <a href="admission.php" class="btn-apple">Ariza topshirish</a>
            </div>
        </section>

        <!-- Section 4: Contact -->
        <section id="contact">
            <div class="glass-card">
                <h2>Aloqa</h2>
                <p>Savollaringiz bormi? Biz bilan bog'laning.</p>
                <p>📞 +998 90 123 45 67<br>📧 info@chimyon.uz<br>📍 Chimyon, O'zbekiston</p>
            </div>
        </section>
    </div>

    <!-- Scroll Dots -->
    <div class="scroll-dots">
        <div class="dot active" data-section="0"></div>
        <div class="dot" data-section="1"></div>
        <div class="dot" data-section="2"></div>
        <div class="dot" data-section="3"></div>
    </div>

    <script>
        // Scroll Animation & Active Dot Logic
        const container = document.getElementById('scrollContainer');
        const sections = document.querySelectorAll('section');
        const dots = document.querySelectorAll('.dot');

        function updateActiveDot(index) {
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        function revealSection() {
            const triggerBottom = window.innerHeight * 0.85;
            sections.forEach((section, index) => {
                const boxTop = section.getBoundingClientRect().top;
                if (boxTop < triggerBottom) {
                    section.classList.add('visible');
                    updateActiveDot(index);
                }
            });
        }

        // Dot click navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                sections[index].scrollIntoView({ behavior: 'smooth' });
            });
        });

        window.addEventListener('scroll', revealSection);
        window.addEventListener('load', revealSection);
    </script>
</body>
</html>

<?php require __DIR__ . '/includes/footer.php'; ?>
