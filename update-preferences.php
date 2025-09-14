<?php
session_start();

require_once __DIR__ . '/app/core/Database.php';      // Для Singleton
require_once __DIR__ . '/app/models/UserModel.php';   // КЛЮЧЕВОЙ ШАГ!

// Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

// Получаем данные из POST
$categories = $_POST['categories'] ?? [];

// Создаём экземпляр модели
$userModel = new UserModel();

// Обновляем предпочтения пользователя
$result = $userModel->updatePreferences($_SESSION['user_id'], ['categories' => $categories]);

if ($result) {
    $_SESSION['preferences'] = ['categories' => $categories]; // Обновляем сессию
    echo json_encode(['success' => true, 'message' => 'Preferences updated!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update preferences.']);
}
?>