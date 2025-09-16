<?php
// category.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/UserModel.php';
require_once __DIR__ . '/app/models/NewsModel.php';

$categorySlug = $_GET['category'] ?? '';

if (empty($categorySlug)) {
    http_response_code(404);
    die('Категория не указана');
}

$newsModel = new NewsModel();
$categoryInfo = $newsModel->getCategoryBySlug($categorySlug);

if (!$categoryInfo) {
    http_response_code(404);
    die('Категория не найдена');
}

$categoryNews = $newsModel->getByCategory($categoryInfo['id'], 20);

include __DIR__ . '/header.php';
?>

<section class="tssection">
    <h2 class="mains"><?php echo htmlspecialchars($categoryInfo['name']); ?></h2>
    <p><?php echo htmlspecialchars($categoryInfo['description'] ?? ''); ?></p>

    <?php if (empty($categoryNews)): ?>
        <p>В этой категории пока нет новостей.</p>
    <?php else: ?>
        <?php foreach ($categoryNews as $newsItem): ?>
            <a href="/news.php?id=<?php echo $newsItem['id']; ?>" class="tssqr">
                <img class="imgts" src="<?php echo htmlspecialchars($newsItem['image_url'] ?? '/resources/image 1.png'); ?>" alt="<?php echo htmlspecialchars($newsItem['title']); ?>">
                <div class="tstext">
                    <h3><?php echo htmlspecialchars($newsItem['title']); ?></h3>
                    <p><?php echo htmlspecialchars($newsItem['excerpt'] ?? substr(strip_tags($newsItem['content']), 0, 200) . '...'); ?></p>
                    <p><?php echo date('d.m.Y H:i', strtotime($newsItem['published_at'])); ?> / by <?php echo htmlspecialchars($newsItem['author_name']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>