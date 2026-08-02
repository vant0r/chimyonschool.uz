<?php
require_once '../config/config.php';
require_once '../config/functions.php';
check_admin_session();

$errors = [];
$success = '';

if (!isset($_GET['id'])) {
    header('Location: teachers.php');
    exit;
}

$id = (int)$_GET['id'];

// O'qituvchi ma'lumotlarini olish
$stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = ?");
$stmt->execute([$id]);
$teacher = $stmt->fetch();

if (!$teacher) {
    header('Location: teachers.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = clean_input($_POST['full_name']);
    $subject = clean_input($_POST['subject']);
    $experience = clean_input($_POST['experience']);
    $bio = clean_input($_POST['bio']);
    
    $photo = $teacher['photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Eski rasmni o'chirish
        if (!empty($teacher['photo']) && file_exists('../uploads/teachers/' . $teacher['photo'])) {
            unlink('../uploads/teachers/' . $teacher['photo']);
        }
        
        $upload_result = upload_file($_FILES['photo'], '../uploads/teachers/');
        if ($upload_result['success']) {
            $photo = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['message'];
        }
    }
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE teachers SET full_name = ?, subject = ?, experience = ?, bio = ?, photo = ? WHERE id = ?");
            $stmt->execute([$full_name, $subject, $experience, $bio, $photo, $id]);
            header('Location: teachers.php?success=updated');
            exit;
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
    <title>O'qituvchini Tahrirlash</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-container {
            max-width: 600px;
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
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        textarea {
            height: 150px;
            resize: vertical;
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
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .current-photo {
            margin-bottom: 15px;
        }
        .current-photo img {
            max-width: 200px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <a href="teachers.php" class="back-link">&larr; Orqaga</a>
        <h1>O'qituvchini Tahrirlash</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <?php if (!empty($teacher['photo'])): ?>
            <div class="current-photo">
                <img src="../uploads/teachers/<?php echo htmlspecialchars($teacher['photo']); ?>" alt="<?php echo htmlspecialchars($teacher['full_name']); ?>">
            </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name">Ism Familiya *</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($teacher['full_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Fan *</label>
                    <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($teacher['subject']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="experience">Tajriba (yillarda) *</label>
                    <input type="text" id="experience" name="experience" value="<?php echo htmlspecialchars($teacher['experience']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="bio">Qisqacha ma'lumot *</label>
                    <textarea id="bio" name="bio" required><?php echo htmlspecialchars($teacher['bio']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="photo">Yangi Rasm (ixtiyoriy)</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                
                <button type="submit">Saqlash</button>
            </form>
        </div>
    </div>
</body>
</html>
