<?php
require_once '../config/config.php';
require_once '../config/functions.php';
check_admin_session();

// Rasm o'chirish
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT photo FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetch();
    
    if ($image && !empty($image['photo'])) {
        $file_path = '../uploads/gallery/' . $image['photo'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: gallery.php?success=deleted');
    exit;
}

// Rasm yuklash
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photos'])) {
    $upload_dir = '../uploads/gallery/';
    
    foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['photos']['error'][$key] == 0) {
            $file = [
                'name' => $_FILES['photos']['name'][$key],
                'type' => $_FILES['photos']['type'][$key],
                'tmp_name' => $_FILES['photos']['tmp_name'][$key],
                'error' => $_FILES['photos']['error'][$key],
                'size' => $_FILES['photos']['size'][$key]
            ];
            
            $upload_result = upload_file($file, $upload_dir);
            if ($upload_result['success']) {
                $stmt = $pdo->prepare("INSERT INTO gallery (photo) VALUES (?)");
                $stmt->execute([$upload_result['filename']]);
            } else {
                $errors[] = $upload_result['message'];
            }
        }
    }
    
    if (empty($errors)) {
        header('Location: gallery.php?success=uploaded');
        exit;
    }
}

// Rasmlarni olish
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
$images = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galereya Boshqaruvi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .gallery-actions {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .gallery-item {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .gallery-item-actions {
            padding: 10px;
            text-align: center;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-delete:hover {
            background-color: #c82333;
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
        input[type="file"] {
            margin-bottom: 15px;
        }
        button {
            background-color: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #5a6fd6;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Galereya Boshqaruvi</h1>
        
        <?php if (isset($_GET['success']) && $_GET['success'] == 'uploaded'): ?>
            <div class="alert alert-success">Rasmlar muvaffaqiyatli yuklandi!</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
            <div class="alert alert-success">Rasm o'chirildi!</div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="gallery-actions">
            <h2>Yangi Rasmlar Yuklash</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="photos[]" multiple accept="image/*" required>
                <button type="submit">Yuklash</button>
            </form>
        </div>
        
        <h2>Mavjud Rasmlar (<?php echo count($images); ?>)</h2>
        <div class="gallery-grid">
            <?php foreach($images as $image): ?>
            <div class="gallery-item">
                <img src="../uploads/gallery/<?php echo htmlspecialchars($image['photo']); ?>" alt="Gallery Image">
                <div class="gallery-item-actions">
                    <a href="gallery.php?delete=<?php echo $image['id']; ?>" class="btn-delete" onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">O'chirish</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
