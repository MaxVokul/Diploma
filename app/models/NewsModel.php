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


    // Увеличить счетчик просмотров
    public function incrementViews($id) {
        $sql = "UPDATE news SET views = views + 1 WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

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

    // Получить общее количество новостей в категории
    public function getCategoryCount($categoryId) {
        $sql = "SELECT COUNT(*) as total FROM news WHERE category_id = :category_id AND is_published = 1";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([':category_id' => $categoryId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    // Получить все новости для админ-панели с пагинацией и сортировкой
    public function getAllForAdmin($limit = 50, $offset = 0, $sortBy = 'id', $sortOrder = 'DESC') {
        // Валидация параметров сортировки
        $allowedSortFields = ['id', 'title', 'category_name', 'author_name', 'published_at', 'is_published'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'id';
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, 
                u.username as author_name 
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                ORDER BY {$sortBy} {$sortOrder}
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Получить общее количество всех новостей для админ-панели
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as total FROM news";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    // Поиск новостей для админ-панели с пагинацией и сортировкой
    public function searchForAdmin($searchTerm, $limit = 50, $offset = 0, $sortBy = 'id', $sortOrder = 'DESC') {
        // Валидация параметров сортировки
        $allowedSortFields = ['id', 'title', 'category_name', 'author_name', 'published_at', 'is_published'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'id';
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT n.*, c.name as category_name, c.slug as category_slug, 
                u.username as author_name 
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                WHERE (n.title LIKE :search1 OR n.content LIKE :search2 OR n.excerpt LIKE :search3 
                       OR c.name LIKE :search4 OR u.username LIKE :search5)
                ORDER BY {$sortBy} {$sortOrder}
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->getConnection()->prepare($sql);
        $searchPattern = "%{$searchTerm}%";
        $stmt->bindValue(':search1', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search2', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search3', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search4', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search5', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Получить количество результатов поиска
    public function getSearchCount($searchTerm) {
        $sql = "SELECT COUNT(*) as total 
                FROM news n 
                JOIN categories c ON n.category_id = c.id 
                JOIN users u ON n.author_id = u.id 
                WHERE (n.title LIKE :search1 OR n.content LIKE :search2 OR n.excerpt LIKE :search3 
                       OR c.name LIKE :search4 OR u.username LIKE :search5)";

        $stmt = $this->db->getConnection()->prepare($sql);
        $searchPattern = "%{$searchTerm}%";
        $stmt->bindValue(':search1', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search2', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search3', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search4', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':search5', $searchPattern, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }
}