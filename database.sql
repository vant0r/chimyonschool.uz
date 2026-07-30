-- Chimyon School Ma'lumotlar Bazasi
-- MySQL versiyasi

CREATE DATABASE IF NOT EXISTS chimyonschool CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE chimyonschool;

-- Admin jadvali
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    parol_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin (login: admin, parol: admin123)
INSERT INTO admin (login, parol_hash) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Yangiliklar jadvali
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sarlavha VARCHAR(255) NOT NULL,
    qisqa_tavsif TEXT,
    matn LONGTEXT,
    rasm VARCHAR(255),
    holat ENUM('published', 'draft') DEFAULT 'draft',
    seo_title VARCHAR(255),
    seo_description TEXT,
    sana DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Qabul arizalari jadvali
CREATE TABLE IF NOT EXISTS admissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ism_familiya VARCHAR(100) NOT NULL,
    tugilgan_sana DATE,
    sinf VARCHAR(20) NOT NULL,
    telefon VARCHAR(20) NOT NULL,
    ota_ona_ism VARCHAR(100),
    hujjat_fayl VARCHAR(255),
    izoh TEXT,
    holat ENUM('new', 'reviewing', 'accepted', 'rejected') DEFAULT 'new',
    sana DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- O'qituvchilar jadvali
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ism VARCHAR(100) NOT NULL,
    rasm VARCHAR(255),
    mutaxassislik VARCHAR(100),
    tajriba_yil INT DEFAULT 0,
    tavsif TEXT,
    facebook VARCHAR(255),
    instagram VARCHAR(255),
    telegram VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Galereya jadvali
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rasm VARCHAR(255) NOT NULL,
    kategoriya VARCHAR(50),
    tavsif TEXT,
    tartib INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sahifalar jadvali
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) UNIQUE NOT NULL,
    sarlavha VARCHAR(255) NOT NULL,
    matn LONGTEXT,
    seo_title VARCHAR(255),
    seo_description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sozlamalar jadvali
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telefon VARCHAR(20),
    email VARCHAR(100),
    manzil TEXT,
    ish_vaqti VARCHAR(100),
    telegram VARCHAR(255),
    instagram VARCHAR(255),
    facebook VARCHAR(255),
    xarita_lat DECIMAL(10, 8),
    xarita_lng DECIMAL(11, 8),
    logo VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default sozlamalar
INSERT INTO settings (telefon, email, manzil, ish_vaqti) VALUES 
('+998 71 200 00 00', 'info@chimyonschool.uz', 'Chimyon sh., Maktab ko''chasi 1', 'Dush-Shan: 8:00 - 18:00');

-- Demo yangiliklar
INSERT INTO news (sarlavha, qisqa_tavsif, matn, rasm, holat, sana) VALUES
('O''quvchilarimiz olimpiadada g''olib bo''ldi', 'Maktabimiz o''quvchilari respublika fan olimpiadasida faxrli o''rinlarni egalladi.', 'Bizning maktab o''quvchilari har doim katta yutuqlarga erishib kelmoqda. Bu safar ham ular o''z bilimlarini isbotladilar...', 'news1.jpg', 'published', NOW()),
('Yangi o''quv yili boshlandi', '2024-2025 o''quv yili uchun qabul e''lon qilindi.', 'Hurmatli ota-onalar! Maktabimizga 1-11 sinflarga qabul boshlandi. Barcha ma''lumotlarni qabul bo''limidan olishingiz mumkin...', 'news2.jpg', 'published', NOW()),
('Sport musobaqasi', 'Futbol bo''yicha maktablararo musobaqada jamoamiz g''olib chiqdi.', 'Tuman miqyosida o''tkazilgan futbol musobaqasida maktabimiz jamoasi birinchi o''rinni egalladi...', 'news3.jpg', 'published', NOW());

-- Demo o''qituvchilar
INSERT INTO teachers (ism, rasm, mutaxassislik, tajriba_yil, tavsif) VALUES
('Dilshod Rahimov', 'teacher1.jpg', 'Matematika o''qituvchisi', 12, 'Oliy toifali matematika o''qituvchisi'),
('Gulina Azimova', 'teacher2.jpg', 'Ingliz tili', 8, 'IELTS 8.0, Cambridge sertifikati'),
('Bahriddin Yusupov', 'teacher3.jpg', 'Fizika', 15, 'Fan nomzodi, olimpiada murabbiyi'),
('Malika Karimova', 'teacher4.jpg', 'Ona tili va adabiyot', 10, 'Oliy toifali o''qituvchi');

-- Demo galereya
INSERT INTO gallery (rasm, kategoriya) VALUES
('gallery1.jpg', 'Sinf xonalari'),
('gallery2.jpg', 'Laboratoriya'),
('gallery3.jpg', 'Sport zali'),
('gallery4.jpg', 'Oshxona'),
('gallery5.jpg', 'Hovli'),
('gallery6.jpg', 'Kutubxona');

-- Demo sahifalar
INSERT INTO pages (slug, sarlavha, matn) VALUES
('about', 'Maktab haqida', 'Chimyon xususiy maktabi 2010-yilda tashkil etilgan...'),
('pricing', 'Narxlar va shartlar', 'O''qish narxlari sinfga qarab farq qiladi...');
