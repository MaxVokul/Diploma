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

// Настройки пагинации
$articlesPerPage = 10;
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($currentPage - 1) * $articlesPerPage;

// Получить общее количество и статьи для данной страницы
$totalArticles = $newsModel->getCategoryCount($categoryInfo['id']);
$totalPages = ceil($totalArticles / $articlesPerPage);
$categoryNews = $newsModel->getByCategory($categoryInfo['id'], $articlesPerPage, $offset);

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

<?php if ($totalPages > 1): ?>
    <div class="pagination-container">
        <div class="pagination-info">
            <p>Showing <?php echo count($categoryNews); ?> of <?php echo $totalArticles; ?> articles (Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>)</p>
        </div>
        
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?category=<?php echo urlencode($categorySlug); ?>&page=1" class="pagination-btn">« First</a>
                <a href="?category=<?php echo urlencode($categorySlug); ?>&page=<?php echo $currentPage - 1; ?>" class="pagination-btn">‹ Previous</a>
            <?php endif; ?>
            
            <?php
            // Calculate page range to show
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            
            // Adjust range if we're near the beginning or end
            if ($endPage - $startPage < 4) {
                if ($startPage == 1) {
                    $endPage = min($totalPages, $startPage + 4);
                } else {
                    $startPage = max(1, $endPage - 4);
                }
            }
            
            for ($i = $startPage; $i <= $endPage; $i++):
            ?>
                <a href="?category=<?php echo urlencode($categorySlug); ?>&page=<?php echo $i; ?>" 
                   class="pagination-btn <?php echo $i == $currentPage ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages): ?>
                <a href="?category=<?php echo urlencode($categorySlug); ?>&page=<?php echo $currentPage + 1; ?>" class="pagination-btn">Next ›</a>
                <a href="?category=<?php echo urlencode($categorySlug); ?>&page=<?php echo $totalPages; ?>" class="pagination-btn">Last »</a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<button class="back-to-top" id="backToTop" title="Back to Top">↑</button>

<?php include __DIR__ . '/footer.php'; ?>