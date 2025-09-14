<?php
// logout.php

// Начинаем сессию (обязательно!)
session_start();

// Уничтожаем все данные сессии
$_SESSION = [];

// Уничтожаем саму сессию
session_destroy();

// Удаляем куки сессии (если они есть)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Перенаправляем на главную страницу
header('Location: /index.php');
exit();