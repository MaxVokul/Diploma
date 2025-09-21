DiplomaRECENT/
├── admin/                     # Панель управления (админка)
│   ├── index.php              # Главная страница админки
│   └── news/                  # Управление новостями
│       ├── create.php        # Создание новости
│       ├── delete.php        # Удаление новости
│       ├── edit.php           # Редактирование новости
│       └── manage.php         # Список новостей
├── app/                       # Основное приложение (MVC)
│   ├── core/                  # Ядро приложения
│   │   ├── Controller.php    # Базовый класс контроллера
│   │   ├── Database.php      # Класс для работы с БД (Singleton)
│   │   └── View.php           # Класс для рендеринга представлений
│   ├── models/               # Модели данных
│   │   ├── NewsModel.php     # Логика работы с новостями
│   │   └── UserModel.php     # Логика работы с пользователями
│   └── views/                # Представления (шаблоны)
│       ├── auth/             # Шаблоны авторизации
│       │   ├── login.php
│       │   └── register.php
│       ├── home/             # Шаблон главной страницы
│       │   └── index.php
│       ├── logouts/          # Шаблоны хедера и футера - не работают на данный момент
│       │   ├── footer.php
│       │   └── header.php
│       └── profile/          # Шаблон профиля
│           └── index.php
├── assets/                    # Статические ресурсы
│   ├── css/                   # Стили
│   │   ├── main.css          # Основные стили
│   │   └── mobile.css        # Мобильные стили
│   └── js/                    # JavaScript
│       ├── carousel.js       # Карусель новостей
│       ├── index.js          # Логика главной страницы
│       ├── phone.js          # Форматирование телефона
│       ├── script.js         # Основной JS (модальные окна, формы)
│       ├── slidingmenu.js    # Бургер-меню
│       └── ...               # Другие JS-файлы
├── resources/                 # Изображения и другие ресурсы
│   ├── image 1.png
│   ├── ...
│   └── Various_collected_memes/ # Для картинок
├── ...                        # Основные страницы сайта
├── index.php                  # Главная страница
├── profile.php               # Страница профиля
├── login.php                  # Страница входа
├── register.php               # Страница регистрации
├── logout.php                 # Выход
├── category.php              # Страница категории
├── news.php                  # Страница одной новости
├── header.php                # Хедер (шапка) сайта
├── footer.php                # Футер (подвал) сайта
└── ...                       # Другие файлы

1. app/core/Database.php (Singleton Pattern - ляется одним из паттернов проектирования, который используется для создания класса,
имеющего только один экземпляр в системе, и предоставляющего глобальную точку доступа к этому экземпляру. )

<?php
// Класс служит единой точкой доступа к базе данных во всем приложении
// реализующий паттерн Singleton
//Управляет подключением к MySQL
//
//Выполняет SQL-запросы безопасным способом
//
//Предоставляет единый API для работы с БД
//
//Обеспечивает безопасность от SQL-инъекций
//
//Контролирует ресурсы (только одно подключение)

// приимущества классов - инкапсуляция, безопасность

class Database {
    // Статическая переменная для хранения единственного экземпляра класса
    private static $instance = null;
    // Объект PDO для подключения к БД
    private $pdo;
    // Параметры подключения
    private $host;
    private $dbname;
    private $username;
    private $password;

    // Приватный конструктор, предотвращает создание объекта извне (через new)
    private function __construct() {
        // Подключаем файл конфигурации
        require_once '../config/database.php';

        // Инициализируем параметры подключения
        $this->host = DB_HOST;
        $this->dbname = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;

        try {
            // Создаем подключение PDO
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Включаем выброс исключений при ошибках
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Устанавливаем режим выборки по умолчанию - ассоциативный массив
                    PDO::ATTR_EMULATE_PREPARES => false, // Отключаем эмуляцию подготовленных выражений (лучше безопасность)
                ]
            );
        } catch (PDOException $e) {
            // Обрабатываем ошибку подключения
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    // Запрещаем клонирование объекта (часть Singleton)
    private function __clone() {}

    // Запрещаем десериализацию объекта (часть Singleton)
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }

    // Статический метод для получения единственного экземпляра класса (Singleton)
    public static function getInstance() {
        // Если экземпляр еще не создан
        if (self::$instance === null) {
            // Создаем новый экземпляр
            self::$instance = new self();
        }
        // Возвращаем существующий или только что созданный экземпляр
        return self::$instance;
    }

    // Метод для выполнения SELECT-запросов
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(); // Возвращаем все результаты
    }

    // Метод для выполнения INSERT/UPDATE/DELETE-запросов
    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params); // Возвращаем результат выполнения (true/false)
    }

    // Метод для получения последнего вставленного ID
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    // Метод для получения объекта PDO (если нужно напрямую работать с ним)
    public function getConnection() {
        return $this->pdo;
    }
}
?>