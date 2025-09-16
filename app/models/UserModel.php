<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/core/Database.php';
class UserModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Авторизация пользователя
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);

        if (!empty($result)) {
            $user = $result[0];
            if (password_verify($password, $user['password_hash'])) {
                // Обновляем время последнего входа
                $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
                return $user;
            }
        }
        return false;
    }

    // Регистрация нового пользователя
    public function register($data) {
        // Проверка уникальности email
        $existing = $this->findByEmail($data['email']);
        if ($existing) {
            return false;
        }

        // Хэширование пароля
        $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['last_login'] = date('Y-m-d H:i:s');

        // Установка значений по умолчанию
        if (!isset($data['preferences'])) {
            $data['preferences'] = json_encode(['categories' => []]);
        }

        return $this->create($data);
    }

    // Поиск пользователя по email
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        return !empty($result) ? $result[0] : null;
    }

    // Получить пользователя по ID
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        return !empty($result) ? $result[0] : null;
    }

    // Создать нового пользователя
    public function create($data) {
        $fields = array_keys($data);
        $placeholders = array_map(function($field) {
            return ":$field";
        }, $fields);

        $sql = "INSERT INTO users (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";

        if ($this->db->execute($sql, $data)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Обновить пользователя
    public function update($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $data['id'] = $id;

        return $this->db->execute($sql, $data);
    }

    // Обновление предпочтений пользователя
    public function updatePreferences($userId, $preferences) {
        $preferencesJson = json_encode($preferences);
        return $this->update($userId, ['preferences' => $preferencesJson]);
    }

    // Получение предпочтений пользователя
    public function getPreferences($userId) {
        $user = $this->findById($userId);
        if ($user && !empty($user['preferences'])) {
            return json_decode($user['preferences'], true);
        }
        return ['categories' => []];
    }
    // Проверяет, является ли пользователь администратором
    public function isAdmin($userId) {
        $sql = "SELECT `is_admin` FROM `users` WHERE `id` = :id LIMIT 1";
        $result = $this->db->query($sql, ['id' => $userId]);
        return !empty($result) && (bool)$result[0]['is_admin'];
    }
}