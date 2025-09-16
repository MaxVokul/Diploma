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
$forYouNews = [];

// Если пользователь авторизован — показываем персонализированные новости
if (isset($_SESSION['user_id'])) {
    $forYouNews = $newsModel->getRecommendedForUser($_SESSION['user_id'], 12);
} else {
    $forYouNews = $newsModel->getLatest(12);
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

    <section class="foryou">
        <div class="foryouh2">
            <h2 id="fy">For You</h2>
            <p>Recommended based on your interests</p>
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
                            <img src="<?php echo htmlspecialchars($newsItem['image_url'] ?? 'resources/Rectangle 20.png'); ?>" class="rectimg" alt="<?php echo htmlspecialchars($newsItem['title']); ?>">
                            <div class="recttxt">
                                <h2><?php echo htmlspecialchars($newsItem['title']); ?></h2>
                                <p><?php echo htmlspecialchars(substr($newsItem['excerpt'], 0, 150)) . (strlen($newsItem['excerpt']) > 150 ? '...' : ''); ?></p>
                            </div>
                            <p class="rectp">
                                <?php echo date('H:i', strtotime($newsItem['published_at'])); ?> ago / by <?php echo htmlspecialchars($newsItem['author_name']); ?>
                            </p>
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