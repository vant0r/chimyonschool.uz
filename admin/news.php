<?php
session_start();
require_once '../config.php';

// Agar admin login qilmagan bo'lsa, login sahifasiga yo'naltirish
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Yangiliklar ro'yxatini olish
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    $stmt = $pdo->prepare("SELECT * FROM news ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Umumiy yangiliklar sonini hisoblash
    $count_stmt = $pdo->query("SELECT COUNT(*) as total FROM news");
    $total = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = ceil($total / $limit);
} catch (PDOException $e) {
    $error = "Yangiliklarni yuklashda xatolik: " . $e->getMessage();
}

// Yangilikni o'chirish
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $delete_stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $delete_stmt->execute([$_GET['delete']]);
        header('Location: news.php?deleted=1');
        exit;
    } catch (PDOException $e) {
        $error = "O'chirishda xatolik: " . $e->getMessage();
    }
}

// Xabar ko'rsatish
$success_msg = '';
if (isset($_GET['deleted'])) {
    $success_msg = "Yangilik muvaffaqiyatli o'chirildi!";
}
if (isset($_GET['created'])) {
    $success_msg = "Yangilik muvaffaqiyatli qo'shildi!";
}
if (isset($_GET['updated'])) {
    $success_msg = "Yangilik muvaffaqiyatli yangilandi!";
}
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yangiliklar Boshqaruvi - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .btn { padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-edit { background: #ffc107; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; border: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .pagination { margin-top: 1rem; display: flex; gap: 0.5rem; }
        .img-preview { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="admin-container">
        <div class="admin-header">
            <h1>Yangiliklar Boshqaruvi</h1>
            <a href="news_create.php" class="btn btn-primary">+ Yangi Yangilik</a>
        </div>

        <?php if ($success_msg): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_msg); ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rasm</th>
                    <th>Sarlavha</th>
                    <th>Sana</th>
                    <th>Harakatlar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($news)): ?>
                    <tr><td colspan="5" style="text-align:center;">Yangiliklar topilmadi</td></tr>
                <?php else: ?>
                    <?php foreach ($news as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['id']); ?></td>
                            <td>
                                <?php if ($item['image']): ?>
                                    <img src="<?php echo htmlspecialchars(upload_url($item['image'])); ?>" alt="Rasm" class="img-preview">
                                <?php else: ?>
                                    <span>No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($item['created_at'])); ?></td>
                            <td>
                                <a href="news_edit.php?id=<?php echo $item['id']; ?>" class="btn btn-edit">Tahrirlash</a>
                                <a href="news.php?delete=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">O'chirish</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="btn <?php echo $i === $page ? 'btn-primary' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
