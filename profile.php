<?php
session_start();


require_once 'app/core/Database.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/NewsModel.php';

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

// Получаем данные пользователя
$userModel = new UserModel();
$userData = $userModel->findById($_SESSION['user_id']);

// Получаем предпочтения пользователя
$preferences = $userModel->getPreferences($_SESSION['user_id']);

// Получаем интересы пользователя из таблицы user_interests
$userInterests = $userModel->getUserInterests($_SESSION['user_id']);

// Сообщения (флеш)
$flash_success = $_SESSION['profile_success'] ?? '';
$flash_error = $_SESSION['profile_error'] ?? '';
unset($_SESSION['profile_success'], $_SESSION['profile_error']);

// Получаем реальную статистику пользователя
$stats = $userModel->getReadStats($_SESSION['user_id']);
$stats['comments_posted'] = 0; // Пока нет системы комментариев

// Получаем категории для выбора
$newsModel = new NewsModel();
$categories = $newsModel->getAllCategories();
require_once 'header.php';
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

        <?php if ($flash_success): ?>
            <div class="message success" style="margin: 1rem 0;"><?php echo htmlspecialchars($flash_success); ?></div>
        <?php endif; ?>
        <?php if ($flash_error): ?>
            <div class="message error" style="margin: 1rem 0;"><?php echo htmlspecialchars($flash_error); ?></div>
        <?php endif; ?>

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
                    <form action="/change-password.php" method="POST" class="form form-vertical">
                        <label for="current_password">Current password</label>
                        <input type="password" id="current_password" name="current_password" required>
                        <label for="new_password">New password</label>
                        <input type="password" id="new_password" name="new_password" minlength="6" required>
                        <label for="confirm_password">Confirm new password</label>
                        <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>
                        <button type="submit" class="btn btn-secondary">Change Password</button>
                    </form>
                </div>
                <div class="setting-item">
                    <h3>Update Profile</h3>
                    <p>Edit your personal information</p>
                    <form action="/update-profile.php" method="POST" class="form form-vertical">
                        <label for="upd_username">Username</label>
                        <input type="text" id="upd_username" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                        <label for="upd_email">Email</label>
                        <input type="email" id="upd_email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                        <button type="submit" class="btn btn-secondary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <h2 class="section-title">Your Interests</h2>
            <div class="interests-container">
                <p class="interests-description">Based on your reading history and preferences</p>
                <div class="interests-list">
                    <?php if (!empty($userInterests)): ?>
                        <?php foreach($userInterests as $interest): ?>
                            <div class="interest-tag">
                                <?php echo htmlspecialchars($interest['name']); ?>
                                <span class="interest-weight">(<?php echo $interest['weight']; ?> reads)</span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reading history yet. Start reading articles to build your interests!</p>
                    <?php endif; ?>
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