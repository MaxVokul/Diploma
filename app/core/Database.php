<?php

class Database {
    private static $instance = null;
    private $pdo;
    private $host;
    private $dbname;
    private $username;
    private $password;

    private function __construct() {

        // Подключаем конфиг
        require_once __DIR__ . '/../../config/database.php';

        $this->host = DB_HOST;
        $this->dbname = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;

        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password,
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

    // Запрещаем клонирование
    private function __clone() {}

    // Запрещаем восстановление
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }

    // Получить экземпляр (Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Получить PDO соединение
    public function getConnection() {
        return $this->pdo;
    }

    // Выполнить запрос SELECT
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