<?php
// admin/news/manage.php
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

// Search settings
$searchTerm = trim($_GET['search'] ?? '');
$isSearching = !empty($searchTerm);

// Pagination settings
$articlesPerPage = 50;
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($currentPage - 1) * $articlesPerPage;

// Sorting settings
$sortBy = $_GET['sort'] ?? 'id';
$sortOrder = $_GET['order'] ?? 'DESC';

// Get total count and articles for current page
if ($isSearching) {
    $totalArticles = $newsModel->getSearchCount($searchTerm);
    $allNews = $newsModel->searchForAdmin($searchTerm, $articlesPerPage, $offset, $sortBy, $sortOrder);
} else {
    $totalArticles = $newsModel->getTotalCount();
    $allNews = $newsModel->getAllForAdmin($articlesPerPage, $offset, $sortBy, $sortOrder);
}

$totalPages = ceil($totalArticles / $articlesPerPage);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>News control - NEWS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="(min-width: 570px)" href="/assets/css/main.css">
    <link rel="stylesheet" media="(max-width: 570px)" href="/assets/css/mobile.css">
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    
</head>
<body>
<?php include '../../header.php'; ?>

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
        <h1>News control</h1>
        
        <div class="admin-controls">
            <a href="/admin/news/create.php" class="btn-create">Create news</a>
            
            <form method="GET" class="search-form">
                <div class="search-input-group">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" 
                           placeholder="Search by title, content, author, or category..."
                           class="search-input">
                    <button type="submit" class="search-btn">🔍</button>
                    <?php if ($isSearching): ?>
                        <a href="?" class="clear-search-btn">✕</a>
                    <?php endif; ?>
                </div>
                <!-- Preserve sort parameters -->
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sortBy); ?>">
                <input type="hidden" name="order" value="<?php echo htmlspecialchars($sortOrder); ?>">
            </form>
        </div>

        <?php if (empty($allNews)): ?>
            <?php if ($isSearching): ?>
                <div class="no-results">
                    <p>Nothing found on the search query - "<?php echo htmlspecialchars($searchTerm); ?>".</p>
                    <a href="?" class="btn-clear-search">Show all news</a>
                </div>
            <?php else: ?>
                <p>No news yet.</p>
            <?php endif; ?>
        <?php else: ?>
            <div class="admin-info">
                <?php if ($isSearching): ?>
                    <p>Найдено <?php echo $totalArticles; ?> Search result "<?php echo htmlspecialchars($searchTerm); ?>"
                       (Showing <?php echo count($allNews); ?> of  <?php echo $totalArticles; ?>, Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>)</p>
                <?php else: ?>
                    <p>Showing <?php echo count($allNews); ?> of <?php echo $totalArticles; ?> articles (Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>)</p>
                <?php endif; ?>
            </div>
            
            <table class="admin-table">
                <thead>
                <tr>
                    <th>
                        <a href="?sort=id&order=<?php echo ($sortBy == 'id' && $sortOrder == 'ASC') ? 'DESC' : 'ASC'; ?>&page=<?php echo $currentPage; ?><?php echo $isSearching ? '&search=' . urlencode($searchTerm) : ''; ?>">
                            ID <?php echo ($sortBy == 'id') ? ($sortOrder == 'ASC' ? '↑' : '↓') : ''; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=title&order=<?php echo ($sortBy == 'title' && $sortOrder == 'ASC') ? 'DESC' : 'ASC'; ?>&page=<?php echo $currentPage; ?><?php echo $isSearching ? '&search=' . urlencode($searchTerm) : ''; ?>">
                            Title <?php echo ($sortBy == 'title') ? ($sortOrder == 'ASC' ? '↑' : '↓') : ''; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=category_name&order=<?php echo ($sortBy == 'category_name' && $sortOrder == 'ASC') ? 'DESC' : 'ASC'; ?>&page=<?php echo $currentPage; ?><?php echo $isSearching ? '&search=' . urlencode($searchTerm) : ''; ?>">
                            Category <?php echo ($sortBy == 'category_name') ? ($sortOrder == 'ASC' ? '↑' : '↓') : ''; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=author_name&order=<?php echo ($sortBy == 'author_name' && $sortOrder == 'ASC') ? 'DESC' : 'ASC'; ?>&page=<?php echo $currentPage; ?><?php echo $isSearching ? '&search=' . urlencode($searchTerm) : ''; ?>">
                            Author <?php echo ($sortBy == 'author_name') ? ($sortOrder == 'ASC' ? '↑' : '↓') : ''; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=published_at&order=<?php echo ($sortBy == 'published_at' && $sortOrder == 'ASC') ? 'DESC' : 'ASC'; ?>&page=<?php echo $currentPage; ?><?php echo $isSearching ? '&search=' . urlencode($searchTerm) : ''; ?>">
                            Date <?php echo ($sortBy == 'published_at') ? ($sortOrder == 'ASC' ? '↑' : '↓') : ''; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=is_published&order=<?php echo ($sortBy == 'is_published' && $sortOrder == 'ASC') ? 'DESC' : 'ASC'; ?>&page=<?php echo $currentPage; ?><?php echo $isSearching ? '&search=' . urlencode($searchTerm) : ''; ?>">
                            Status <?php echo ($sortBy == 'is_published') ? ($sortOrder == 'ASC' ? '↑' : '↓') : ''; ?>
                        </a>
                    </th>
                    <th>Actions</th>
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
                        <td><?php echo $newsItem['is_published'] ? '<span style="color:green;">Published</span>' : '<span style="color:orange;">Draft</span>'; ?></td>
                        <td class="actions">
                            <a href="/admin/news/edit.php?id=<?php echo $newsItem['id']; ?>">Edit</a>
                            <a href="/admin/news/delete.php?id=<?php echo $newsItem['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту новость?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php if ($totalPages > 1): ?>
                <div class="pagination-container">
                    <div class="pagination">
                        <?php 
                        $searchParam = $isSearching ? '&search=' . urlencode($searchTerm) : '';
                        ?>
                        <?php if ($currentPage > 1): ?>
                            <a href="?sort=<?php echo $sortBy; ?>&order=<?php echo $sortOrder; ?>&page=1<?php echo $searchParam; ?>" class="pagination-btn">« First</a>
                            <a href="?sort=<?php echo $sortBy; ?>&order=<?php echo $sortOrder; ?>&page=<?php echo $currentPage - 1; ?><?php echo $searchParam; ?>" class="pagination-btn">‹ Previous</a>
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
                            <a href="?sort=<?php echo $sortBy; ?>&order=<?php echo $sortOrder; ?>&page=<?php echo $i; ?><?php echo $searchParam; ?>" 
                               class="pagination-btn <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?sort=<?php echo $sortBy; ?>&order=<?php echo $sortOrder; ?>&page=<?php echo $currentPage + 1; ?><?php echo $searchParam; ?>" class="pagination-btn">Next ›</a>
                            <a href="?sort=<?php echo $sortBy; ?>&order=<?php echo $sortOrder; ?>&page=<?php echo $totalPages; ?><?php echo $searchParam; ?>" class="pagination-btn">Last »</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</div>

<?php include '../../footer.php'; ?>
</body>
</html>