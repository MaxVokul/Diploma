<?php
session_start();

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

// Обработка обновления предпочтений
if ($_POST && isset($_POST['categories'])) {
    $selectedCategories = $_POST['categories'];

    $userModel = new UserModel();
    $preferences = [
        'categories' => $selectedCategories
    ];

    if ($userModel->updatePreferences($_SESSION['user_id'], $preferences)) {
        $_SESSION['preferences'] = $preferences;
        header('Location: /profile.php?success=preferences_updated');
        exit();
    }
}

header('Location: /profile.php');
exit();
?>