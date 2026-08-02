<?php
require_once '../config/config.php';
require_once '../config/functions.php';
check_admin_session();

// Statistikani olish
$stmt = $pdo->query("SELECT COUNT(*) as total FROM admissions");
$total_admissions = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM messages");
$total_messages = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM teachers");
$total_teachers = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM news");
$total_news = $stmt->fetch()['total'];

// Oxirgi arizalar
$stmt = $pdo->query("SELECT * FROM admissions ORDER BY created_at DESC LIMIT 5");
$recent_admissions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boshqaruv Paneli - Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        .recent-section {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>Boshqaruv Paneli</h1>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_admissions; ?></div>
                <div class="stat-label">Jami Arizalar</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_messages; ?></div>
                <div class="stat-label">Xabarlar</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_teachers; ?></div>
                <div class="stat-label">O'qituvchilar</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_news; ?></div>
                <div class="stat-label">Yangiliklar</div>
            </div>
        </div>

        <div class="recent-section">
            <h2>Oxirgi Arizalar</h2>
            <table>
                <thead>
                    <tr>
                        <th>Ism</th>
                        <th>Email</th>
                        <th>Sana</th>
                        <th>Holat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recent_admissions as $admission): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admission['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($admission['email']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($admission['created_at'])); ?></td>
                        <td>
                            <span style="color: <?php echo $admission['status'] == 'pending' ? 'orange' : 'green'; ?>">
                                <?php echo $admission['status'] == 'pending' ? 'Ko\'rib chiqilmoqda' : 'Tasdiqlangan'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
