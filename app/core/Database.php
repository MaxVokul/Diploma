<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {

        // Подключаем конфиг
        require_once __DIR__ . '/../../config/database.php';

        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    // Получить экземпляр (Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self(); //-вызов конструктора
        }
        return self::$instance;
    }

    // Получить PDO соединение
    public function getConnection() {
        return $this->pdo;
    }

    // Выполнить запрос SELECT - возращает массив всех строк результата
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Выполнить запрос INSERT/UPDATE/DELETE
    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Получить последний ID после INSERT
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}