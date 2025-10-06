<?php
// admin/news/delete.php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/UserModel.php';
require_once '../../app/models/NewsModel.php';

// Проверка авторизации и прав администратора
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

$userModel = new UserModel();
if (!$userModel->isAdmin($_SESSION['user_id'])) {
    header('Location: /profile.php');
    exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: /admin/news/manage.php');
    exit();
}

$newsModel = new NewsModel();
// Предполагаем, что метод delete существует
$newsModel->delete($id);

header('Location: /admin/news/manage.php?deleted=1');
exit();
?>