<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Profile");

// Проверяем, что пользователь авторизован
$isAuthenticated = true; // В реальном приложении: isset($_SESSION['user_id'])

if (!$isAuthenticated) {
    LocalRedirect("/index.php");
    exit();
}

// Тестовые данные пользователя
$userData = [
    'id' => 1,
    'username' => 'JohnDoe',
    'email' => 'john.doe@example.com',
    'phone' => '+1 (555) 123-4567',
    'joined_date' => 'January 2023',
    'last_login' => 'Today at 10:30 AM',
    'preferences' => [
        'categories' => ['Politics', 'Technology', 'World'],
        'notifications' => ['email', 'daily_digest']
    ],
    'stats' => [
        'articles_read' => 47,
        'comments_posted' => 12,
        'following' => 8
    ]
];
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
                <p class="profile-joined">Member since <?php echo htmlspecialchars($userData['joined_date']); ?></p>
            </div>
        </div>

        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-number"><?php echo $userData['stats']['articles_read']; ?></div>
                <div class="stat-label">Articles Read</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $userData['stats']['comments_posted']; ?></div>
                <div class="stat-label">Comments</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $userData['stats']['following']; ?></div>
                <div class="stat-label">Following</div>
            </div>
        </div>

        <div class="profile-section">
            <h2 class="section-title">Account Settings</h2>
            <div class="settings-grid">
                <div class="setting-item">
                    <h3>Change Password</h3>
                    <p>Update your account password</p>
                    <a href="#" class="btn btn-secondary">Change Password</a>
                </div>
                <div class="setting-item">
                    <h3>Update Profile</h3>
                    <p>Edit your personal information</p>
                    <a href="#" class="btn btn-secondary">Edit Profile</a>
                </div>
                <div class="setting-item">
                    <h3>Notification Settings</h3>
                    <p>Manage your notification preferences</p>
                    <a href="#" class="btn btn-secondary">Notifications</a>
                </div>
                <div class="setting-item">
                    <h3>Privacy Settings</h3>
                    <p>Control your privacy options</p>
                    <a href="#" class="btn btn-secondary">Privacy</a>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <h2 class="section-title">Your Interests</h2>
            <div class="interests-container">
                <p class="interests-description">Based on your reading history and preferences</p>
                <div class="interests-list">
                    <?php foreach($userData['preferences']['categories'] as $category): ?>
                        <div class="interest-tag">
                            <?php echo htmlspecialchars($category); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="#" class="btn btn-primary">Update Interests</a>
            </div>
        </div>

        <div class="profile-actions">
            <a href="#" class="btn btn-logout">Logout</a>
            <a href="#" class="btn btn-delete">Delete Account</a>
        </div>
    </div>

    <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>