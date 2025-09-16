<?php
// admin/news/manage.php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/UserModel.php';
require_once '../../app/models/NewsModel.php';

// Проверка авторизации и прав администратора
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header('Location: /login.php');
    exit();
}

$userModel = new UserModel();
if (!$userModel->isAdmin($_SESSION['user_id'])) {
    header('Location: /profile.php');
    exit();
}

$newsModel = new NewsModel();
$allNews = $newsModel->getLatest(100); // Получаем последние 100 новостей

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление новостями - NEWS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    
</head>
<body>
<?php include '../../header.php'; ?>

<div class="admin-container">
    <!-- Сайдбар из dashboard.php можно вынести в отдельный файл и подключать -->
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
        <h1>Управление новостями</h1>
        <a href="/admin/news/create.php" class="btn-create">Создать новость</a>

        <?php if (empty($allNews)): ?>
            <p>Новостей пока нет.</p>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Категория</th>
                    <th>Автор</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allNews as $newsItem): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($newsItem['id']); ?></td>
                        <td>
                            <a href="/news.php?id=<?php echo $newsItem['id']; ?>" target="_blank">
                                <?php echo htmlspecialchars(substr($newsItem['title'], 0, 50)) . (strlen($newsItem['title']) > 50 ? '...' : ''); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($newsItem['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($newsItem['author_name']); ?></td>
                        <td><?php echo date('d.m.Y H:i', strtotime($newsItem['published_at'])); ?></td>
                        <td><?php echo $newsItem['is_published'] ? '<span style="color:green;">Опубликовано</span>' : '<span style="color:orange;">Черновик</span>'; ?></td>
                        <td class="actions">
                            <a href="/admin/news/edit.php?id=<?php echo $newsItem['id']; ?>">Редактировать</a>
                            <a href="/admin/news/delete.php?id=<?php echo $newsItem['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту новость?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>

<?php include '../../footer.php'; ?>
</body>
</html>