<?php
require_once 'header.php';

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

// Получаем данные пользователя
$userModel = new UserModel();
$userData = $userModel->findById($_SESSION['user_id']);

// Получаем предпочтения пользователя
$preferences = $userModel->getPreferences($_SESSION['user_id']);

// Получаем статистику пользователя (в реальном приложении это было бы отдельной таблицей)
$stats = [
    'articles_read' => 47,
    'comments_posted' => 12,
    'following' => 8
];

// Получаем категории для выбора
$newsModel = new NewsModel();
$categories = $newsModel->getAllCategories();
?>

    <!-- Profile Content -->
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar-container">
                <div class="profile-avatar">
                    <svg width="100%" height="100%" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="45" fill="#9A8CC1" stroke="#6C5D8F" stroke-width="2"/>
                        <path d="M50 35C58.2843 35 65 28.2843 65 20C65 11.7157 58.2843 5 50 5C41.7157 5 35 11.7157 35 20C35 28.2843 41.7157 35 50 35Z" fill="white"/>
                        <path d="M50 45C63.8071 45 75 56.1929 75 70V85H25V70C25 56.1929 36.1929 45 50 45Z" fill="white"/>
                    </svg>
                </div>
            </div>
            <div class="profile-info">
                <h1 class="profile-username"><?php echo htmlspecialchars($userData['username']); ?></h1>
                <p class="profile-email"><?php echo htmlspecialchars($userData['email']); ?></p>
                <p class="profile-joined">Member since <?php echo date('F Y', strtotime($userData['created_at'])); ?></p>
            </div>
        </div>

        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-number"><?php echo $stats['articles_read']; ?></div>
                <div class="stat-label">Articles Read</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $stats['comments_posted']; ?></div>
                <div class="stat-label">Comments</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $stats['following']; ?></div>
                <div class="stat-label">Following</div>
            </div>
        </div>

        <div class="profile-section">
            <h2 class="section-title">Account Settings</h2>
            <div class="settings-grid">
                <div class="setting-item">
                    <h3>Change Password</h3>
                    <p>Update your account password</p>
                    <a href="#" class="btn btn-secondary" onclick="alert('Change password feature will be implemented soon!')">Change Password</a>
                </div>
                <div class="setting-item">
                    <h3>Update Profile</h3>
                    <p>Edit your personal information</p>
                    <a href="#" class="btn btn-secondary" onclick="alert('Edit profile feature will be implemented soon!')">Edit Profile</a>
                </div>
                <div class="setting-item">
                    <h3>Notification Settings</h3>
                    <p>Manage your notification preferences</p>
                    <a href="#" class="btn btn-secondary" onclick="alert('Notification settings feature will be implemented soon!')">Notifications</a>
                </div>
                <div class="setting-item">
                    <h3>Privacy Settings</h3>
                    <p>Control your privacy options</p>
                    <a href="#" class="btn btn-secondary" onclick="alert('Privacy settings feature will be implemented soon!')">Privacy</a>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <h2 class="section-title">Your Interests</h2>
            <div class="interests-container">
                <p class="interests-description">Based on your reading history and preferences</p>
                <div class="interests-list">
                    <?php foreach($preferences['categories'] as $categoryName): ?>
                        <div class="interest-tag">
                            <?php echo htmlspecialchars($categoryName); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form id="preferences-form" method="POST" action="/update-preferences.php">
                    <div class="category-preferences">
                        <?php foreach($categories as $category): ?>
                            <label class="preference-item">
                                <input type="checkbox" name="categories[]" value="<?php echo htmlspecialchars($category['slug']); ?>"
                                    <?php echo in_array($category['slug'], $preferences['categories']) ? 'checked' : ''; ?>>
                                <span><?php echo htmlspecialchars($category['name']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Interests</button>
                </form>
            </div>
        </div>

        <div class="profile-actions">
            <a href="/logout.php" class="btn btn-logout">Logout</a>
            <a href="#" class="btn btn-delete" onclick="alert('Delete account feature will be implemented soon!')">Delete Account</a>
        </div>
    </div>

<?php require_once 'footer.php'; ?>