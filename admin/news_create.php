<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image = '';

    if (empty($title) || empty($content)) {
        $error = "Sarlavha va matn majburiy!";
    } else {
        // Rasm yuklash
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/news/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array(strtolower($ext), $allowed)) {
                $filename = uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
                    $image = 'news/' . $filename;
                } else {
                    $error = "Rasmni yuklashda xatolik!";
                }
            } else {
                $error = "Faqat JPG, PNG, GIF, WEBP formatlari ruxsat etiladi!";
            }
        }

        if (empty($error)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO news (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->execute([$title, $content, $image]);
                header('Location: news.php?created=1');
                exit;
            } catch (PDOException $e) {
                $error = "Ma'lumotlar bazasiga saqlashda xatolik: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yangi Yangilik Qo'shish - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; }
        textarea { min-height: 200px; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; text-decoration: none; display: inline-block; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="admin-container">
        <div class="header-actions">
            <h1>Yangi Yangilik Qo'shish</h1>
            <a href="news.php" class="btn btn-secondary">Ortga qaytish</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Sarlavha *</label>
                <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="content">Matn *</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Rasm (ixtiyoriy)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</body>
</html>
