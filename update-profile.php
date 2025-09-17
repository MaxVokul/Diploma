<?php
session_start();

require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/UserModel.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($username === '' || $email === '') {
    $_SESSION['profile_error'] = 'Имя пользователя и email обязательны.';
    header('Location: /profile.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['profile_error'] = 'Неверный формат email.';
    header('Location: /profile.php');
    exit();
}

$userModel = new UserModel();
if (!$userModel->isEmailAvailableForUser($email, $_SESSION['user_id'])) {
    $_SESSION['profile_error'] = 'Этот email уже занят другим пользователем.';
    header('Location: /profile.php');
    exit();
}

$updated = $userModel->update($_SESSION['user_id'], [
    'username' => $username,
    'email' => $email,
]);

if ($updated) {
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['profile_success'] = 'Профиль обновлён.';
} else {
    $_SESSION['profile_error'] = 'Не удалось обновить профиль.';
}

header('Location: /profile.php');
exit();
?>


