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
        $forYouNews = $newsModel->getByCategory($topCategoryId, 20);
        $forYouHeadline = 'For You';
        $forYouSubtitle = 'Recommended based on your interests';
    } else {
        // Новый пользователь: показываем "What's new?" со случайной подборкой из последних
        $recentPool = $newsModel->getLatest(80);
        shuffle($recentPool);
        $forYouNews = array_slice($recentPool, 0, 12);
        $forYouHeadline = "What's new?";
        $forYouSubtitle = '';
    }
} else {
    // Не авторизован: показываем "What's new?" со случайной подборкой из последних
    $recentPool = $newsModel->getLatest(80);
    shuffle($recentPool);
    $forYouNews = array_slice($recentPool, 0, 12);
    $forYouHeadline = "What's new?";
    $forYouSubtitle = '';
}

// Удаляем дубликаты с Top stories и дополняем при необходимости
$desiredCount = 12;
$pickedIds = $topStoryIds;
$uniqueForYou = [];
foreach ($forYouNews as $item) {
    $id = (int)$item['id'];
    if (!in_array($id, $pickedIds, true)) {
        $uniqueForYou[] = $item;
        $pickedIds[] = $id;
        if (count($uniqueForYou) >= $desiredCount) break;
    }
}

if (count($uniqueForYou) < $desiredCount) {
    // Пополняем из последних новостей случайным образом, исключая уже выбранные и топ-сториз
    $pool = $newsModel->getLatest(100);
    shuffle($pool);
    foreach ($pool as $cand) {
        $id = (int)$cand['id'];
        if (!in_array($id, $pickedIds, true)) {
            $uniqueForYou[] = $cand;
            $pickedIds[] = $id;
            if (count($uniqueForYou) >= $desiredCount) break;
        }
    }
}

$forYouNews = $uniqueForYou;

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