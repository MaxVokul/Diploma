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

    // Проверить, что email свободен (кроме текущего пользователя)
    public function isEmailAvailableForUser($email, $userId) {
        $sql = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $result = $this->db->query($sql, ['email' => $email]);
        if (empty($result)) return true;
        return (int)$result[0]['id'] === (int)$userId;
    }

    // Обновить пароль пользователя (при предварительной проверке текущего пароля)
    public function updatePassword($userId, $currentPlainPassword, $newPlainPassword) {
        $user = $this->findById($userId);
        if (!$user) return false;
        if (!password_verify($currentPlainPassword, $user['password_hash'])) {
            return false;
        }
        $newHash = password_hash($newPlainPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['password_hash' => $newHash]);
    }

    // Отметить статью как прочитанную пользователем
    public function markArticleAsRead($userId, $articleId, $categoryId) {
        $sql = "INSERT IGNORE INTO user_article_reads (user_id, article_id, category_id) 
                VALUES (:user_id, :article_id, :category_id)";
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $result = $stmt->execute([
                ':user_id' => $userId,
                ':article_id' => $articleId,
                ':category_id' => $categoryId
            ]);
            
            // Если статья была прочитана впервые, обновляем интересы пользователя
            if ($stmt->rowCount() > 0) {
                $this->updateUserInterestsFromReads($userId);
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Ошибка при отметке статьи как прочитанной: " . $e->getMessage());
            return false;
        }
    }

    // Получить статистику прочитанных статей пользователя
    public function getReadStats($userId) {
        $sql = "SELECT 
                    COUNT(DISTINCT uar.article_id) as articles_read,
                    COUNT(DISTINCT uar.category_id) as categories_read,
                    (SELECT COUNT(*) FROM user_interests WHERE user_id = :user_id2) as following
                FROM user_article_reads uar 
                WHERE uar.user_id = :user_id";
        
        $result = $this->db->query($sql, ['user_id' => $userId, 'user_id2' => $userId]);
        return !empty($result) ? $result[0] : ['articles_read' => 0, 'categories_read' => 0, 'following' => 0];
    }

    // Обновить интересы пользователя на основе прочитанных статей
    private function updateUserInterestsFromReads($userId) {
        // Получаем топ-5 категорий по количеству прочитанных статей
        $sql = "SELECT category_id, COUNT(*) as read_count 
                FROM user_article_reads 
                WHERE user_id = :user_id 
                GROUP BY category_id 
                ORDER BY read_count DESC 
                LIMIT 5";
        
        $topCategories = $this->db->query($sql, ['user_id' => $userId]);
        
        if (!empty($topCategories)) {
            // Очищаем старые интересы
            $this->db->execute("DELETE FROM user_interests WHERE user_id = :user_id", ['user_id' => $userId]);
            
            // Добавляем новые интересы
            foreach ($topCategories as $category) {
                $this->db->execute(
                    "INSERT INTO user_interests (user_id, category_id, weight) VALUES (:user_id, :category_id, :weight)",
                    [
                        ':user_id' => $userId,
                        ':category_id' => $category['category_id'],
                        ':weight' => $category['read_count']
                    ]
                );
            }
        }
    }

    // Проверить, прочитал ли пользователь статью
    public function hasReadArticle($userId, $articleId) {
        $sql = "SELECT id FROM user_article_reads WHERE user_id = :user_id AND article_id = :article_id LIMIT 1";
        $result = $this->db->query($sql, ['user_id' => $userId, 'article_id' => $articleId]);
        return !empty($result);
    }

    // Получить интересы пользователя из таблицы user_interests
    public function getUserInterests($userId) {
        $sql = "SELECT c.name, c.slug, ui.weight 
                FROM user_interests ui 
                JOIN categories c ON ui.category_id = c.id 
                WHERE ui.user_id = :user_id 
                ORDER BY ui.weight DESC";
        return $this->db->query($sql, ['user_id' => $userId]);
    }
}