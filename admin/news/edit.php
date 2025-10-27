<?php
// admin/news/edit.php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/UserModel.php';
require_once '../../app/models/NewsModel.php';

// Проверка авторизации и прав администратора
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header('Location: /index.php');
    exit();
}

$userModel = new UserModel();
if (!$userModel->isAdmin($_SESSION['user_id'])) {
    header('Location: /profile.php');
    exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    http_response_code(404);
    die('No news article found');
}

$newsModel = new NewsModel();
// Метод getFullNews возвращает полную информацию о новости
$newsItem = $newsModel->getFullNews($id);
if (!$newsItem) {
    http_response_code(404);
    die('Новость не найдена');
}

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
        $error = 'Please, fill in all the required fields.';
    } else {
        $data = [
            'title' => $title,
            'content' => $content,
            'excerpt' => $excerpt,
            'category_id' => $categoryId,
            'published_at' => $publishedAt,
            'is_published' => $isPublished,
            'image_url' => $imageUrl ?: null
        ];

        if ($newsModel->update($id, $data)) {
            $success = 'The news item has been updated!';
            // Обновляем данные новости для отображения
            $newsItem = array_merge($newsItem, $data);
        } else {
            $error = 'Error updating the news item!';
        }
    }
}

?>
<?php
$pageTitle = "Редактировать новость - NEWS";
require_once __DIR__ . '/../../header.php';
?>

<div class="admin-container">
    <aside class="admin-sidebar">
        <h2>Admin Panel</h2>
        <nav>
            <ul>
                <li><a href="/admin/">Dashboard</a></li>
                <li><a href="/admin/news/manage.php">Manage News</a></li>
                <li><a href="/admin/news/create.php">Create News</a></li>
                <li><a href="/admin/backup.php">Backup</a></li>
                <li><a href="/app/controller/logout.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="admin-main">
        <h1>Edit news</h1>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" class="news-form">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($newsItem['title'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Short description</label>
                <textarea id="excerpt" name="excerpt"><?php echo htmlspecialchars($newsItem['excerpt'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Choose category</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($newsItem['category_id'] == $cat['id'] ? 'selected' : ''); ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="content">News text *</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($newsItem['content'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image_url">Img URL or path to file </label>
                <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($newsItem['image_url'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="published_at">Date of publication</label>
                <input type="datetime-local" id="published_at" name="published_at" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($newsItem['published_at']))); ?>">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published" value="1" <?php echo ($newsItem['is_published'] ? 'checked' : ''); ?>>
                    Published
                </label>
            </div>

            <button type="submit" class="btn-submit">Update news</button>
        </form>

        <hr>
        <a href="/admin/news/manage.php" class="btn-submit" style="background-color: #6c757d; text-decoration: none; display: inline-block;">← Back to the list</a>
    </main>
</div>

<?php include '../../footer.php'; ?>
</body>
</html>