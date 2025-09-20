<?php
// admin/news/create.php
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
$categories = $newsModel->getAllCategories();

$error = '';
$success = '';

if ($_POST) {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $imageUrl = trim($_POST['image_url'] ?? '');
    $publishedAt = $_POST['published_at'] ?? date('Y-m-d H:i:s');
    $isPublished = isset($_POST['is_published']) ? 1 : 0;

    if (empty($title) || empty($content) || $categoryId <= 0) {
        $error = 'Пожалуйста, заполните все обязательные поля.';
    } else {
        $data = [
            'title' => $title,
            'content' => $content,
            'excerpt' => $excerpt,
            'category_id' => $categoryId,
            'author_id' => $_SESSION['user_id'],
            'published_at' => $publishedAt,
            'is_published' => $isPublished,
            'image_url' => $imageUrl ?: null
        ];

        if ($newsModel->create($data)) {
            $success = 'Новость успешно создана!';
            // Очищаем поля формы после успешного создания
            $_POST = [];
            // Перенаправляем на страницу управления
            header("Location: /admin/news/manage.php");
            exit();
        } else {
            $error = 'Ошибка при создании новости. Попробуйте еще раз.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать новость - NEWS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    
</head>
<body>
<?php include '../../header.php'; ?>

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
        <h1>Создать новость</h1>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" class="news-form">
            <div class="form-group">
                <label for="title">Заголовок *</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Краткое описание</label>
                <textarea id="excerpt" name="excerpt"><?php echo htmlspecialchars($_POST['excerpt'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Категория *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Выберите категорию</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo (($_POST['category_id'] ?? '') == $cat['id'] ? 'selected' : ''); ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Текст новости *</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image_input">URL изображения или путь к файлу</label>
                <input type="text" id="image_input" name="image_input" value="<?php echo htmlspecialchars($_POST['image_url'] ?? $_POST['image_input'] ?? ''); ?>" placeholder="Введите URL или путь к файлу">
            </div>

            <div class="form-group">
                <label for="published_at">Дата публикации</label>
                <input type="datetime-local" id="published_at" name="published_at" value="<?php echo htmlspecialchars($_POST['published_at'] ?? date('Y-m-d\TH:i')); ?>">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published" value="1" <?php echo (isset($_POST['is_published']) && $_POST['is_published']) ? 'checked' : ''; ?>>
                    Опубликовано
                </label>
            </div>

            <button type="submit" class="btn-submit">Создать новость</button>
        </form>
    </main>
</div>

<?php include '../../footer.php'; ?>
</body>
</html>