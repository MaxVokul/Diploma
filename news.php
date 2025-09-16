<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/NewsModel.php';
require_once __DIR__ . '/app/models/UserModel.php';

$newsId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($newsId <= 0) {
    http_response_code(404);
    die('Новость не найдена');
}

$newsModel = new NewsModel();
$newsItem = $newsModel->getFullNews($newsId);

if (!$newsItem) {
    http_response_code(404);
    die('Новость не найдена');
}

// Инкремент просмотров
$newsModel->incrementViews($newsId);

include __DIR__ . '/header.php';
?>

<section class="tssection">
    <h2 class="mains"><?php echo htmlspecialchars($newsItem['title']); ?></h2>
    <p><?php echo date('d.m.Y H:i', strtotime($newsItem['published_at'])); ?> / by <?php echo htmlspecialchars($newsItem['author_name'] ?? ''); ?></p>
    <div class="news-cover">
        <img class="imgts" src="<?php echo htmlspecialchars($newsItem['image_url'] ?? '/resources/image 1.png'); ?>" alt="<?php echo htmlspecialchars($newsItem['title']); ?>">
    </div>
    <article class="news-content">
        <?php echo $newsItem['content']; ?>
    </article>
    <p>Category: <a href="/category.php?category=<?php echo htmlspecialchars($newsItem['category_slug'] ?? ''); ?>"><?php echo htmlspecialchars($newsItem['category_name'] ?? ''); ?></a></p>
</section>

<?php include __DIR__ . '/footer.php'; ?>


