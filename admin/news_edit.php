<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: news.php');
    exit;
}

$id = (int)$_GET['id'];
$error = '';
$success = '';

// Joriy ma'lumotlarni olish
try {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $news = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$news) {
        header('Location: news.php');
        exit;
    }
} catch (PDOException $e) {
    $error = "Ma'lumotlarni yuklashda xatolik: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image = $news['image']; // Eski rasmni saqlash

    if (empty($title) || empty($content)) {
        $error = "Sarlavha va matn majburiy!";
    } else {
        // Yangi rasm yuklash
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/news/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array(strtolower($ext), $allowed)) {
                // Eski rasmni o'chirish
                if ($news['image'] && file_exists('../uploads/' . $news['image'])) {
                    unlink('../uploads/' . $news['image']);
                }

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
                $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ?, image = ? WHERE id = ?");
                $stmt->execute([$title, $content, $image, $id]);
                header('Location: news.php?updated=1');
                exit;
            } catch (PDOException $e) {
                $error = "Yangilashda xatolik: " . $e->getMessage();
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
    <title>Yangilikni Tahrirlash - Admin Panel</title>
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
        .current-image { margin-top: 0.5rem; }
        .current-image img { max-width: 200px; border-radius: 4px; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="admin-container">
        <div class="header-actions">
            <h1>Yangilikni Tahrirlash</h1>
            <a href="news.php" class="btn btn-secondary">Ortga qaytish</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Sarlavha *</label>
                <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($news['title']); ?>">
            </div>

            <div class="form-group">
                <label for="content">Matn *</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($news['content']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Yangi Rasm (ixtiyoriy)</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if ($news['image']): ?>
                    <div class="current-image">
                        <p>Joriy rasm:</p>
                        <img src="<?php echo htmlspecialchars(upload_url($news['image'])); ?>" alt="Joriy rasm">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Saqlash</button>
        </form>
    </div>
</body>
</html>
