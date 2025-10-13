<?php
session_start();

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

if (empty($email)) $errors[] = "Email обязателен";
if (empty($password)) $errors[] = "Пароль обязателен";

if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    header('Location: /index.php');
    exit();
}

$userModel = new UserModel();
$user = $userModel->login($email, $password);

if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    // Перенаправляем на ту страницу, с которой пришли (например, после клика на "Войти" из профиля)
    $redirect = $_SESSION['redirect_to'] ?? '/index.php';
    unset($_SESSION['redirect_to']);
    header("Location: $redirect");
    exit();
} else {
    $_SESSION['login_errors'] = ["Неверный email или пароль"];
    header('Location: /index.php');
    exit();
}