<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-nav { background: #343a40; padding: 1rem 0; margin-bottom: 2rem; }
        .admin-nav-container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; display: flex; justify-content: space-between; align-items: center; }
        .admin-nav-links { display: flex; gap: 1rem; flex-wrap: wrap; }
        .admin-nav-links a { color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px; transition: background 0.3s; }
        .admin-nav-links a:hover { background: rgba(255,255,255,0.1); }
        .admin-nav-links a.active { background: #007bff; }
        .logout-btn { background: #dc3545; }
    </style>
</head>
<body>
    <nav class="admin-nav">
        <div class="admin-nav-container">
            <div class="admin-nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="news.php">Yangiliklar</a>
                <a href="admissions.php">Qabul</a>
                <a href="messages.php">Xabarlar</a>
                <a href="teachers.php">O'qituvchilar</a>
                <a href="gallery.php">Galereya</a>
                <a href="settings.php">Sozlamalar</a>
            </div>
            <div>
                <a href="../index.php" target="_blank">Saytni ko'rish</a>
                <a href="logout.php" class="logout-btn">Chiqish</a>
            </div>
        </div>
    </nav>
</body>
</html>
