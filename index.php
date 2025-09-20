<?php
// Инициализируем сессию ранним этапом, так как ниже используются $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Путь к корню проекта
define('ROOT', dirname(__FILE__));

// Подключаем базовые файлы
require_once ROOT . '/app/core/Database.php';
require_once ROOT . '/app/models/UserModel.php';
require_once ROOT . '/app/models/NewsModel.php'; // ← ЭТО ВАЖНО! Без этого будет ошибка!
require_once ROOT . '/app/core/View.php';

// Инициализируем модель новостей
$newsModel = new NewsModel();

// Получаем последние новости для главной страницы
$topStories = $newsModel->getLatest(3);
$topStoryIds = array_map(function($s){ return (int)$s['id']; }, $topStories);
$forYouNews = [];
$forYouHeadline = 'For You';
$forYouSubtitle = 'Recommended based on your interests';

// Секции "For You" / "What's new?"
if (isset($_SESSION['user_id'])) {
    // Пробуем выбрать самую просматриваемую пользователем категорию
    $userModelTmp = new UserModel();
    $interests = $userModelTmp->getUserInterests($_SESSION['user_id']);
    if (!empty($interests) && !empty($interests[0]['category_id'])) {
        $topCategoryId = (int)$interests[0]['category_id'];
        $categoryNews = $newsModel->getByCategory($topCategoryId, 50);
        
        // Фильтруем только уникальные статьи (исключая топ-сториз)
        $uniqueForYou = [];
        foreach ($categoryNews as $item) {
            $id = (int)$item['id'];
            if (!in_array($id, $topStoryIds, true)) {
                $uniqueForYou[] = $item;
                if (count($uniqueForYou) >= 12) break;
            }
        }
        
        // Если не хватает статей из топ-категории, дополняем из других категорий
        if (count($uniqueForYou) < 12) {
            $additionalNews = $newsModel->getLatest(100);
            shuffle($additionalNews);
            $usedIds = array_merge($topStoryIds, array_map(function($item){ return (int)$item['id']; }, $uniqueForYou));
            foreach ($additionalNews as $item) {
                $id = (int)$item['id'];
                if (!in_array($id, $usedIds, true)) {
                    $uniqueForYou[] = $item;
                    $usedIds[] = $id;
                    if (count($uniqueForYou) >= 12) break;
                }
            }
        }
        
        $forYouNews = $uniqueForYou;
        $forYouHeadline = 'For You';
        $forYouSubtitle = 'Recommended based on your interests';
    } else {
        // Новый пользователь: показываем "What's new?" со случайной подборкой из последних
        $recentPool = $newsModel->getLatest(100);
        shuffle($recentPool);
        $uniqueForYou = [];
        foreach ($recentPool as $item) {
            $id = (int)$item['id'];
            if (!in_array($id, $topStoryIds, true)) {
                $uniqueForYou[] = $item;
                if (count($uniqueForYou) >= 12) break;
            }
        }
        $forYouNews = $uniqueForYou;
        $forYouHeadline = "What's new?";
        $forYouSubtitle = '';
    }
} else {
    // Не авторизован: показываем "What's new?" со случайной подборкой из последних
    $recentPool = $newsModel->getLatest(100);
    shuffle($recentPool);
    $uniqueForYou = [];
    foreach ($recentPool as $item) {
        $id = (int)$item['id'];
        if (!in_array($id, $topStoryIds, true)) {
            $uniqueForYou[] = $item;
            if (count($uniqueForYou) >= 12) break;
        }
    }
    $forYouNews = $uniqueForYou;
    $forYouHeadline = "What's new?";
    $forYouSubtitle = '';
}

// Собираем все использованные ID для карусели
$usedIds = array_merge($topStoryIds, array_map(function($item){ return (int)$item['id']; }, $forYouNews));

// Создаем карусель с случайными статьями из всех категорий (исключая уже показанные)
$carouselNews = [];
$carouselCount = 8;
$allNews = $newsModel->getLatest(200);
shuffle($allNews);

foreach ($allNews as $item) {
    $id = (int)$item['id'];
    if (!in_array($id, $usedIds, true)) {
        $carouselNews[] = $item;
        $usedIds[] = $id;
        if (count($carouselNews) >= $carouselCount) break;
    }
}

// Получаем все категории
$categories = $newsModel->getAllCategories();

// Получаем текущего пользователя
$userModel = new UserModel();
$current_user = isset($_SESSION['user_id']) ? $userModel->findById($_SESSION['user_id']) : null;

// Передаем данные в представление
include 'header.php';
?>

    <section class="tssection">
        <h2 class="mains">Top stories</h2>
        <?php foreach ($topStories as $story): ?>
            <a href="/news.php?id=<?php echo $story['id']; ?>" class="tssqr">
                <img class="imgts" src="<?php echo htmlspecialchars($story['image_url'] ?? 'resources/image 1.png'); ?>" alt="<?php echo htmlspecialchars($story['title']); ?>">
                <div class="tstext">
                    <h3><?php echo htmlspecialchars($story['title']); ?></h3>
                    <p><?php echo htmlspecialchars(substr($story['excerpt'], 0, 200)) . (strlen($story['excerpt']) > 200 ? '...' : ''); ?></p>
                    <p><?php echo date('H:i', strtotime($story['published_at'])); ?> ago / by <?php echo htmlspecialchars($story['author_name']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </section>

    <!-- Carousel Section -->
    <section class="carousel-section">
        <div class="carousel-header">
            <h2 class="carousel-title">Discover More</h2>
            <p class="carousel-subtitle">Explore even more stories</p>
        </div>
        
        
        <div class="carousel-container">
            <button class="carousel-btn carousel-btn-prev" id="carouselPrev">‹</button>
            <div class="carousel-wrapper">
                <div class="carousel-track" id="carouselTrack">
                    <?php if (!empty($carouselNews)): ?>
                        <?php foreach ($carouselNews as $carouselItem): ?>
                            <div class="carousel-item">
                                <a href="/news.php?id=<?php echo (int)$carouselItem['id']; ?>" class="carousel-link">
                                    <img src="<?php echo htmlspecialchars($carouselItem['image_url'] ?? 'resources/Rectangle 20.png'); ?>" 
                                         class="carousel-img" 
                                         alt="<?php echo htmlspecialchars($carouselItem['title']); ?>">
                                    <div class="carousel-content">
                                        <h3 class="carousel-item-title"><?php echo htmlspecialchars($carouselItem['title']); ?></h3>
                                        <p class="carousel-item-excerpt"><?php echo htmlspecialchars(substr($carouselItem['excerpt'], 0, 100)) . (strlen($carouselItem['excerpt']) > 100 ? '...' : ''); ?></p>
                                        <p class="carousel-item-meta">
                                            <?php echo date('H:i', strtotime($carouselItem['published_at'])); ?> ago / by <?php echo htmlspecialchars($carouselItem['author_name']); ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding: 20px; text-align: center; color: #666;">
                            <p>No articles available for carousel</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <button class="carousel-btn carousel-btn-next" id="carouselNext">›</button>
        </div>
    </section>

    <section class="foryou">
        <div class="foryouh2">
            <h2 id="fy"><?php echo htmlspecialchars($forYouHeadline); ?></h2>
            <?php if (!empty($forYouSubtitle)): ?>
                <p><?php echo htmlspecialchars($forYouSubtitle); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <div class="foryouall">
        <section class="foryouin">
            <?php $rowIndex = 0; ?>
            <?php for ($i = 0; $i < count($forYouNews); $i += 3): ?>
                <div class="row">
                    <?php for ($j = 0; $j < 3 && ($i + $j) < count($forYouNews); $j++): ?>
                        <?php $newsItem = $forYouNews[$i + $j]; ?>
                        <div class="rect">
                            <a href="/news.php?id=<?php echo (int)$newsItem['id']; ?>" class="rectlink">
                                <img src="<?php echo htmlspecialchars($newsItem['image_url'] ?? 'resources/Rectangle 20.png'); ?>" class="rectimg" alt="<?php echo htmlspecialchars($newsItem['title']); ?>">
                                <div class="recttxt">
                                    <h2><?php echo htmlspecialchars($newsItem['title']); ?></h2>
                                    <p><?php echo htmlspecialchars(substr($newsItem['excerpt'], 0, 150)) . (strlen($newsItem['excerpt']) > 150 ? '...' : ''); ?></p>
                                </div>
                                <p class="rectp">
                                    <?php echo date('H:i', strtotime($newsItem['published_at'])); ?> ago / by <?php echo htmlspecialchars($newsItem['author_name']); ?>
                                </p>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>
        </section>
    </div>

    <section class="back">
        <h1 id="back"><a href="">Back to Top</a></h1>
    </section>

<?php include 'footer.php'; ?>