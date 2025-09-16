<?php

class NewsModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Получить последние новости
    public function getLatest($limit = 10, $offset = 0) {
        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, 
                u.username as author_name 
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                WHERE n.is_published = 1 
                ORDER BY n.published_at DESC 
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Получить новости по категории
    public function getByCategory($categoryId, $limit = 10, $offset = 0) {
        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, 
                u.username as author_name 
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                WHERE n.category_id = :category_id AND n.is_published = 1 
                ORDER BY n.published_at DESC 
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Получить новости по ключевому слову
    public function search($keyword, $limit = 10, $offset = 0) {
        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, 
                u.username as author_name 
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                WHERE (n.title LIKE :keyword OR n.content LIKE :keyword) 
                AND n.is_published = 1 
                ORDER BY n.published_at DESC 
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':keyword', "%{$keyword}%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Получить рекомендуемые новости для пользователя
    public function getRecommendedForUser($userId, $limit = 10) {
        // Получаем предпочтения пользователя
        $userModel = new UserModel();
        $preferences = $userModel->getPreferences($userId);

        if (empty($preferences['categories'])) {
            // Если нет предпочтений, возвращаем последние новости
            return $this->getLatest($limit);
        }

        // Формируем запрос для рекомендаций на основе предпочтений
        $categoryIds = implode(',', array_map('intval', $preferences['categories']));

        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, 
                u.username as author_name 
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                WHERE n.category_id IN ({$categoryIds}) AND n.is_published = 1 
                ORDER BY n.published_at DESC 
                LIMIT :limit";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll();

        // Если не хватает новостей, добавляем последние
        if (count($results) < $limit) {
            $additional = $this->getLatest($limit - count($results));
            $results = array_merge($results, $additional);
        }

        return $results;
    }

    // Увеличить счетчик просмотров
    public function incrementViews($id) {
        $sql = "UPDATE news SET views = views + 1 WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    // Получить полную информацию о новости
//    public function getFullNews($id) {
//        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug,
//                u.username as author_name, u.id as author_id
//                FROM news n
//                JOIN categories c ON n.category_id = c.id
//                JOIN users u ON n.author_id = u.id
//                WHERE n.id = :id AND n.is_published = 1";
//
//        $result = $this->db->query($sql, ['id' => $id]);
//        return !empty($result) ? $result[0] : null;
//    }

    // Получить все категории
    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->db->query($sql);
    }
    // Создать новость
    public function create($data) {
        $sql = "INSERT INTO `news` (`title`, `content`, `excerpt`, `category_id`, `author_id`, `published_at`, `is_published`, `image_url`) 
                VALUES (:title, :content, :excerpt, :category_id, :author_id, :published_at, :is_published, :image_url)";
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([
                ':title' => $data['title'],
                ':content' => $data['content'],
                ':excerpt' => $data['excerpt'],
                ':category_id' => $data['category_id'],
                ':author_id' => $data['author_id'],
                ':published_at' => $data['published_at'],
                ':is_published' => $data['is_published'],
                ':image_url' => $data['image_url']
            ]);
            return $this->db->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            error_log("Ошибка создания новости: " . $e->getMessage());
            return false;
        }
    }

    // Обновить новость
    public function update($id, $data) {
        $sql = "UPDATE `news` SET 
                `title` = :title, 
                `content` = :content, 
                `excerpt` = :excerpt, 
                `category_id` = :category_id, 
                `published_at` = :published_at, 
                `is_published` = :is_published, 
                `image_url` = :image_url 
                WHERE `id` = :id";
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':title' => $data['title'],
                ':content' => $data['content'],
                ':excerpt' => $data['excerpt'],
                ':category_id' => $data['category_id'],
                ':published_at' => $data['published_at'],
                ':is_published' => $data['is_published'],
                ':image_url' => $data['image_url']
            ]);
        } catch (PDOException $e) {
            error_log("Ошибка обновления новости ID $id: " . $e->getMessage());
            return false;
        }
    }

    // Удалить новость
    public function delete($id) {
        $sql = "DELETE FROM `news` WHERE `id` = :id";
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Ошибка удаления новости ID $id: " . $e->getMessage());
            return false;
        }
    }

    // Получить полную информацию о новости (включая автора и категорию)
    public function getFullNews($id) {
        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, u.username as author_name
                FROM `news` n
                JOIN `categories` c ON n.category_id = c.id
                JOIN `users` u ON n.author_id = u.id
                WHERE n.id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        return !empty($result) ? $result[0] : null;
    }
    // Получить категорию по её slug
    public function getCategoryBySlug($slug) {
        $sql = "SELECT * FROM `categories` WHERE `slug` = :slug LIMIT 1";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([':slug' => $slug]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null; // Вернуть результат или null, если не найдено
    }
}