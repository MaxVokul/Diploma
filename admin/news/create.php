<?php
// admin/news/create.php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/UserModel.php';
require_once '../../app/models/NewsModel.php';

// Проверка является ли пользователь админом
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

// Helper functions
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

    // Find category name by API key
    $targetCategoryName = $categoryMapping[$apiCategory] ?? 'World';

    // Find matching category in our database
    foreach ($categories as $category) {
        if (strtolower($category['name']) === strtolower($targetCategoryName)) {
            return $category['id'];
        }
    }

    // If not found, return World as default
    return 2; // ID for World
}

function getCategoryNameById($categoryId, $categories) {
    foreach ($categories as $category) {
        if ($category['id'] == $categoryId) {
            return $category['name'];
        }
    }
    return 'World';
}

function cleanContent($content) {
    if (empty($content)) return '';

    // Remove [number chars] at the end
    $content = preg_replace('/\s*\[\d+\s*chars?\s*\]\s*\.?$/i', '', $content);
    $content = preg_replace('/\s*\[\d+\s*\]\s*\.?$/i', '', $content);

    // Remove extra spaces
    $content = trim($content);

    // Replace multiple spaces with single ones
    $content = preg_replace('/\s+/', ' ', $content);

    return $content;
}

function containsEllipsis($text) {
    return strpos($text, '...') !== false ||
        preg_match('/\s*\.{3,}\s*$/', $text) ||
        preg_match('/\s*…\s*$/', $text);
}

function getFullArticleContent($article) {
    // Исп разные источники контента

    // 1. Весь контент из API
    if (!empty($article['content']) && !containsEllipsis($article['content'])) {
        return cleanContent($article['content']);
    }

    // 2. Описание
    if (!empty($article['description'])) {
        $description = cleanContent($article['description']);
        if (!containsEllipsis($description) && strlen($description) > 200) {
            return $description;
        }
    }

    // 3. Есть многоточие, но форма чище
    if (!empty($article['content'])) {
        $content = cleanContent($article['content']);
        // If content is truncated, add a note
        if (containsEllipsis($content)) {
            $content .= "\n\n[Article continues on the original website]";
        }
        return $content;
    }

    // 4. Вставить Тайтл, если остального нет
    return cleanContent($article['title']);
}

// Импорт из API
if (isset($_POST['import_news'])) {
    $apiKey = 'b1df8d8cce581126dbd404a0d5cffc13';
    $category = $_POST['api_category'] ?? 'general';
    $country = $_POST['api_country'] ?? 'us';
    $max = min(10, (int)($_POST['api_max'] ?? 10));

    // Запуск урл запроса (форма)
    $url = "https://gnews.io/api/v4/search?q=$category&lang=en&country=$country&max=$max&apikey=$apiKey";

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

            // Получить ID категории основываясь на выборе пользователя
            $selectedCategoryId = getCategoryIdFromApiCategory($category, $categories);

            foreach ($data['articles'] as $article) {
                // Skip articles without title
                if (empty($article['title'])) {
                    continue;
                }

                // Проверка на уникальность новости по названию
                if (!$newsModel->existsByTitle($article['title'])) {
                    // Get full content
                    $content = getFullArticleContent($article);

                    // Prepare excerpt
                    $excerpt = !empty($article['description']) ?
                        cleanContent($article['description']) :
                        substr(cleanContent($content), 0, 200) . '...';

                    $publishedAt = !empty($article['publishedAt']) ?
                        date('Y-m-d H:i:s', strtotime($article['publishedAt'])) :
                        date('Y-m-d H:i:s');

                    $data = [
                        'title' => cleanContent($article['title']),
                        'content' => $content,
                        'excerpt' => $excerpt,
                        'category_id' => $selectedCategoryId,
                        'author_id' => $_SESSION['user_id'],
                        'published_at' => $publishedAt,
                        'is_published' => 1,
                        'image_url' => $article['image'] ?: null
                    ];

                    if ($newsModel->create($data)) {
                        $importedCount++;
                    } else {
                        $errors[] = "Failed to create news: " . $article['title'];
                    }
                }
            }

            if ($importedCount > 0) {
                $categoryName = getCategoryNameById($selectedCategoryId, $categories);
                $success = "Successfully imported $importedCount news articles into '$categoryName' category from GNews API!";
                if (!empty($errors)) {
                    $success .= " Errors: " . count($errors);
                }
            } else {
                $error = 'No new news to import or all news already exist.';
                if (!empty($errors)) {
                    $error .= " Creation errors: " . implode(', ', $errors);
                }
            }
        } else {
            $error = 'Failed to get news from API or no news found.';
        }
    } else {
        $error = 'Error accessing GNews API. Response code: ' . $httpCode;
        if (!empty($response)) {
            $errorData = json_decode($response, true);
            if (isset($errorData['message'])) {
                $error .= ' Message: ' . $errorData['message'];
            }
        }
    }
}

// Process regular news creation
if ($_POST && !isset($_POST['import_news'])) {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $imageUrl = trim($_POST['image_url'] ?? '');
    $publishedAt = $_POST['published_at'] ?? date('Y-m-d H:i:s');
    $isPublished = isset($_POST['is_published']) ? 1 : 0;

    if (empty($title) || empty($content) || $categoryId <= 0) {
        $error = 'Please fill in all required fields.';
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
            $success = 'News successfully created!';
            // Очистка полей после создания
            $_POST = [];
            // перенаправить на страницу manage
            header("Location: /admin/news/manage.php");
            exit();
        } else {
            $error = 'Error creating news. Please try again.';
        }
    }
}
?>
<?php
$pageTitle = "Создать новость - NEWS";
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
        <h1>Create News</h1>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- API News Import Section -->
        <div class="import-section">
            <h2>📰 Import News from GNews API</h2>
            <p>Automatically create news from current world news.</p>

            <form method="POST" class="import-form">
                <div class="form-group">
                    <label for="api_category">Category</label>
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
                    <label for="api_country">Country</label>
                    <select id="api_country" name="api_country" required>
                        <option value="us">USA</option>
                        <option value="gb">Great Britain</option>
                        <option value="ca">Canada</option>
                        <option value="au">Australia</option>
                        <option value="in">India</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="api_max">Number of Articles</label>
                    <select id="api_max" name="api_max" required>
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" name="import_news" class="btn btn-import">Import News</button>
                </div>
            </form>

            <div class="api-options">
                <small><strong>Supported countries:</strong> USA, Great Britain, Canada, Australia, India</small><br>
                <small><strong>Language:</strong> All news are imported in English</small>
            </div>
        </div>

        <!-- Manual News Creation Form -->
        <h2>✏️ Create News Manually</h2>
        <form method="POST" class="news-form">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Short Description</label>
                <textarea id="excerpt" name="excerpt"><?php echo htmlspecialchars($_POST['excerpt'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo (($_POST['category_id'] ?? '') == $cat['id'] ? 'selected' : ''); ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="content">News Content *</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image_input">Image URL or File Path</label>
                <input type="text" id="image_input" name="image_input" value="<?php echo htmlspecialchars($_POST['image_url'] ?? $_POST['image_input'] ?? ''); ?>" placeholder="Enter URL or file path">
            </div>

            <div class="form-group">
                <label for="published_at">Publication Date</label>
                <input type="datetime-local" id="published_at" name="published_at" value="<?php echo htmlspecialchars($_POST['published_at'] ?? date('Y-m-d\TH:i')); ?>">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published" value="1" <?php echo (isset($_POST['is_published']) && $_POST['is_published']) ? 'checked' : ''; ?>>
                    Published
                </label>
            </div>

            <button type="submit" class="btn-submit">Create News</button>
        </form>
    </main>
</div>

<?php include '../../footer.php'; ?>
</body>
</html>