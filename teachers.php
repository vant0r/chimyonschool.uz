<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$settings = getSettings();
$teachers = getTeachers(8); // 8 ta o'qituvchini chiqaramiz

$page_title = "O'qituvchilar - " . ($settings['site_name'] ?? 'Chimyon School');
$meta_description = "Chimyon Schoolning malakali va tajribali o'qituvchilari bilan tanishing.";
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1a3a5c;
            --primary-dark: #0f263d;
            --secondary: #c9a962;
            --secondary-light: #e6c88b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --white: #ffffff;
            --light-bg: #f9fafb;
            --border: #e5e7eb;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Manrope', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
            background-color: var(--white);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section-padding {
            padding: 100px 0;
        }
        
        .text-center {
            text-align: center;
        }
        
        .section-title {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-subtitle {
            color: var(--secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .section-desc {
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto 3rem;
            font-size: 1.1rem;
        }
        
        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.4s ease;
            padding: 20px 0;
            background: transparent;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow);
            padding: 15px 0;
        }
        
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .navbar.scrolled .logo {
            color: var(--primary);
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }
        
        .nav-link {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.3s ease;
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .navbar.scrolled .nav-link {
            color: var(--primary);
        }
        
        .nav-link.active {
            color: var(--secondary);
        }
        
        .navbar.scrolled .nav-link.active {
            color: var(--secondary);
        }
        
        .mobile-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }
        
        .mobile-toggle span {
            width: 25px;
            height: 3px;
            background: var(--white);
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled .mobile-toggle span {
            background: var(--primary);
        }
        
        /* Hero Section */
        .page-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 180px 0 100px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .page-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z" fill="%23c9a962" fill-opacity="0.05" fill-rule="evenodd"/%3E%3C/svg%3E');
            opacity: 0.5;
        }
        
        .page-hero h1 {
            font-size: 3.5rem;
            color: var(--white);
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .page-hero p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        /* Teachers Grid */
        .teachers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .teacher-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            height: 400px;
            perspective: 1000px;
        }
        
        .teacher-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }
        
        .teacher-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }
        
        .teacher-card.flipped .teacher-inner {
            transform: rotateY(180deg);
        }
        
        .teacher-front, .teacher-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .teacher-front {
            background: var(--white);
        }
        
        .teacher-image-wrapper {
            height: 280px;
            overflow: hidden;
            position: relative;
        }
        
        .teacher-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .teacher-card:hover .teacher-image {
            transform: scale(1.1);
        }
        
        .teacher-info {
            padding: 20px;
        }
        
        .teacher-name {
            font-size: 1.4rem;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .teacher-specialty {
            color: var(--secondary);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        
        .teacher-experience {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .teacher-back {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }
        
        .teacher-bio {
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 25px;
        }
        
        .teacher-social {
            display: flex;
            gap: 15px;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: var(--secondary);
            transform: translateY(-3px);
        }
        
        .flip-hint {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--secondary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .flip-hint:hover {
            transform: rotate(180deg);
            background: var(--secondary-light);
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-light) 100%);
            padding: 80px 0;
            text-align: center;
        }
        
        .cta-title {
            font-size: 2.2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .cta-text {
            color: var(--primary-dark);
            max-width: 600px;
            margin: 0 auto 2rem;
            font-size: 1.1rem;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(26, 58, 92, 0.3);
        }
        
        .btn-secondary {
            background: var(--white);
            color: var(--primary);
        }
        
        .btn-secondary:hover {
            background: var(--light-bg);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        
        /* Footer */
        footer {
            background: var(--primary-dark);
            color: var(--white);
            padding: 70px 0 30px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .footer-col h3 {
            font-size: 1.4rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--secondary);
        }
        
        .footer-about p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }
        
        .social-icon:hover {
            background: var(--secondary);
            transform: translateY(-5px);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-links a:hover {
            color: var(--secondary);
            transform: translateX(5px);
        }
        
        .contact-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .contact-item i {
            color: var(--secondary);
            font-size: 1.2rem;
            margin-top: 5px;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }
        
        /* Mobile Responsive */
        @media (max-width: 992px) {
            .section-title {
                font-size: 2.2rem;
            }
            
            .teachers-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .mobile-toggle {
                display: flex;
            }
            
            .nav-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 80%;
                max-width: 400px;
                height: 100vh;
                background: var(--white);
                flex-direction: column;
                padding: 100px 30px;
                gap: 20px;
                transition: right 0.4s cubic-bezier(0.77, 0, 0.175, 1);
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            }
            
            .nav-menu.active {
                right: 0;
            }
            
            .nav-link {
                color: var(--primary);
                font-size: 1.2rem;
            }
            
            .page-hero {
                padding: 150px 0 80px;
            }
            
            .page-hero h1 {
                font-size: 2.5rem;
            }
            
            .section-padding {
                padding: 70px 0;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .teachers-grid {
                grid-template-columns: 1fr;
            }
            
            .cta-title {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .page-hero h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container navbar-container">
            <a href="index.php" class="logo"><?= htmlspecialchars($settings['site_name'] ?? 'Chimyon School') ?></a>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link">Bosh sahifa</a></li>
                <li><a href="about.php" class="nav-link">Maktab haqida</a></li>
                <li><a href="education.php" class="nav-link">Ta'lim dasturi</a></li>
                <li><a href="teachers.php" class="nav-link active">O'qituvchilar</a></li>
                <li><a href="gallery.php" class="nav-link">Infratuzilma</a></li>
                <li><a href="news.php" class="nav-link">Yangiliklar</a></li>
                <li><a href="contact.php" class="nav-link">Aloqa</a></li>
            </ul>
            
            <div class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <h1 data-aos="fade-up" data-aos-duration="1000">Bizning O'qituvchilar</h1>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">Malakali, tajribali va farzandingiz kelajagi uchun jon kuydiradigan ustozlar</p>
        </div>
    </section>

    <!-- Teachers Section -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center">
                <span class="section-subtitle" data-aos="fade-up">Jamoa</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Bizning Ustozlar</h2>
                <p class="section-desc" data-aos="fade-up" data-aos-delay="200">Har bir o'qituvchimiz o'z fanining mutaxassisi bo'lib, zamonaviy ta'lim texnologiyalarini mukammal egallagan.</p>
            </div>
            
            <div class="teachers-grid">
                <?php if (empty($teachers)): ?>
                    <!-- Demo ma'lumotlar (agar bazada ma'lumot bo'lmasa) -->
                    <?php 
                    $demo_teachers = [
                        ['id' => 1, 'ism' => 'Dildora Karimova', 'mutaxassislik' => 'Matematika', 'tajriba_yil' => 12, 'tavsif' => 'Oliy toifali matematika o\'qituvchisi. Xalqaro olimpiadalarda g\'olib shogirdlar tayyorlagan.', 'rasm' => ''],
                        ['id' => 2, 'ism' => 'Jamshidbek Aliyev', 'mutaxassislik' => 'Fizika', 'tajriba_yil' => 15, 'tavsif' => 'Fizika fanidan PhD darajasiga ega. Zamonaviy laboratoriya usullarini qo\'llaydi.', 'rasm' => ''],
                        ['id' => 3, 'ism' => 'Nargiza Umarova', 'mutaxassislik' => 'Ingliz tili', 'tajriba_yil' => 10, 'tavsif' => 'CELTA sertifikati sohibasi. Britaniyada ta\'lim olgan. IELTS natijalari yuqori.', 'rasm' => ''],
                        ['id' => 4, 'ism' => 'Rustam Sobirov', 'mutaxassislik' => 'Tarix', 'tajriba_yil' => 18, 'tavsif' => 'Tarix fanlari nomzodi. Interaktiv dars usullari bilan mashhur.', 'rasm' => ''],
                        ['id' => 5, 'ism' => 'Malika Tursunova', 'mutaxassislik' => 'Biologiya', 'tajriba_yil' => 9, 'tavsif' => 'Tibbiyot universitetini tamomlagan. Amaliy darslar ustasi.', 'rasm' => ''],
                        ['id' => 6, 'ism' => 'Anvar Nazarov', 'mutaxassislik' => 'Informatika', 'tajriba_yil' => 11, 'tavsif' => 'Dasturlash bo\'yicha xalqaro musobaqalar g\'olibi. Zamonaviy texnologiyalarni o\'rgatadi.', 'rasm' => ''],
                        ['id' => 7, 'ism' => 'Gulnora Rahimova', 'mutaxassislik' => 'Adabiyot', 'tajriba_yil' => 14, 'tavsif' => 'Shoir va yozuvchi. O\'quvchilarning ijodiy qobiliyatini rivojlantiradi.', 'rasm' => ''],
                        ['id' => 8, 'ism' => 'Botir Qodirov', 'mutaxassislik' => 'Jismoniy tarbiya', 'tajriba_yil' => 16, 'tavsif' => 'Sobiq professional sportchi. Salomatlik va sport muhabbatini uyg\'otadi.', 'rasm' => '']
                    ];
                    
                    foreach ($demo_teachers as $teacher): 
                    ?>
                    <div class="teacher-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?= ($teacher['id'] - 1) * 100 ?>" onclick="this.classList.toggle('flipped')">
                        <div class="teacher-inner">
                            <div class="teacher-front">
                                <div class="teacher-image-wrapper">
                                    <?php if (!empty($teacher['rasm']) && file_exists('uploads/teachers/' . $teacher['rasm'])): ?>
                                        <img src="uploads/teachers/<?= htmlspecialchars($teacher['rasm']) ?>" alt="<?= htmlspecialchars($teacher['ism']) ?>" class="teacher-image">
                                    <?php else: ?>
                                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop" alt="<?= htmlspecialchars($teacher['ism']) ?>" class="teacher-image">
                                    <?php endif; ?>
                                </div>
                                <div class="teacher-info">
                                    <h3 class="teacher-name"><?= htmlspecialchars($teacher['ism']) ?></h3>
                                    <p class="teacher-specialty"><?= htmlspecialchars($teacher['mutaxassislik']) ?></p>
                                    <p class="teacher-experience"><i class="fas fa-clock"></i> <?= $teacher['tajriba_yil'] ?> yillik tajriba</p>
                                </div>
                                <div class="flip-hint">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                            </div>
                            
                            <div class="teacher-back">
                                <h3 class="teacher-name" style="color: white;"><?= htmlspecialchars($teacher['ism']) ?></h3>
                                <p class="teacher-specialty" style="color: var(--secondary-light);"><?= htmlspecialchars($teacher['mutaxassislik']) ?></p>
                                <p class="teacher-bio"><?= htmlspecialchars($teacher['tavsif']) ?></p>
                                <div class="teacher-social">
                                    <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="social-link"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Bazadan olingan ma'lumotlar -->
                    <?php foreach ($teachers as $teacher): ?>
                    <div class="teacher-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?= ($teacher['id'] - 1) * 100 ?>" onclick="this.classList.toggle('flipped')">
                        <div class="teacher-inner">
                            <div class="teacher-front">
                                <div class="teacher-image-wrapper">
                                    <?php if (!empty($teacher['rasm']) && file_exists('uploads/teachers/' . $teacher['rasm'])): ?>
                                        <img src="uploads/teachers/<?= htmlspecialchars($teacher['rasm']) ?>" alt="<?= htmlspecialchars($teacher['ism']) ?>" class="teacher-image">
                                    <?php else: ?>
                                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop" alt="<?= htmlspecialchars($teacher['ism']) ?>" class="teacher-image">
                                    <?php endif; ?>
                                </div>
                                <div class="teacher-info">
                                    <h3 class="teacher-name"><?= htmlspecialchars($teacher['ism']) ?></h3>
                                    <p class="teacher-specialty"><?= htmlspecialchars($teacher['mutaxassislik']) ?></p>
                                    <p class="teacher-experience"><i class="fas fa-clock"></i> <?= $teacher['tajriba_yil'] ?> yillik tajriba</p>
                                </div>
                                <div class="flip-hint">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                            </div>
                            
                            <div class="teacher-back">
                                <h3 class="teacher-name" style="color: white;"><?= htmlspecialchars($teacher['ism']) ?></h3>
                                <p class="teacher-specialty" style="color: var(--secondary-light);"><?= htmlspecialchars($teacher['mutaxassislik']) ?></p>
                                <p class="teacher-bio"><?= htmlspecialchars($teacher['tavsif']) ?></p>
                                <div class="teacher-social">
                                    <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="social-link"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title" data-aos="fade-up">Farzandingiz Biz Bilan Kelajak Quradi</h2>
            <p class="cta-text" data-aos="fade-up" data-aos-delay="100">Hoziroq ariza qoldiring va bizning malakali o'qituvchilarimiz bilan tanishing</p>
            <div data-aos="fade-up" data-aos-delay="200">
                <a href="admission.php" class="btn btn-primary" style="margin-right: 15px;">Ariza qoldirish</a>
                <a href="contact.php" class="btn btn-secondary">Bog'lanish</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-about">
                    <h3><?= htmlspecialchars($settings['site_name'] ?? 'Chimyon School') ?></h3>
                    <p><?= htmlspecialchars($settings['about_text'] ?? 'Zamonaviy ta\'lim, yuqori sifatli bilim va farzandingiz kelajagi uchun eng yaxshi shart-sharoitlar.') ?></p>
                    <div class="social-links">
                        <a href="<?= htmlspecialchars($settings['telegram'] ?? '#') ?>" class="social-icon" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                        <a href="<?= htmlspecialchars($settings['instagram'] ?? '#') ?>" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="<?= htmlspecialchars($settings['facebook'] ?? '#') ?>" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?= htmlspecialchars($settings['youtube'] ?? '#') ?>" class="social-icon" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h3>Tezkor Havolalar</h3>
                    <ul class="footer-links">
                        <li><a href="about.php"><i class="fas fa-chevron-right"></i> Maktab haqida</a></li>
                        <li><a href="education.php"><i class="fas fa-chevron-right"></i> Ta'lim dasturi</a></li>
                        <li><a href="teachers.php"><i class="fas fa-chevron-right"></i> O'qituvchilar</a></li>
                        <li><a href="gallery.php"><i class="fas fa-chevron-right"></i> Infratuzilma</a></li>
                        <li><a href="news.php"><i class="fas fa-chevron-right"></i> Yangiliklar</a></li>
                        <li><a href="admission.php"><i class="fas fa-chevron-right"></i> Qabul</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Aloqa</h3>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?= htmlspecialchars($settings['address'] ?? 'Chimyon, Toshkent viloyati') ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span><?= htmlspecialchars($settings['phone'] ?? '+998 90 123 45 67') ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span><?= htmlspecialchars($settings['email'] ?? 'info@chimyonschool.uz') ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span><?= htmlspecialchars($settings['work_hours'] ?? 'Dushanba - Shanba: 8:00 - 18:00') ?></span>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['site_name'] ?? 'Chimyon School') ?>. Barcha huquqlar himoyalangan.</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 100
        });
        
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');
        
        mobileToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            
            // Animate hamburger icon
            const spans = mobileToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                spans[0].style.transform = '';
                spans[1].style.opacity = '';
                spans[2].style.transform = '';
            }
        });
        
        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                const spans = mobileToggle.querySelectorAll('span');
                spans[0].style.transform = '';
                spans[1].style.opacity = '';
                spans[2].style.transform = '';
            });
        });
        
        // Teacher card flip on click (already handled by onclick attribute)
        // Additional: close flipped cards when scrolling
        let lastScrollTop = 0;
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (Math.abs(lastScrollTop - scrollTop) > 100) {
                document.querySelectorAll('.teacher-card.flipped').forEach(card => {
                    card.classList.remove('flipped');
                });
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, false);
    </script>
</body>
</html>
