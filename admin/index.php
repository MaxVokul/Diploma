<?php
session_start();
require_once '../app/core/Database.php';
require_once '../app/models/UserModel.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header('Location: /index.php');
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
    <title>Admin-panel - NEWS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="(min-width: 570px)" href="/assets/css/main.css">
    <link rel="stylesheet" media="(max-width: 570px)" href="/assets/css/mobile.css">
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">

</head>
<body>
<?php include '../header.php'; ?>

<div class="admin-container">
    <aside class="admin-sidebar">
        <h2>Admin-panel</h2>
        <nav>
            <ul>
                <li><a href="/admin/">Main</a></li>
                <li><a href="/admin/news/manage.php">News control</a></li>
                <li><a href="/admin/news/create.php">Create news</a></li>
                <li><a href="/app/controller/logout.php">Exit</a></li>
            </ul>
        </nav>
    </aside>

    <main class="admin-main">
        <h1>Welcome, Admin!</h1>
        <p>You can control news and categories.</p>

        <div class="admin-stats">
            <div class="stat-card">
                <h3>Total news amount</h3>
                <p><?php echo $totalNews; ?></p>
            </div>
            <div class="stat-card">
                <h3>Categories</h3>
                <p><?php echo $totalCategories; ?></p>
            </div>
        </div>

        <h2>Categories</h2>
        <ul class="category-list">
            <?php foreach($categories as $cat): ?>
                <li>
                    <a href="/category.php?category=<?php echo htmlspecialchars($cat['slug']); ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Quick action</h2>
        <ul>
            <li><a href="/admin/news/create.php">Create new news</a></li>
            <li><a href="/admin/news/manage.php">View all news</a></li>
        </ul>
    </main>
</div>

<?php include '../footer.php'; ?>
</body>
</html>