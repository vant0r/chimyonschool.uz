-- =====================================================================
-- CHIMYON SCHOOL — Ma'lumotlar bazasi tuzilmasi (MySQL)
-- Import qilish: phpMyAdmin > Import > ushbu faylni tanlang
-- yoki: mysql -u root -p chimyonschool < schema.sql
-- =====================================================================

SET NAMES utf8mb4;
SET time_zone = '+05:00';

-- Ma'lumotlar bazasini yaratish (ixtiyoriy — hosting'da odatda tayyor bo'ladi)
CREATE DATABASE IF NOT EXISTS `chimyonschool`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `chimyonschool`;

-- ---------------------------------------------------------------------
-- 1) admin — panelga kiruvchi yagona administrator
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `login`       VARCHAR(50)  NOT NULL UNIQUE,
  `parol_hash`  VARCHAR(255) NOT NULL,
  `yaratilgan`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Standart admin BROWSER orqali "install.php" ni ochib yaratiladi
-- (u yerda parol bcrypt bilan xavfsiz hash qilinadi).
-- Standart: login = admin , parol = admin12345
-- Kirgandan keyin Sozlamalar bo'limidan parolni ALBATTA o'zgartiring!

-- ---------------------------------------------------------------------
-- 2) news — yangiliklar
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `news` (
  `id`               INT AUTO_INCREMENT PRIMARY KEY,
  `sarlavha`         VARCHAR(255) NOT NULL,
  `qisqa_tavsif`     TEXT,
  `matn`             LONGTEXT,
  `rasm`             VARCHAR(255),
  `holat`            ENUM('chop_etilgan','qoralama') DEFAULT 'qoralama',
  `seo_title`        VARCHAR(255),
  `seo_description`  VARCHAR(500),
  `sana`             TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 3) admissions — qabul arizalari
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admissions` (
  `id`             INT AUTO_INCREMENT PRIMARY KEY,
  `ism_familiya`   VARCHAR(150) NOT NULL,
  `tugilgan_sana`  DATE,
  `sinf`           VARCHAR(50),
  `telefon`        VARCHAR(30) NOT NULL,
  `hujjat_fayl`    VARCHAR(255),
  `holat`          ENUM('yangi','korilmoqda','qabul','rad') DEFAULT 'yangi',
  `sana`           TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 4) teachers — o'qituvchilar
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `teachers` (
  `id`             INT AUTO_INCREMENT PRIMARY KEY,
  `ism`            VARCHAR(150) NOT NULL,
  `rasm`           VARCHAR(255),
  `mutaxassislik`  VARCHAR(150),
  `tajriba_yil`    INT DEFAULT 0,
  `tavsif`         TEXT,
  `tartib`         INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 5) gallery — infratuzilma galereyasi
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gallery` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `rasm`       VARCHAR(255) NOT NULL,
  `kategoriya` VARCHAR(80) DEFAULT 'umumiy',
  `sana`       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 6) pages — statik sahifalar kontenti (about, pricing, ...)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pages` (
  `id`               INT AUTO_INCREMENT PRIMARY KEY,
  `slug`             VARCHAR(80) NOT NULL UNIQUE,
  `sarlavha`         VARCHAR(255),
  `matn`             LONGTEXT,
  `seo_title`        VARCHAR(255),
  `seo_description`  VARCHAR(500)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 7) settings — umumiy sozlamalar (bitta qator)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `settings` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `telefon`    VARCHAR(50),
  `email`      VARCHAR(100),
  `manzil`     VARCHAR(255),
  `ish_vaqti`  VARCHAR(150),
  `telegram`   VARCHAR(255),
  `instagram`  VARCHAR(255),
  `xarita_lat` VARCHAR(50),
  `xarita_lng` VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Standart sozlamalar qatori
INSERT INTO `settings`
  (`id`, `telefon`, `email`, `manzil`, `ish_vaqti`, `telegram`, `instagram`, `xarita_lat`, `xarita_lng`)
VALUES
  (1, '+998 90 123 45 67', 'info@chimyonschool.uz', 'Farg\'ona viloyati, Chimyon tumani',
   'Dushanba–Shanba, 08:00–18:00', 'https://t.me/chimyonschool', 'https://instagram.com/chimyonschool',
   '40.0333', '71.7167')
  ON DUPLICATE KEY UPDATE `id` = `id`;

-- ---------------------------------------------------------------------
-- 8) messages — aloqa formasi xabarlari
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `messages` (
  `id`        INT AUTO_INCREMENT PRIMARY KEY,
  `ism`       VARCHAR(150) NOT NULL,
  `aloqa`     VARCHAR(150) NOT NULL,
  `xabar`     TEXT NOT NULL,
  `oqilgan`   TINYINT(1) DEFAULT 0,
  `sana`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Namuna ma'lumotlar (dastlabki ko'rinish uchun)
-- ---------------------------------------------------------------------
INSERT INTO `pages` (`slug`, `sarlavha`, `matn`, `seo_title`, `seo_description`) VALUES
  ('about', 'Maktab haqida', 'Chimyon School — zamonaviy va sifatli ta\'lim maskani.', 'Maktab haqida — Chimyon School', 'Chimyon School tarixi, missiyasi va qadriyatlari haqida.'),
  ('pricing', 'Narxlar va shartlar', 'Bizning narxlar shaffof va qulay to\'lov shartlari bilan.', 'Narxlar — Chimyon School', 'Chimyon School o\'quv to\'lovlari, chegirmalar va shartlari.')
  ON DUPLICATE KEY UPDATE `slug` = `slug`;

INSERT INTO `teachers` (`ism`, `rasm`, `mutaxassislik`, `tajriba_yil`, `tavsif`, `tartib`) VALUES
  ('Dilnoza Karimova', 'teacher-1.png', 'Matematika o\'qituvchisi', 12, 'Oliy toifali matematika o\'qituvchisi, xalqaro olimpiada g\'oliblari ustozi.', 1),
  ('Jasur Rahimov', 'teacher-2.png', 'Ingliz tili o\'qituvchisi', 9, 'IELTS 8.0, zamonaviy kommunikativ metodika mutaxassisi.', 2),
  ('Nigora Yusupova', 'teacher-3.png', 'Kimyo va biologiya', 15, 'Fan nomzodi, tabiiy fanlar bo\'yicha yetakchi mutaxassis.', 3),
  ('Sardor Aliyev', 'teacher-4.png', 'Fizika o\'qituvchisi', 7, 'STEM yo\'nalishi bo\'yicha innovatsion darslar muallifi.', 4)
  ON DUPLICATE KEY UPDATE `ism` = `ism`;

INSERT INTO `news` (`sarlavha`, `qisqa_tavsif`, `matn`, `rasm`, `holat`, `seo_title`, `seo_description`) VALUES
  ('Yangi o\'quv yili tantanali ochildi', 'Chimyon School 2026–2027 o\'quv yilini zamonaviy sinflar bilan boshladi.', '<p>Chimyon School yangi o\'quv yilini katta tantana bilan boshladi. Bu yil maktabimizga rekord darajada o\'quvchilar qabul qilindi.</p>', 'news-1.png', 'chop_etilgan', 'Yangi o\'quv yili ochildi', 'Chimyon School yangi o\'quv yili tantanasi haqida.'),
  ('Olimpiada g\'oliblari taqdirlandi', 'O\'quvchilarimiz viloyat fan olimpiadasida yuqori natijalarni qo\'lga kiritdi.', '<p>Maktabimiz o\'quvchilari viloyat bosqichida 12 ta medalni qo\'lga kiritdi.</p>', 'news-2.png', 'chop_etilgan', 'Olimpiada g\'oliblari', 'Chimyon School olimpiada natijalari.'),
  ('Zamonaviy laboratoriya ochildi', 'Maktabda yangi kimyo-fizika laboratoriyasi foydalanishga topshirildi.', '<p>Yangi laboratoriya eng zamonaviy jihozlar bilan ta\'minlangan.</p>', 'news-3.png', 'chop_etilgan', 'Yangi laboratoriya', 'Chimyon School yangi laboratoriyasi.')
  ON DUPLICATE KEY UPDATE `sarlavha` = `sarlavha`;

INSERT INTO `gallery` (`rasm`, `kategoriya`) VALUES
  ('gallery-1.png', 'sinflar'),
  ('gallery-2.png', 'laboratoriya'),
  ('gallery-3.png', 'sport'),
  ('gallery-4.png', 'oshxona'),
  ('gallery-5.png', 'hovli'),
  ('gallery-6.png', 'sinflar')
  ON DUPLICATE KEY UPDATE `rasm` = `rasm`;
