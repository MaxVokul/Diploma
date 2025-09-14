<?php
require_once 'header.php';

// Проверяем, если пользователь уже авторизован
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

$error = '';
$success = '';

// Обработка формы регистрации
if ($_POST && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = trim($_POST['phone'] ?? '');

    // Валидация
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } else {
        $userModel = new UserModel();
        $userData = [
            'username' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        ];

        $userId = $userModel->register($userData);

        if ($userId) {
            $success = 'Registration successful! You can now log in.';

            // Автоматически авторизуем пользователя
            $user = $userModel->login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                header("Location: /index.php");
                exit();
            }
        } else {
            $error = 'Email already exists';
        }
    }
}
?>

    <div class="login-container">
        <div class="login-form-wrapper">
            <h1>Create Account</h1>
            <p>Join our community to personalize your news experience.</p>

            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form class="login-form" method="POST">
                <div class="form-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="register-phone">Phone Number</label>
                    <input type="tel" id="register-phone" name="phone" class="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" placeholder="+1 (123) 456-7890">
                </div>
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required placeholder="Create password">
                </div>
                <div class="form-group">
                    <label for="register-confirm-password">Confirm Password</label>
                    <input type="password" id="register-confirm-password" name="confirm_password" required placeholder="Confirm password">
                </div>
                <button type="submit" class="btn login-btn">Register</button>
            </form>

            <div class="register-link">
                <p>Already have an account? <a href="/login.php" class="toggle-to-login">Login here</a></p>
            </div>
        </div>
    </div>

<?php require_once 'footer.php'; ?>