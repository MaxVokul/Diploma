<?php
session_start();
require_once '../app/core/Database.php';
require_once '../app/models/UserModel.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header('Location: /login.php');
    exit();
}

// Проверка прав администратора
$userModel = new UserModel();
if (!$userModel->isAdmin($_SESSION['user_id'])) {
    header('Location: /profile.php');
    exit();
}

// Подключаем модель новостей для получения статистики
require_once '../app/models/NewsModel.php';
$newsModel = new NewsModel();
$totalNews = count($newsModel->getLatest(1000)); // Пример: общее кол-во новостей
$categories = $newsModel->getAllCategories();
$totalCategories = count($categories);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель - NEWS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="(min-width: 570px)" href="/assets/css/main.css">
    <link rel="stylesheet" media="(max-width: 570px)" href="/assets/css/mobile.css">
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <style>
        /* Базовые стили для админки */
        .admin-container {
            display: flex;
            min-height: calc(100vh - 200px); /* Учитываем высоту хедера и футера */
            margin-top: 20px;
            width: 100%;
        }
        .admin-sidebar {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
            border-right: 1px solid #ddd;
        }
        .admin-sidebar h2 {
            font-family: "Aclonica", serif;
            margin-top: 0;
        }
        .admin-sidebar ul {
            list-style: none;
            padding: 0;
        }
        .admin-sidebar ul li {
            margin-bottom: 10px;
        }
        .admin-sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .admin-sidebar ul li a:hover {
            color: var(--primary);
        }
        .admin-main {
            flex: 1;
            padding: 20px;
        }
        .admin-stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            flex: 1;
            text-align: center;
        }
        .stat-card h3 {
            margin-top: 0;
            color: #666;
        }
        .stat-card p {
            font-size: 2em;
            font-weight: bold;
            color: var(--primary);
            margin: 10px 0 0;
        }
        .category-list {
            list-style: none;
            padding: 0;
        }
        .category-list li {
            margin-bottom: 8px;
        }
        .category-list a {
            color: var(--primary);
            text-decoration: none;
        }
        .category-list a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include '../header.php'; ?>

<div class="admin-container">
    <aside class="admin-sidebar">
        <h2>Админ-панель</h2>
        <nav>
            <ul>
                <li><a href="/admin/">Главная</a></li>
                <li><a href="/admin/news/manage.php">Управление новостями</a></li>
                <li><a href="/admin/news/create.php">Создать новость</a></li>
                <li><a href="/logout.php">Выйти</a></li>
            </ul>
        </nav>
    </aside>

    <main class="admin-main">
        <h1>Добро пожаловать, администратор!</h1>
        <p>Вы можете управлять новостями и категориями.</p>

        <div class="admin-stats">
            <div class="stat-card">
                <h3>Всего новостей</h3>
                <p><?php echo $totalNews; ?></p>
            </div>
            <div class="stat-card">
                <h3>Категорий</h3>
                <p><?php echo $totalCategories; ?></p>
            </div>
        </div>

        <h2>Категории</h2>
        <ul class="category-list">
            <?php foreach($categories as $cat): ?>
                <li>
                    <a href="/category.php?category=<?php echo htmlspecialchars($cat['slug']); ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Быстрые действия</h2>
        <ul>
            <li><a href="/admin/news/create.php">Создать новую новость</a></li>
            <li><a href="/admin/news/manage.php">Просмотреть все новости</a></li>
        </ul>
    </main>
</div>

<?php include '../footer.php'; ?>
</body>
</html>