<?php
// admin/news/create.php
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

$newsModel = new NewsModel();
$categories = $newsModel->getAllCategories();

$error = '';
$success = '';

// Обработка импорта новостей из API
if (isset($_POST['import_news'])) {
    $apiKey = 'b1df8d8cce581126dbd404a0d5cffc13';
    $category = $_POST['api_category'] ?? 'general';
    $country = $_POST['api_country'] ?? 'us';
    $max = min(10, (int)($_POST['api_max'] ?? 10));

    $url = "https://gnews.io/api/v4/top-headlines?category=$category&lang=en&country=$country&max=$max&apikey=$apiKey";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);

        if (isset($data['articles']) && count($data['articles']) > 0) {
            $importedCount = 0;
            $errors = [];

            // Получаем ID категории на основе выбора пользователя
            $selectedCategoryId = getCategoryIdFromApiCategory($category, $categories);

            foreach ($data['articles'] as $article) {
                // Пропускаем статьи без заголовка
                if (empty($article['title'])) {
                    continue;
                }

                // Проверяем, существует ли уже такая новость по заголовку
                if (!$newsModel->existsByTitle($article['title'])) {
                    // Подготавливаем данные
                    $content = !empty($article['content']) ? $article['content'] :
                        (!empty($article['description']) ? $article['description'] : $article['title']);

                    $excerpt = !empty($article['description']) ? $article['description'] :
                        substr($content, 0, 200) . '...';

                    $publishedAt = !empty($article['publishedAt']) ?
                        date('Y-m-d H:i:s', strtotime($article['publishedAt'])) :
                        date('Y-m-d H:i:s');

                    $data = [
                        'title' => $article['title'],
                        'content' => $content,
                        'excerpt' => $excerpt,
                        'category_id' => $selectedCategoryId, // Используем выбранную категорию
                        'author_id' => $_SESSION['user_id'],
                        'published_at' => $publishedAt,
                        'is_published' => 1,
                        'image_url' => $article['image'] ?: null
                    ];

                    if ($newsModel->create($data)) {
                        $importedCount++;
                    } else {
                        $errors[] = "Не удалось создать новость: " . $article['title'];
                    }
                }
            }

            if ($importedCount > 0) {
                $categoryName = getCategoryNameById($selectedCategoryId, $categories);
                $success = "Успешно импортировано $importedCount новостей в категорию '$categoryName' из GNews API!";
                if (!empty($errors)) {
                    $success .= " Ошибки: " . count($errors);
                }
            } else {
                $error = 'Нет новых новостей для импорта или все новости уже существуют.';
                if (!empty($errors)) {
                    $error .= " Ошибки при создании: " . implode(', ', $errors);
                }
            }
        } else {
            $error = 'Не удалось получить новости из API или новости не найдены.';
        }
    } else {
        $error = 'Ошибка при обращении к GNews API. Код ответа: ' . $httpCode;
        if (!empty($response)) {
            $errorData = json_decode($response, true);
            if (isset($errorData['message'])) {
                $error .= ' Сообщение: ' . $errorData['message'];
            }
        }
    }
}

// Функция для получения ID категории на основе выбора в API
function getCategoryIdFromApiCategory($apiCategory, $categories) {
    $categoryMapping = [
        'general' => 'General',
        'world' => 'World',
        'nation' => 'Politics',
        'business' => 'Business',
        'technology' => 'Technology',
        'entertainment' => 'Entertainment',
        'sports' => 'Sports',
        'science' => 'Science',
        'health' => 'Health'
    ];

    // Находим название категории по ключу API
    $targetCategoryName = $categoryMapping[$apiCategory] ?? 'World';

    // Ищем соответствующую категорию в нашей базе
    foreach ($categories as $category) {
        if (strtolower($category['name']) === strtolower($targetCategoryName)) {
            return $category['id'];
        }
    }

    // Если не нашли, возвращаем World по умолчанию
    return 2; // ID для World
}

// Функция для получения названия категории по ID
function getCategoryNameById($categoryId, $categories) {
    foreach ($categories as $category) {
        if ($category['id'] == $categoryId) {
            return $category['name'];
        }
    }
    return 'World';
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
    <style>
        .import-section {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .import-form {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 10px;
            align-items: end;
        }
        .import-form .form-group {
            margin-bottom: 0;
        }
        .api-options {
            margin-top: 15px;
        }
        .btn-import {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-import:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        @media (max-width: 768px) {
            .import-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
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

        <!-- Секция импорта новостей из API -->
        <div class="import-section">
            <h2>📰 Импорт новостей из GNews API</h2>
            <p>Автоматически создайте новости из актуальных мировых новостей на английском языке.</p>

            <form method="POST" class="import-form">
                <div class="form-group">
                    <label for="api_category">Категория</label>
                    <select id="api_category" name="api_category" required>
                        <option value="general">General</option>
                        <option value="world">World</option>
                        <option value="business">Business</option>
                        <option value="technology">Technology</option>
                        <option value="entertainment">Entertainment</option>
                        <option value="sports">Sports</option>
                        <option value="science">Science</option>
                        <option value="health">Health</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="api_country">Страна</label>
                    <select id="api_country" name="api_country" required>
                        <option value="us">USA</option>
                        <option value="gb">Great Britain</option>
                        <option value="ca">Canada</option>
                        <option value="au">Australia</option>
                        <option value="in">India</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="api_max">Количество новостей</label>
                    <select id="api_max" name="api_max" required>
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" name="import_news" class="btn btn-import">Импортировать новости</button>
                </div>
            </form>

            <div class="api-options">
                <small><strong>Доступные категории:</strong> general, world, business, technology, entertainment, sports, science, health</small><br>
                <small><strong>Поддерживаемые страны:</strong> США, Великобритания, Канада, Австралия, Индия</small><br>
                <small><strong>Язык:</strong> Все новости импортируются на английском языке</small>
            </div>
        </div>

        <!-- Обычная форма создания новости -->
        <h2>✏️ Создать новость вручную</h2>
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