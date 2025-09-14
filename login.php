<?php
require_once 'header.php';
?>

    <div class="login-container">
        <div class="login-form-wrapper">
            <h1>Login to NEWS</h1>
            <p>Welcome back! Please login to your account.</p>

            <!-- Login Form -->
            <form class="login-form" action="/process-login.php" method="POST">
                <div class="form-group">
                    <label for="login-email">Email or Phone</label>
                    <input type="text" id="login-email" name="email" required placeholder="Enter your email or phone">
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