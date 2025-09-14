<?php

namespace models;
use Database;

class UserModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Авторизация пользователя
    public function login($email, $password)
    {
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
    public function register($data)
    {
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

        return $this->create($data);
    }

    // Поиск пользователя по email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        return !empty($result) ? $result[0] : null;
    }

    // Получить пользователя по ID
    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        return !empty($result) ? $result[0] : null;
    }

    // Создать нового пользователя
    public function create($data)
    {
        $fields = array_keys($data);
        $placeholders = array_map(function ($field) {
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
    public function update($id, $data)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $data['id'] = $id;

        return $this->db->execute($sql, $data);
    }
}