<?php
session_start();

require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/UserModel.php';

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

$current = $_POST['current_password'] ?? '';
$new = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (empty($current) || empty($new) || empty($confirm)) {
    $_SESSION['profile_error'] = 'Заполните все поля для смены пароля.';
    header('Location: /profile.php');
    exit();
}

if ($new !== $confirm) {
    $_SESSION['profile_error'] = 'Новый пароль и подтверждение не совпадают.';
    header('Location: /profile.php');
    exit();
}

if (strlen($new) < 6) {
    $_SESSION['profile_error'] = 'Длина нового пароля должна быть не менее 6 символов.';
    header('Location: /profile.php');
    exit();
}

$userModel = new UserModel();
$updated = $userModel->updatePassword($_SESSION['user_id'], $current, $new);

if ($updated) {
    $_SESSION['profile_success'] = 'Пароль успешно изменён.';
} else {
    $_SESSION['profile_error'] = 'Текущий пароль неверен или произошла ошибка.';
}

header('Location: /profile.php');
exit();
?>




