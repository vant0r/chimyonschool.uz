<?php
require_once '../config/config.php';
require_once '../config/functions.php';
check_admin_session();

$errors = [];
$success = '';

// Joriy sozlamalarni olish
try {
    $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
    $settings = $stmt->fetch();
} catch(PDOException $e) {
    $settings = false;
}

// Agar jadval bo'sh bo'lsa, default qiymatlarni qo'shish
if (!$settings) {
    try {
        $pdo->exec("INSERT INTO settings (site_name, site_email, site_phone, site_address, primary_color, secondary_color, footer_text, facebook, instagram, telegram) 
                    VALUES ('Chimyon Maktabi', 'info@chimyon.uz', '+998 71 123 45 67', 'Toshkent viloyati, Chimyon', '#3498db', '#2c3e50', '© 2024 Chimyon Maktabi', '', '', '')");
        $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
        $settings = $stmt->fetch();
    } catch(PDOException $e) {
        $errors[] = "Sozlamalar bazasini yaratishda xatolik: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_name = clean_input($_POST['site_name']);
    $site_email = clean_input($_POST['site_email']);
    $site_phone = clean_input($_POST['site_phone']);
    $site_address = clean_input($_POST['site_address']);
    $primary_color = clean_input($_POST['primary_color']);
    $secondary_color = clean_input($_POST['secondary_color']);
    $footer_text = clean_input($_POST['footer_text']);
    $facebook = clean_input($_POST['facebook']);
    $instagram = clean_input($_POST['instagram']);
    $telegram = clean_input($_POST['telegram']);
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE settings SET 
                                    site_name = ?, 
                                    site_email = ?, 
                                    site_phone = ?, 
                                    site_address = ?, 
                                    primary_color = ?,
                                    secondary_color = ?,
                                    footer_text = ?,
                                    facebook = ?, 
                                    instagram = ?, 
                                    telegram = ? 
                                    WHERE id = ?");
            $stmt->execute([$site_name, $site_email, $site_phone, $site_address, $primary_color, $secondary_color, $footer_text, $facebook, $instagram, $telegram, $settings['id']]);
            $success = "Sozlamalar muvaffaqiyatli saqlandi!";
            
            // Yangilangan ma'lumotlarni qayta olish
            $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
            $settings = $stmt->fetch();
        } catch(PDOException $e) {
            $errors[] = "Xatolik: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sozlamalar</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #667eea;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #5a6fd6;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .section-title {
            margin-top: 30px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Sayt Sozlamalari</h1>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    <div class="form-container">
        <form method="POST">
            <h2 class="section-title">Asosiy Ma'lumotlar</h2>
            
            <div class="form-group">
                <label for="site_name">Sayt Nomi *</label>
                <input type="text" id="site_name" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? 'Chimyon Maktabi'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="site_email">Email *</label>
                <input type="email" id="site_email" name="site_email" value="<?php echo htmlspecialchars($settings['site_email'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="site_phone">Telefon *</label>
                <input type="text" id="site_phone" name="site_phone" value="<?php echo htmlspecialchars($settings['site_phone'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="site_address">Manzil *</label>
                <textarea id="site_address" name="site_address" rows="3" required><?php echo htmlspecialchars($settings['site_address'] ?? ''); ?></textarea>
            </div>
            
            <h2 class="section-title">Dizayn Sozlamalari (Ranglar)</h2>
            
            <div class="form-group">
                <label for="primary_color">Asosiy Rang (Primary Color) *</label>
                <input type="color" id="primary_color" name="primary_color" value="<?php echo htmlspecialchars($settings['primary_color'] ?? '#3498db'); ?>" style="width: 100px; height: 40px;">
                <small>Tugmalar, havolalar va sarlavhalar uchun asosiy rang</small>
            </div>
            
            <div class="form-group">
                <label for="secondary_color">Ikkinchi Rang (Secondary Color) *</label>
                <input type="color" id="secondary_color" name="secondary_color" value="<?php echo htmlspecialchars($settings['secondary_color'] ?? '#2c3e50'); ?>" style="width: 100px; height: 40px;">
                <small>Fon, footer va qo'shimcha elementlar uchun rang</small>
            </div>
            
            <div class="form-group">
                <label for="footer_text">Footer Matni</label>
                <textarea id="footer_text" name="footer_text" rows="2"><?php echo htmlspecialchars($settings['footer_text'] ?? ''); ?></textarea>
            </div>
            
            <h2 class="section-title">Ijtimoiy Tarmoqlar</h2>
            
            <div class="form-group">
                <label for="facebook">Facebook URL</label>
                <input type="text" id="facebook" name="facebook" value="<?php echo htmlspecialchars($settings['facebook'] ?? ''); ?>" placeholder="https://facebook.com/...">
            </div>
            
            <div class="form-group">
                <label for="instagram">Instagram URL</label>
                <input type="text" id="instagram" name="instagram" value="<?php echo htmlspecialchars($settings['instagram'] ?? ''); ?>" placeholder="https://instagram.com/...">
            </div>
            
            <div class="form-group">
                <label for="telegram">Telegram URL</label>
                <input type="text" id="telegram" name="telegram" value="<?php echo htmlspecialchars($settings['telegram'] ?? ''); ?>" placeholder="https://t.me/...">
            </div>
            
            <button type="submit">Saqlash</button>
        </form>
    </div>
    </div>
</body>
</html>
