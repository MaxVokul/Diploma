<?php
require_once 'header.php';

// Проверяем, если пользователь уже авторизован
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

$error = '';
$success = '';

// Обработка формы входа
if ($_POST && isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $userModel = new UserModel();
        $user = $userModel->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Перенаправляем на предыдущую страницу или на главную
            $redirect = $_SESSION['redirect_to'] ?? '/index.php';
            unset($_SESSION['redirect_to']);
            header("Location: $redirect");
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>

    <div class="login-container">
        <div class="login-form-wrapper">
            <h1>Login to NEWS</h1>
            <p>Welcome back! Please login to your account.</p>

            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- Login Form -->
            <form class="login-form" method="POST">
                <div class="form-group">
                    <label for="login-email">Email or Phone</label>
                    <input type="text" id="login-email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required placeholder="Enter your email or phone">
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required placeholder="Enter your password">
                </div>
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="#" class="btn--show-forgot-password">Forgot your password?</a>
                </div>
                <button type="submit" class="btn login-btn">Login</button>
            </form>

            <div class="register-link">
                <p>Don't have an account? <a href="/register.php" class="toggle-to-register">Register now</a></p>
            </div>
        </div>
    </div>

<?php require_once 'footer.php'; ?>