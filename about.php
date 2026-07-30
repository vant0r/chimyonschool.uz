<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

$settings = getSettings();
$pageData = getPageBySlug('about');
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageData['seo_title'] ?? 'Maktab Haqida - Chimyon School'; ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageData['seo_description'] ?? 'Chimyon School xususiy maktabi haqida ma lumot'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root{--primary:#1a3a5c;--primary-dark:#0f2438;--secondary:#c9a962;--text:#2d3748;--text-light:#718096;--bg-light:#f8fafc;--white:#fff;--shadow:0 4px 6px rgba(0,0,0,0.1);--transition:all 0.3s ease}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Manrope',sans-serif;color:var(--text);line-height:1.6;background:var(--white)}
        h1,h2,h3{font-family:'Playfair Display',serif;color:var(--primary)}
        .container{max-width:1200px;margin:0 auto;padding:0 20px}
        .navbar{position:fixed;top:0;left:0;right:0;z-index:1000;transition:var(--transition);padding:20px 0;background:transparent}
        .navbar.scrolled{background:rgba(255,255,255,0.98);box-shadow:var(--shadow);padding:15px 0}
        .navbar .container{display:flex;justify-content:space-between;align-items:center}
        .logo{font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--white);text-decoration:none}
        .navbar.scrolled .logo{color:var(--primary)}
        .nav-links{display:flex;gap:30px;list-style:none}
        .nav-links a{color:var(--white);text-decoration:none;font-weight:500}
        .navbar.scrolled .nav-links a{color:var(--primary)}
        .mobile-toggle{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer}
        .mobile-toggle span{width:25px;height:3px;background:var(--white)}
        .navbar.scrolled .mobile-toggle span{background:var(--primary)}
        .page-hero{background:linear-gradient(135deg,var(--primary),var(--primary-dark));padding:180px 0 100px;text-align:center;color:var(--white)}
        .page-hero h1{font-size:3.5rem;margin-bottom:20px;color:var(--white)}
        .section{padding:100px 0}
        .section-bg{background:var(--bg-light)}
        .section-title{text-align:center;margin-bottom:60px}
        .section-title h2{font-size:2.5rem;margin-bottom:15px}
        .timeline{position:relative;max-width:800px;margin:0 auto}
        .timeline::before{content:'';position:absolute;left:50%;transform:translateX(-50%);width:2px;height:100%;background:var(--secondary)}
        .timeline-item{display:flex;justify-content:flex-end;padding-right:50px;position:relative;margin-bottom:50px;width:50%}
        .timeline-item:nth-child(even){justify-content:flex-start;padding-left:50px;margin-left:50%}
        .timeline-dot{position:absolute;right:-10px;top:0;width:20px;height:20px;background:var(--secondary);border-radius:50%;border:4px solid var(--white)}
        .timeline-item:nth-child(even) .timeline-dot{left:-10px;right:auto}
        .timeline-content{background:var(--white);padding:30px;border-radius:10px;box-shadow:var(--shadow);max-width:400px}
        .timeline-year{font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--secondary);font-weight:700}
        .values-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:30px}
        .value-card{background:var(--white);padding:40px 30px;border-radius:15px;text-align:center;box-shadow:var(--shadow);transition:var(--transition)}
        .value-card:hover{transform:translateY(-10px);box-shadow:0 10px 25px rgba(0,0,0,0.15)}
        .value-icon{font-size:3rem;color:var(--secondary);margin-bottom:20px}
        .btn{display:inline-block;padding:15px 40px;background:var(--secondary);color:var(--white);text-decoration:none;border-radius:50px;font-weight:600;transition:var(--transition)}
        .btn:hover{background:#e0c88a;transform:translateY(-3px)}
        footer{background:var(--primary-dark);color:var(--white);padding:60px 0 30px}
        .footer-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:40px;margin-bottom:40px}
        .footer-col h3{color:var(--white);margin-bottom:20px}
        .footer-col a{color:rgba(255,255,255,0.8);text-decoration:none;display:block;margin-bottom:10px}
        .footer-col a:hover{color:var(--secondary)}
        @media(max-width:768px){.mobile-toggle{display:flex}.nav-links{position:fixed;top:0;right:-100%;width:80%;height:100vh;background:var(--white);flex-direction:column;padding:80px 30px;transition:var(--transition)}.nav-links.active{right:0}.nav-links a{color:var(--primary)}.page-hero h1{font-size:2.5rem}.timeline-item,.timeline-item:nth-child(even){width:100%;margin-left:0;padding-left:50px;padding-right:0;justify-content:flex-start}.timeline-dot,.timeline-item:nth-child(even) .timeline-dot{left:10px;right:auto}}
    </style>
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="index.php" class="logo">Chimyon School</a>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php">Bosh sahifa</a></li>
                <li><a href="about.php">Maktab haqida</a></li>
                <li><a href="education.php">Ta'lim dasturi</a></li>
                <li><a href="teachers.php">O'qituvchilar</a></li>
                <li><a href="gallery.php">Infratuzilma</a></li>
                <li><a href="news.php">Yangiliklar</a></li>
                <li><a href="contact.php">Aloqa</a></li>
            </ul>
            <button class="mobile-toggle" id="mobileToggle"><span></span><span></span><span></span></button>
        </div>
    </nav>
    <section class="page-hero">
        <div class="container" data-aos="fade-up">
            <h1>Maktab Haqida</h1>
            <p>Bizning missiyamiz — kelajak avlodni zamonaviy bilimlar va yuksak qadriyatlar bilan tarbiyalash</p>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Tariximiz</h2>
                <p>Chimyon School faoliyati davomida erishgan yutuqlar</p>
            </div>
            <div class="timeline">
                <?php $events=[['year'=>'2010','title'=>'Asos solindi','desc'=>'Chimyon School o\'z faoliyatini boshladi'],['year'=>'2015','title'=>'Kengayish','desc'=>'Yangi o\'quv binolari qurildi'],['year'=>'2018','title'=>'Xalqaro e\'tirof','desc'=>'Xalqaro sertifikatlar olindi'],['year'=>'2023','title'=>'Zamonaviy texnologiyalar','desc'=>'Raqamli ta\'lim tizimi joriy etildi']]; foreach($events as $i=>$e): ?>
                <div class="timeline-item" data-aos="fade-<?php echo $i%2==0?'right':'left'; ?>">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-year"><?php echo $e['year']; ?></div>
                        <h3><?php echo $e['title']; ?></h3>
                        <p><?php echo $e['desc']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="section section-bg">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Bizning Qadriyatlarimiz</h2>
            </div>
            <div class="values-grid">
                <?php $values=[['icon'=>'fa-book-open','title'=>'Ilm-fan','desc'=>'Zamonaviy va chuqur bilim'],['icon'=>'fa-users','title'=>'Hamjihatlik','desc'=>'Do\'stona muhit'],['icon'=>'fa-lightbulb','title'=>'Ijodkorlik','desc'=>'Yangi g\'oyalar'],['icon'=>'fa-shield-alt','title'=>'Mas\'uliyat','desc'=>'Yuksak axloq']]; foreach($values as $i=>$v): ?>
                <div class="value-card" data-aos="fade-up" data-aos-delay="<?php echo $i*100; ?>">
                    <div class="value-icon"><i class="fas <?php echo $v['icon']; ?>"></i></div>
                    <h3><?php echo $v['title']; ?></h3>
                    <p><?php echo $v['desc']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Chimyon School</h3>
                    <p>Zamonaviy bilim, yuksak qadriyatlar!</p>
                </div>
                <div class="footer-col">
                    <h3>Aloqa</h3>
                    <p><?php echo htmlspecialchars($settings['telefon'] ?? '+998 90 123 45 67'); ?></p>
                    <p><?php echo htmlspecialchars($settings['email'] ?? 'info@chimyonschool.uz'); ?></p>
                </div>
            </div>
            <div style="text-align:center;padding-top:30px;border-top:1px solid rgba(255,255,255,0.1)">
                <p>&copy; <?php echo date('Y'); ?> Chimyon School</p>
            </div>
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({duration:800,once:true});
        window.addEventListener('scroll',()=>{const n=document.getElementById('navbar');if(window.scrollY>50)n.classList.add('scrolled');else n.classList.remove('scrolled')});
        document.getElementById('mobileToggle').addEventListener('click',()=>document.getElementById('navLinks').classList.toggle('active'));
    </script>
</body>
</html>
