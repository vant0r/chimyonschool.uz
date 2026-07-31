<?php
require_once '../config/config.php';
require_once '../config/functions.php';
check_admin_session();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = clean_input($_POST['full_name']);
    $subject = clean_input($_POST['subject']);
    $experience = clean_input($_POST['experience']);
    $bio = clean_input($_POST['bio']);
    
    // Rasm yuklash
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_result = upload_file($_FILES['photo'], '../uploads/teachers/');
        if ($upload_result['success']) {
            $photo = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['message'];
        }
    }
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO teachers (full_name, subject, experience, bio, photo) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$full_name, $subject, $experience, $bio, $photo]);
            header('Location: teachers.php?success=created');
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
    <title>Yangi O'qituvchi Qo'shish</title>
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
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <a href="teachers.php" class="back-link">&larr; Orqaga</a>
        <h1>Yangi O'qituvchi Qo'shish</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name">Ism Familiya *</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Fan *</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="experience">Tajriba (yillarda) *</label>
                    <input type="text" id="experience" name="experience" required>
                </div>
                
                <div class="form-group">
                    <label for="bio">Qisqacha ma'lumot *</label>
                    <textarea id="bio" name="bio" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="photo">Rasm</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                
                <button type="submit">Saqlash</button>
            </form>
        </div>
    </div>
</body>
</html>
