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

include 'includes/header.php';
?>

<div class="admin-header">
    <h1>Boshqaruv Paneli</h1>
    <p>Xush kelibsiz! Bu yerda maktab boshqaruv tizimi statistikasi va so'nggi ma'lumotlar.</p>
</div>

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

<div class="table-container">
    <div class="table-header">
        <h2>Oxirgi Arizalar</h2>
        <a href="admissions.php" class="btn-admin btn-admin-secondary">Barchasini ko'rish</a>
    </div>
    <table class="admin-table">
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
                    <span class="status-badge status-<?php echo $admission['status'] == 'pending' ? 'pending' : 'approved'; ?>">
                        <?php echo $admission['status'] == 'pending' ? 'Ko\'rib chiqilmoqda' : 'Tasdiqlangan'; ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
