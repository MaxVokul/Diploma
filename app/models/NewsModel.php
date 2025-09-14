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
    public function getFullNews($id) {
        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, 
                u.username as author_name, u.id as author_id
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                WHERE n.id = :id AND n.is_published = 1";

        $result = $this->db->query($sql, ['id' => $id]);
        return !empty($result) ? $result[0] : null;
    }

    // Получить все категории
    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->db->query($sql);
    }
}