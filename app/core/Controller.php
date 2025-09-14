<?php

use models\UserModel;

class Controller {
    protected $view;

    public function __construct() {
        $this->view = new View();
    }

    // Проверка авторизации
    protected function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit();
        }
    }

    // Получение текущего пользователя
    protected function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            $userModel = new UserModel();
            return $userModel->findById($_SESSION['user_id']);
        }
        return null;
    }

    // Редирект
    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}