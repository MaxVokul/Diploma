<?php
session_start();

// Подключаем базу данных и модель пользователя
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

// Получаем данные формы
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$errors = [];

// Валидация
if (empty($name)) $errors[] = "Имя обязательно";
if (empty($email)) $errors[] = "Email обязателен";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Неверный формат email";
if (empty($password)) $errors[] = "Пароль обязателен";
if (strlen($password) < 6) $errors[] = "Пароль должен быть минимум 6 символов";
if ($password !== $confirm_password) $errors[] = "Пароли не совпадают";

if (!empty($errors)) {
    // Сохраняем ошибки в сессию и перенаправляем обратно
    $_SESSION['registration_errors'] = $errors;
    $_SESSION['old_input'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ];
    header('Location: /index.php');
    exit();
}

// Регистрация
$userModel = new UserModel();
$result = $userModel->register([
    'username' => $name,
    'email' => $email,
    'phone' => $phone,
    'password' => $password
]);

if ($result) {
    // Успешная регистрация — автоматически логинимся
    $user = $userModel->login($email, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        header('Location: /index.php');
        exit();
    }
} else {
    $_SESSION['registration_errors'][] = "Пользователь с таким email уже существует";
    $_SESSION['old_input'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ];
    header('Location: /index.php');
    exit();
}