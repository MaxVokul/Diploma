<?php
session_start();
require_once '../app/core/Database.php';
require_once '../app/models/UserModel.php';

// Check authorization and admin rights
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

$userModel = new UserModel();
if (!$userModel->isAdmin($_SESSION['user_id'])) {
    header('Location: /profile.php');
    exit();
}

// Скачивание файла
if (isset($_GET['file'])) {
    $fileName = basename($_GET['file']);
    $filePath = __DIR__ . '/../backups/' . $fileName;

    if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'sql') {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}

// Если файл не найден
header('Location: /admin/backup.php');
exit;
?>