<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Инициализация автозагрузчика/базы
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/NewsModel.php';

// Загружаем категории для меню
$headerCategories = [];
try {
    $newsModelForHeader = new NewsModel();
    $headerCategories = $newsModelForHeader->getAllCategories();
} catch (Exception $e) {
    $headerCategories = [];
}

?>
<?php if (isset($_SESSION['registration_errors']) && !empty($_SESSION['registration_errors'])): ?>
    <div style="position: fixed; top: 0; left: 0; right: 0; background: #f8d7da; color: #721c24; padding: 1rem; text-align: center; z-index: 9999;">
        <?php foreach ($_SESSION['registration_errors'] as $error): ?>
            <p style="margin: 0.3rem 0;"><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['registration_errors']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['login_errors']) && !empty($_SESSION['login_errors'])): ?>
    <div style="position: fixed; top: 0; left: 0; right: 0; background: #f8d7da; color: #721c24; padding: 1rem; text-align: center; z-index: 9999;">
        <?php foreach ($_SESSION['login_errors'] as $error): ?>
            <p style="margin: 0.3rem 0;"><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['login_errors']); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">

    <title>NEWS</title>
</head>
<body>

<header class="header">
    <div class="logoholder">
        <a href="#">
            <img class="hamburger" src="/resources/Hamburger_icon1.png" alt="Menu">
        </a>
        <a href="/index.php">
            <div class="mains">NEWS</div>
        </a>
    </div>
    <ol id="menu" class="ol1">
        <li><a class="li1" href="">
                <svg width="98" height="98" viewBox="0 0 98 98" fill="none" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g filter="url(#filter0_d_123_52)">
                        <rect x="4" width="90" height="90" fill="url(#pattern0_123_52)" shape-rendering="crispEdges"/>
                    </g>
                    <defs>
                        <filter id="filter0_d_123_52" x="0" y="0" width="98" height="98" filterUnits="userSpaceOnUse"
                                color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                           result="hardAlpha"/>
                            <feOffset dy="4"/>
                            <feGaussianBlur stdDeviation="2"/>
                            <feComposite in2="hardAlpha" operator="out"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_123_52"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_123_52" result="shape"/>
                        </filter>
                        <pattern id="pattern0_123_52" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_123_52" transform="scale(0.0111111)"/>
                        </pattern>
                        <image id="image0_123_52" width="90" height="90"
                               xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAv0lEQVR4nO3awWrCQABF0Ys7/XxrqV9pu2m3kUDWYmahAz0H8gOXMAN5KQAAAAAAAADe6lR9Vj/V4ulRg+/qUh1HQl/Fbe8Ltjbb5VD9Cd3e0L9bO6GbLLSjo6HQXw1YD/aP7aB3Gfawwa06j16GAAAAAAD/nHG2p7/DG2d77WhhnO01oY2zTRp65b+OjLPLZIOxcRYAAAAAYJxxNuPsMsHHfuNs7wttnG3S0CvjbMbZZYLz2DgLAAAAAAAA0GTuqD9gUMDt6+cAAAAASUVORK5CYII="/>
                    </defs>
                </svg>
            </a>
            <ol class="ol2">
                <li>
                    <a href="/index.php">Home</a>
                </li>
                <li>
                    <a href="#">For you</a>
                </li>
                <li>
                    <a href="#">Following</a>
                </li>
                <li>
                    <a href="#">World</a>
                </li>
                <li>
                    <a href="/aboutus.html">About us</a>
                </li>
            </ol>
        </li>
    </ol>
    <div class="nav">
        <ul><li>
                <a href="/index.php">
                    <h3>Home</h3>
                </a>
                </a></li>
            <li><a href="#fy"><h3>For you</h3></a></li>
            <li><h3>Following</h3></li>
            <li><h3>World</h3></li>
            <a href="/aboutus.html">
                <li id="right"><h3>About us</h3></li>
            </a>
        </ul>
    </div>
    <div class="rightpanel">
        <input id="mobsearch" class="rpl" type="text" placeholder="Search">
        <svg class="rpl" width="51" height="44" viewBox="0 0 51 44" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M12.75 0C9.24375 0 6.12 1.46625 3.76125 3.76125C1.46625 6.05625 0 9.18 0 12.75C0 16.2563 1.46625 19.38 3.76125 21.7388L25.5 43.4775L47.2388 21.7388C49.5337 19.4438 51 16.32 51 12.75C51 9.24375 49.5337 6.12 47.2388 3.76125C44.9437 1.46625 41.82 0 38.25 0C34.7438 0 31.62 1.46625 29.2613 3.76125C26.9663 6.05625 25.5 9.18 25.5 12.75C25.5 9.24375 24.0338 6.12 21.7388 3.76125C19.4438 1.46625 16.32 0 12.75 0Z"
                  fill="black"/>
        </svg>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
            // Подключаем модель пользователя для проверки прав админа
            require_once 'app/models/UserModel.php';
            $userModelHeaderCheck = new UserModel();
            $isAdmin = $userModelHeaderCheck->isAdmin($_SESSION['user_id']);
            ?>
            <a href="/profile.php" class="btn--show-modal-window profile-link" title="Профиль">
                <svg class="rpl" width="52" height="46" viewBox="0 0 52 46" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.307 0V6.43568H45.0497V38.6141H19.307V45.0497H51.4854V0H19.307ZM25.7427 12.8714V19.307H0V25.7427H25.7427V32.1784L38.6141 22.5249L25.7427 12.8714Z"
                          fill="black"/>
                </svg>
            </a>
            <?php if ($isAdmin): ?>
                <a href="/admin/" class="admin-link" title="Админ-панель">
                    <!-- Можно использовать SVG иконку шестерёнки -->
                    <svg class="rpl" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.4 15C19.2667 15.4667 19.0667 15.9 18.8 16.3C18.5333 16.7 18.2 17.0333 17.8 17.3C17.4 17.5667 16.9667 17.7667 16.5 17.9C16.0333 18.0333 15.5333 18.1 15 18.1C14.4667 18.1 13.9667 18.0333 13.5 17.9C13.0333 17.7667 12.6 17.5667 12.2 17.3C11.8 17.0333 11.4667 16.7 11.2 16.3C10.9333 15.9 10.7333 15.4667 10.6 15C10.4667 14.5333 10.4 14.0333 10.4 13.5C10.4 12.9667 10.4667 12.4667 10.6 12C10.7333 11.5333 10.9333 11.1 11.2 10.7C11.4667 10.3 11.8 9.96667 12.2 9.7C12.6 9.43333 13.0333 9.23333 13.5 9.1C13.9667 8.96667 14.4667 8.9 15 8.9C15.5333 8.9 16.0333 8.96667 16.5 9.1C16.9667 9.23333 17.4 9.43333 17.8 9.7C18.2 9.96667 18.5333 10.3 18.8 10.7C19.0667 11.1 19.2667 11.5333 19.4 12C19.5333 12.4667 19.6 12.9667 19.6 13.5C19.6 14.0333 19.5333 14.5333 19.4 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 12C22 13.0609 21.5786 14.0783 20.8284 14.8284C20.0783 15.5786 19.0609 16 18 16C16.9391 16 15.9217 15.5786 15.1716 14.8284C14.4214 14.0783 14 13.0609 14 12C14 10.9391 14.4214 9.92172 15.1716 9.17157C15.9217 8.42143 16.9391 8 18 8C19.0609 8 20.0783 8.42143 20.8284 9.17157C21.5786 9.92172 22 10.9391 22 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12C2 13.0609 2.42143 14.0783 3.17157 14.8284C3.92172 15.5786 4.93913 16 6 16C7.06087 16 8.07828 15.5786 8.82843 14.8284C9.57857 14.0783 10 13.0609 10 12C10 10.9391 9.57857 9.92172 8.82843 9.17157C8.07828 8.42143 7.06087 8 6 8C4.93913 8 3.92172 8.42143 3.17157 9.17157C2.42143 9.92172 2 10.9391 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            <?php endif; ?>
        <?php else: ?>
            <a href="#" class="btn--show-modal-window profile-link">
                <svg class="rpl" width="52" height="46" viewBox="0 0 52 46" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.307 0V6.43568H45.0497V38.6141H19.307V45.0497H51.4854V0H19.307ZM25.7427 12.8714V19.307H0V25.7427H25.7427V32.1784L38.6141 22.5249L25.7427 12.8714Z"
                          fill="black"/>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</header>

<?php if (isset($_SESSION['user_id'])): ?>
    <div id="user-authenticated" style="display: none;"></div>
<?php endif; ?>

<!-- Modal window -->
<div class="modal-window hidden">
    <button class="btn--close-modal-window">×</button>
    <!-- Toggle buttons -->
    <div class="modal-toggle">
        <button class="toggle-btn active" data-tab="login">Login</button>
        <button class="toggle-btn" data-tab="register">Register</button>
    </div>
    <!-- Login Form -->
    <form class="modal__form login-form" style="display: flex;" action="/login-process.php" method="POST">
        <label for="login-email">Email</label>
        <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
        <label for="login-password">Password</label>
        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
        <button type="submit" class="btn">Login →</button>
    </form>
    <!-- Register Form -->
    <form class="modal__form register-form" style="display: none;" action="/register-process.php" method="POST">
        <label for="register-name">Full Name</label>
        <input type="text" id="register-name" name="name" placeholder="Enter your full name" required>
        <label for="register-email">Email</label>
        <input type="email" id="register-email" name="email" placeholder="Enter your email" required>
        <label for="register-phone">Phone Number</label>
        <input type="tel" id="register-phone" name="phone" class="phone" placeholder="Enter your phone">
        <label for="register-password">Password</label>
        <input type="password" id="register-password" name="password" placeholder="Create password" required>
        <label for="register-confirm-password">Confirm Password</label>
        <input type="password" id="register-confirm-password" name="confirm_password" placeholder="Confirm password" required>
        <button type="submit" class="btn">Register →</button>
    </form>
</div>
<div class="overlay hidden"></div>

<!-- Sliding Left Menu -->
<div class="slide-menu hidden">
    <div class="slide-menu__content">
        <button class="btn--close-slide-menu">×</button>
        <nav class="slide-nav">
            <ul>
                <?php if (!empty($headerCategories)): ?>
                    <?php foreach ($headerCategories as $cat): ?>
                        <li>
                            <a href="/category.php?category=<?php echo htmlspecialchars($cat['slug']); ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="#">No categories</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>

<!-- Overlay for blur -->
<div class="slide-overlay hidden"></div>

<main>